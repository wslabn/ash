<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\ReturnItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class ProcessReturn extends Component
{
    public $showModal = false;
    public $step = 1; // 1 = select sale, 2 = process return
    public $search = '';
    public $selectedSale = null;
    public $returnItems = [];
    public $restoreInventory = true;
    public $returnReason = '';

    #[On('openProcessReturn')]
    public function openModal()
    {
        $this->showModal = true;
        $this->step = 1;
    }

    public function selectSale($saleId)
    {
        $this->selectedSale = Sale::with(['customer', 'items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($saleId);
        
        // Initialize return items
        foreach ($this->selectedSale->items as $item) {
            $this->returnItems[$item->id] = [
                'selected' => false,
                'quantity' => 0,
                'max_quantity' => $item->quantity,
            ];
        }
        
        $this->step = 2;
    }

    public function backToSearch()
    {
        $this->step = 1;
        $this->selectedSale = null;
        $this->returnItems = [];
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['step', 'search', 'selectedSale', 'returnItems', 'restoreInventory', 'returnReason']);
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
                'sale_id' => $this->selectedSale->id,
                'user_id' => auth()->id(),
                'customer_id' => $this->selectedSale->customer_id,
                'return_number' => 'RET-' . str_pad(SaleReturn::where('user_id', auth()->id())->count() + 1, 3, '0', STR_PAD_LEFT),
                'total_amount' => 0,
                'restore_inventory' => $this->restoreInventory,
                'reason' => $this->returnReason,
                'status' => 'completed',
                'returned_at' => now(),
            ]);

            foreach ($selectedItems as $itemId => $returnData) {
                $saleItem = $this->selectedSale->items->find($itemId);
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
            $this->closeModal();
            session()->flash('message', "Return processed successfully! Refund amount: $" . number_format($totalRefund, 2));
            $this->dispatch('returnProcessed');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error processing return: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $sales = [];
        if ($this->step === 1 && strlen($this->search) >= 2) {
            $sales = Sale::with('customer')
                ->where('user_id', auth()->id())
                ->where(function($query) {
                    $query->where('sale_number', 'like', '%' . $this->search . '%')
                          ->orWhereHas('customer', function($q) {
                              $q->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                          });
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('livewire.process-return', compact('sales'));
    }
}
