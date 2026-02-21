<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    
    // Inventory adjustment modal
    public $showAdjustModal = false;
    public $adjustProductId;
    public $adjustProductName;
    public $adjustType = 'add';
    public $adjustQuantity;
    public $adjustReason;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Product::where('user_id', auth()->id())->findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }
    
    public function openAdjustModal($productId, $productName)
    {
        $this->adjustProductId = $productId;
        $this->adjustProductName = $productName;
        $this->showAdjustModal = true;
    }
    
    public function closeAdjustModal()
    {
        $this->showAdjustModal = false;
        $this->reset(['adjustProductId', 'adjustProductName', 'adjustType', 'adjustQuantity', 'adjustReason']);
    }
    
    public function saveAdjustment()
    {
        $this->validate([
            'adjustQuantity' => 'required|integer|min:1',
            'adjustReason' => 'required|string|max:255',
        ]);
        
        $inventory = \App\Models\Inventory::where('user_id', auth()->id())
            ->where('product_id', $this->adjustProductId)
            ->first();
            
        if ($inventory) {
            if ($this->adjustType === 'add') {
                $inventory->increment('quantity', $this->adjustQuantity);
            } else {
                $inventory->decrement('quantity', $this->adjustQuantity);
            }
            
            // Log the adjustment (we'll add this table later if needed)
            // For now, just update the inventory
        }
        
        $this->closeAdjustModal();
        session()->flash('message', 'Inventory adjusted successfully!');
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
