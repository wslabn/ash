<?php

namespace App\Livewire\Returns;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SaleReturn;
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
        $returns = SaleReturn::with(['sale', 'customer', 'items.product'])
            ->where('user_id', auth()->id())
            ->where(function($query) {
                $query->where('return_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function($q) {
                          $q->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.returns.index', compact('returns'));
    }
}
