<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Services\DiscordNotificationService;

class Create extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $address_line1 = '';
    public $city = '';
    public $state = '';
    public $zip_code = '';
    public $how_met = '';
    public $notes = '';

    protected $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
    ];

    public function save()
    {
        $this->validate();

        $customer = Customer::create([
            'user_id' => auth()->id(),
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
        
        // Check for customer count milestone
        $totalCustomers = Customer::where('user_id', auth()->id())->count();
        if (in_array($totalCustomers, [10, 25, 50, 100, 250, 500, 1000])) {
            DiscordNotificationService::sendMilestone(auth()->user(), 'customers', "👥 {$totalCustomers} customers!");
        }

        session()->flash('message', 'Customer created successfully.');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.customers.create')->layout('layouts.app');
    }
}
