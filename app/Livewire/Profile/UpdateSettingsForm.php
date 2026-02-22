<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class UpdateSettingsForm extends Component
{
    public $sale_starting_number;

    public function mount()
    {
        $this->sale_starting_number = auth()->user()->getSetting('sale_starting_number', 1);
    }

    public function save()
    {
        $this->validate([
            'sale_starting_number' => 'required|integer|min:1|max:99999',
        ]);

        auth()->user()->setSetting('sale_starting_number', $this->sale_starting_number);

        session()->flash('settings-saved', 'Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.profile.update-settings-form');
    }
}
