<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
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

    public function render()
    {
        $sales = Sale::with(['customer', 'user'])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->when($this->search, function($query) {
                $query->where('sale_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function($q) {
                        $q->where('first_name', 'like', '%' . $this->search . '%')
                          ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.sales.index', compact('sales'));
    }
}
