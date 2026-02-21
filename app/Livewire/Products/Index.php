<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

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
        Product::where('user_id', auth()->id())->findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function render()
    {
        $products = Product::where('user_id', auth()->id())
            ->with(['category', 'inventory'])
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.products.index', [
            'products' => $products
        ])->layout('layouts.app');
    }
}
