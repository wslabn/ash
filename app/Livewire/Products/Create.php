<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Inventory;

class Create extends Component
{
    public $name = '';
    public $sku = '';
    public $category_id = '';
    public $base_cost = 0;
    public $base_retail_price = 0;
    public $quantity = 0;
    public $low_stock_threshold = 5;

    protected $rules = [
        'name' => 'required|string|max:255',
        'base_cost' => 'required|numeric|min:0',
        'base_retail_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ];

    public function save()
    {
        $this->validate();

        $product = Product::create([
            'user_id' => auth()->id(),
            'category_id' => $this->category_id ?: null,
            'name' => $this->name,
            'sku' => $this->sku,
            'base_cost' => $this->base_cost,
            'base_retail_price' => $this->base_retail_price,
        ]);

        // Create inventory record
        Inventory::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $this->quantity,
            'cost_per_unit' => $this->base_cost,
            'retail_price' => $this->base_retail_price,
            'low_stock_threshold' => $this->low_stock_threshold,
        ]);

        session()->flash('message', 'Product created successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        $categories = ProductCategory::where('user_id', auth()->id())
            ->orWhere('is_system', true)
            ->get();

        return view('livewire.products.create', [
            'categories' => $categories
        ])->layout('layouts.app');
    }
}
