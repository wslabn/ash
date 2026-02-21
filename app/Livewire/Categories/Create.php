<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name;
    public $description;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        ProductCategory::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'description' => $this->description,
            'is_system' => false,
        ]);

        session()->flash('message', 'Category created successfully!');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
