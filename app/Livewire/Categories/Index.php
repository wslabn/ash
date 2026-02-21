<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        ProductCategory::where('user_id', auth()->id())->findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        $categories = ProductCategory::where('user_id', auth()->id())
            ->where('name', 'like', '%'.$this->search.'%')
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.categories.index', compact('categories'));
    }
}
