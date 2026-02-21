<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;
    public $totalSpent;
    public $totalOrders;
    public $lastPurchase;

    public function mount($id)
    {
        $this->customer = Customer::with(['sales.items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        $this->totalSpent = $this->customer->sales->sum('total_amount');
        $this->totalOrders = $this->customer->sales->count();
        $this->lastPurchase = $this->customer->sales->sortByDesc('created_at')->first()?->created_at;
    }

    public function render()
    {
        return view('livewire.customers.show');
    }
}
