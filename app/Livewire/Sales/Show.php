<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\ReturnItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class Show extends Component
{
    public Sale $sale;
    public $showReturnModal = false;
    public $returnItems = [];
    public $restoreInventory = true;
    public $returnReason = '';

    public function mount($id)
    {
        $this->sale = Sale::with(['customer', 'items.product', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        // Initialize return items
        foreach ($this->sale->items as $item) {
            $this->returnItems[$item->id] = [
                'selected' => false,
                'quantity' => 0,
                'max_quantity' => $item->quantity,
            ];
        }
    }

    #[On('openReturnModal')]
    public function openReturnModal()
    {
        $this->showReturnModal = true;
    }

    public function closeReturnModal()
    {
        $this->showReturnModal = false;
    }

    public function processReturn()
    {
        $selectedItems = collect($this->returnItems)->filter(fn($item) => $item['selected'] && $item['quantity'] > 0);
        
        if ($selectedItems->isEmpty()) {
            session()->flash('error', 'Please select at least one item to return.');
            return;
        }

        $this->validate([
            'returnReason' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $totalRefund = 0;
            
            $return = SaleReturn::create([
                'sale_id' => $this->sale->id,
                'user_id' => auth()->id(),
                'customer_id' => $this->sale->customer_id,
                'return_number' => 'RET-' . str_pad(SaleReturn::where('user_id', auth()->id())->count() + 1, 3, '0', STR_PAD_LEFT),
                'total_amount' => 0,
                'restore_inventory' => $this->restoreInventory,
                'reason' => $this->returnReason,
                'status' => 'completed',
                'returned_at' => now(),
            ]);

            foreach ($selectedItems as $itemId => $returnData) {
                $saleItem = $this->sale->items->find($itemId);
                $refundAmount = $saleItem->unit_price * $returnData['quantity'];
                $totalRefund += $refundAmount;

                ReturnItem::create([
                    'return_id' => $return->id,
                    'sale_item_id' => $saleItem->id,
                    'product_id' => $saleItem->product_id,
                    'quantity' => $returnData['quantity'],
                    'refund_amount' => $refundAmount,
                ]);

                if ($this->restoreInventory) {
                    $inventory = Inventory::where('user_id', auth()->id())
                        ->where('product_id', $saleItem->product_id)
                        ->first();
                    if ($inventory) {
                        $inventory->increment('quantity', $returnData['quantity']);
                    }
                }
            }

            $return->update(['total_amount' => $totalRefund]);

            DB::commit();
            $this->closeReturnModal();
            session()->flash('message', "Return processed successfully! Refund amount: $" . number_format($totalRefund, 2));
            $this->sale->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error processing return: ' . $e->getMessage());
        }
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('invoices.pdf', ['sale' => $this->sale]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'invoice-' . $this->sale->sale_number . '.pdf');
    }

    public function emailInvoice()
    {
        if (!$this->sale->customer->email) {
            session()->flash('error', 'Customer does not have an email address.');
            return;
        }

        try {
            $pdf = Pdf::loadView('invoices.pdf', ['sale' => $this->sale]);
            
            \Illuminate\Support\Facades\Mail::send('emails.invoice', ['sale' => $this->sale], function($message) use ($pdf) {
                $message->to($this->sale->customer->email, $this->sale->customer->full_name)
                    ->subject('Invoice ' . $this->sale->sale_number . ' from ' . $this->sale->user->name)
                    ->attachData($pdf->output(), 'invoice-' . $this->sale->sale_number . '.pdf');
            });

            session()->flash('message', 'Invoice emailed to ' . $this->sale->customer->email);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.sales.show');
    }
}
