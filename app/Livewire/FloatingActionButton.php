<?php

namespace App\Livewire;

use Livewire\Component;

class FloatingActionButton extends Component
{
    public $isOpen = false;
    public $context = 'global'; // global, customer, product, sales
    public $customerId = null;

    public function mount($context = 'global', $customerId = null)
    {
        $this->context = $context;
        $this->customerId = $customerId;
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.floating-action-button');
    }
}
