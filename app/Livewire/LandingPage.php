<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Customer;
use Livewire\Attributes\Layout;

#[Layout('layouts.landing')]
class LandingPage extends Component
{
    public User $consultant;
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $message = '';
    public $submitted = false;

    public function mount($slug)
    {
        $this->consultant = User::where('slug', $slug)
            ->where('landing_page_enabled', true)
            ->firstOrFail();
    }

    public function submit()
    {
        $this->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000',
        ]);

        Customer::create([
            'user_id' => $this->consultant->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => 'Contact form: ' . $this->message,
            'how_met' => 'Landing Page',
        ]);

        $this->submitted = true;
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'message']);
    }

    public function render()
    {
        return view('livewire.landing-page');
    }
}
