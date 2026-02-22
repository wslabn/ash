<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Product $product;
    public $totalSold;
    public $totalRevenue;
    public $totalProfit;
    public $currentStock;

    public function mount($id)
    {
        $this->product = Product::with(['category', 'saleItems.sale.customer', 'inventory'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        $this->totalSold = $this->product->saleItems->sum('quantity');
        $this->totalRevenue = $this->product->saleItems->sum('subtotal');
        $this->totalProfit = $this->product->saleItems->sum(function($item) {
            return ($item->unit_price - $item->unit_cost) * $item->quantity;
        });
        $this->currentStock = $this->product->inventory->first()?->quantity ?? 0;
    }

    public function render()
    {
        return view('livewire.products.show');
    }
}
