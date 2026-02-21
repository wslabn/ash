<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Edit extends Component
{
    public $productId;
    public $name;
    public $sku;
    public $description;
    public $category_id;
    public $base_cost;
    public $base_retail_price;

    public function mount($id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);
        
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->category_id = $product->category_id;
        $this->base_cost = $product->base_cost;
        $this->base_retail_price = $product->base_retail_price;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $this->productId,
            'category_id' => 'required|exists:product_categories,id',
            'base_cost' => 'required|numeric|min:0',
            'base_retail_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($this->productId);
        $product->update([
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'base_cost' => $this->base_cost,
            'base_retail_price' => $this->base_retail_price,
        ]);

        session()->flash('message', 'Product updated successfully!');
        return redirect()->route('products.index');
    }

    public function render()
    {
        $categories = ProductCategory::where('user_id', auth()->id())->get();
        return view('livewire.products.edit', compact('categories'));
    }
}
