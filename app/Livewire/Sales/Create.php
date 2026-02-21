<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $customer_id;
    public $sale_type = 'retail';
    public $payment_method = 'cash';
    public $items = [];
    public $tax_rate = 8.25;

    public function mount()
    {
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'unit_price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        if (str_contains($key, 'product_id')) {
            $index = explode('.', $key)[0];
            $product = Product::find($this->items[$index]['product_id']);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->retail_price;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_type' => 'required|in:retail,party,online',
            'payment_method' => 'required|in:cash,card,check,venmo,paypal',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = collect($this->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
            $tax = $subtotal * ($this->tax_rate / 100);
            $total = $subtotal + $tax;

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $this->customer_id,
                'sale_number' => 'SALE-' . str_pad(Sale::where('user_id', auth()->id())->count() + 1, 3, '0', STR_PAD_LEFT),
                'sale_type' => $this->sale_type,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'payment_status' => 'paid',
                'payment_method' => $this->payment_method,
            ]);

            foreach ($this->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                $inventory = Inventory::where('user_id', auth()->id())
                    ->where('product_id', $item['product_id'])
                    ->first();
                if ($inventory) {
                    $inventory->decrement('quantity_on_hand', $item['quantity']);
                }
            }

            DB::commit();
            session()->flash('message', 'Sale created successfully!');
            return redirect()->route('sales.show', $sale);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating sale: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $customers = Customer::where('user_id', auth()->id())->get();
        $products = Product::where('user_id', auth()->id())->get();
        
        return view('livewire.sales.create', compact('customers', 'products'));
    }
}
