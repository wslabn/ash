<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\CustomerNote;
use App\Models\User;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $this->customer = Customer::with(['sales.items.product', 'customerNotes.user', 'convertedToUser'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        $this->totalSpent = $this->customer->sales->sum('total_amount');
        $this->totalOrders = $this->customer->sales->count();
        $this->lastPurchase = $this->customer->sales->sortByDesc('created_at')->first()?->created_at;
    }

    public function toggleRecruitingInterest()
    {
        $this->customer->update([
            'recruiting_interest' => !$this->customer->recruiting_interest
        ]);
        $this->customer->refresh();
        session()->flash('message', 'Recruiting interest updated.');
    }

    public function convertToConsultant()
    {
        if ($this->customer->converted_to_user_id) {
            session()->flash('error', 'Customer already converted to consultant.');
            return;
        }

        if (!$this->customer->email) {
            session()->flash('error', 'Customer must have an email address.');
            return;
        }

        $password = Str::random(12);
        
        $user = User::create([
            'name' => $this->customer->full_name,
            'email' => $this->customer->email,
            'password' => Hash::make($password),
            'role' => 'consultant',
            'phone' => $this->customer->phone,
            'recruited_by' => auth()->id(),
            'status' => 'active',
        ]);

        $this->customer->update([
            'converted_to_user_id' => $user->id,
            'recruiting_interest' => false,
        ]);

        $this->customer->refresh();
        session()->flash('message', "Consultant created! Email: {$user->email} | Password: {$password}");
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
