<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\CustomerNote;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;
    public $totalSpent;
    public $totalOrders;
    public $lastPurchase;
    public $newNote = '';

    public function mount($id)
    {
        $this->customer = Customer::with(['sales.items.product', 'customerNotes.user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        $this->totalSpent = $this->customer->sales->sum('total_amount');
        $this->totalOrders = $this->customer->sales->count();
        $this->lastPurchase = $this->customer->sales->sortByDesc('created_at')->first()?->created_at;
    }

    public function addNote()
    {
        $this->validate([
            'newNote' => 'required|string|max:1000',
        ]);

        CustomerNote::create([
            'customer_id' => $this->customer->id,
            'user_id' => auth()->id(),
            'note' => $this->newNote,
        ]);

        $this->newNote = '';
        $this->customer->load('customerNotes.user');
        session()->flash('message', 'Note added successfully.');
    }

    public function deleteNote($noteId)
    {
        CustomerNote::where('id', $noteId)
            ->where('user_id', auth()->id())
            ->delete();

        $this->customer->load('customerNotes.user');
        session()->flash('message', 'Note deleted successfully.');
    }

    public function render()
    {
        return view('livewire.customers.show');
    }
}
