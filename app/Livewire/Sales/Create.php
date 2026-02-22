<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Inventory;
use App\Services\DiscordNotificationService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $customer_id;
    public $sale_type = 'direct';
    public $payment_method = 'cash';
    public $items = [];
    public $tax_rate = 8.25;
    public $shipping_amount = 0;
    
    // Quick add customer modal
    public $showCustomerModal = false;
    public $newCustomerFirstName;
    public $newCustomerLastName;
    public $newCustomerPhone;
    public $newCustomerEmail;
    public $newCustomerHowMet;

    public function mount()
    {
        // Pre-select customer from query parameter
        if (request()->has('customer_id')) {
            $this->customer_id = request()->get('customer_id');
        }
        
        $this->addItem();
    }

    public function getSubtotalProperty()
    {
        return collect($this->items)->sum(fn($item) => ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0));
    }

    public function getTaxProperty()
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax + ($this->shipping_amount ?? 0);
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'unit_price' => 0, 'original_price' => 0];
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
                $this->items[$index]['unit_price'] = $product->base_retail_price;
                $this->items[$index]['original_price'] = $product->base_retail_price;
            }
        }
    }
    
    public function openCustomerModal()
    {
        $this->showCustomerModal = true;
    }
    
    public function closeCustomerModal()
    {
        $this->showCustomerModal = false;
        $this->reset(['newCustomerFirstName', 'newCustomerLastName', 'newCustomerPhone', 'newCustomerEmail', 'newCustomerHowMet']);
    }
    
    public function saveQuickCustomer()
    {
        $this->validate([
            'newCustomerFirstName' => 'required|string|max:255',
            'newCustomerLastName' => 'required|string|max:255',
            'newCustomerPhone' => 'nullable|string|max:20',
            'newCustomerEmail' => 'nullable|email|max:255',
            'newCustomerHowMet' => 'nullable|string|max:255',
        ]);
        
        $customer = Customer::create([
            'user_id' => auth()->id(),
            'first_name' => $this->newCustomerFirstName,
            'last_name' => $this->newCustomerLastName,
            'phone' => $this->newCustomerPhone,
            'email' => $this->newCustomerEmail,
            'how_met' => $this->newCustomerHowMet,
        ]);
        
        $this->customer_id = $customer->id;
        $this->closeCustomerModal();
        $this->dispatch('customer-added');
    }

    public function save()
    {
        $this->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_type' => 'required|in:direct,party,online',
            'payment_method' => 'required|in:cash,card,check,venmo,paypal',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = collect($this->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
            $tax = $subtotal * ($this->tax_rate / 100);
            $total = $subtotal + $tax + $this->shipping_amount;

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $this->customer_id,
                'sale_number' => $this->generateSaleNumber(),
                'sale_type' => $this->sale_type,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $this->shipping_amount,
                'total_amount' => $total,
                'payment_status' => 'paid',
                'payment_method' => $this->payment_method,
            ]);

            foreach ($this->items as $item) {
                $product = Product::find($item['product_id']);
                $discountAmount = ($item['original_price'] - $item['unit_price']) * $item['quantity'];
                
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $product->base_cost,
                    'unit_price' => $item['unit_price'],
                    'discount_amount' => $discountAmount,
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                $inventory = Inventory::where('user_id', auth()->id())
                    ->where('product_id', $item['product_id'])
                    ->first();
                if ($inventory) {
                    $inventory->decrement('quantity', $item['quantity']);
                    
                    // Low stock alert
                    if ($inventory->quantity <= 5 && $inventory->quantity > 0) {
                        DiscordNotificationService::sendLowStockAlert(auth()->user(), $product, $inventory->quantity);
                    }
                }
            }
            
            // Check for milestones
            $this->checkMilestones($sale);

            DB::commit();
            session()->flash('message', 'Sale created successfully!');
            return redirect()->route('sales.show', $sale);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating sale: ' . $e->getMessage());
        }
    }

    private function generateSaleNumber()
    {
        $startingNumber = auth()->user()->getSetting('sale_starting_number', 1);
        $count = Sale::where('user_id', auth()->id())->count();
        $number = $startingNumber + $count;
        return str_pad($number, max(4, strlen($number)), '0', STR_PAD_LEFT);
    }

    private function checkMilestones($sale)
    {
        $user = auth()->user();
        $totalSales = Sale::where('user_id', $user->id)->count();
        $totalRevenue = Sale::where('user_id', $user->id)->sum('total_amount');
        $totalCustomers = Customer::where('user_id', $user->id)->count();
        
        // Sales count milestones
        if (in_array($totalSales, [10, 25, 50, 100, 250, 500, 1000])) {
            DiscordNotificationService::sendMilestone($user, 'sales', "🎉 {$totalSales} sales completed!");
        }
        
        // Revenue milestones
        $revenueMilestones = [1000, 5000, 10000, 25000, 50000, 100000];
        foreach ($revenueMilestones as $milestone) {
            if ($totalRevenue >= $milestone && ($totalRevenue - $sale->total_amount) < $milestone) {
                DiscordNotificationService::sendMilestone($user, 'sales', "💰 $" . number_format($milestone) . " in total revenue!");
            }
        }
    }

    public function render()
    {
        $customers = Customer::where('user_id', auth()->id())->get();
        $products = Product::where('user_id', auth()->id())->get();
        
        return view('livewire.sales.create', compact('customers', 'products'));
    }
}
