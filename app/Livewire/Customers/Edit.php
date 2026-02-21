<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;

class Edit extends Component
{
    public $customerId;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address_line1;
    public $city;
    public $state;
    public $zip_code;
    public $how_met;
    public $notes;

    protected $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
    ];

    public function mount($id)
    {
        $customer = Customer::where('user_id', auth()->id())->findOrFail($id);
        
        $this->customerId = $customer->id;
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address_line1 = $customer->address_line1;
        $this->city = $customer->city;
        $this->state = $customer->state;
        $this->zip_code = $customer->zip_code;
        $this->how_met = $customer->how_met;
        $this->notes = $customer->notes;
    }

    public function update()
    {
        $this->validate();

        $customer = Customer::where('user_id', auth()->id())->findOrFail($this->customerId);
        
        $customer->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line1' => $this->address_line1,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'how_met' => $this->how_met,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Customer updated successfully.');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.customers.edit')->layout('layouts.app');
    }
}
