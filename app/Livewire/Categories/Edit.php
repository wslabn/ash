<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Edit extends Component
{
    public $categoryId;
    public $name;
    public $description;

    public function mount($id)
    {
        $category = ProductCategory::where('user_id', auth()->id())->findOrFail($id);
        
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = ProductCategory::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category updated successfully!');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
