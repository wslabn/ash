<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;

class Show extends Component
{
    public Sale $sale;

    public function mount($id)
    {
        $this->sale = Sale::with(['customer', 'items.product', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.sales.show');
    }
}
