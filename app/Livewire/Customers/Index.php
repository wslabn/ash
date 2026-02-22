<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteId = null;
    public $filterRecruiting = false;
    public $filterConverted = false;

    public function mount()
    {
        $this->filterRecruiting = request()->has('recruiting');
        $this->filterConverted = request()->has('converted');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            Customer::find($this->deleteId)->delete();
            $this->deleteId = null;
            session()->flash('message', 'Customer deleted successfully.');
        }
    }

    public function render()
    {
        $query = Customer::where('user_id', auth()->id());
        
        // Apply recruiting filter
        if ($this->filterRecruiting) {
            $query->where('recruiting_interest', true)
                  ->whereNull('converted_to_user_id');
        }
        
        // Apply converted filter
        if ($this->filterConverted) {
            $query->whereNotNull('converted_to_user_id');
        }
        
        // Apply search
        $query->where(function($q) {
            $q->where('first_name', 'like', '%'.$this->search.'%')
              ->orWhere('last_name', 'like', '%'.$this->search.'%')
              ->orWhere('email', 'like', '%'.$this->search.'%')
              ->orWhere('phone', 'like', '%'.$this->search.'%');
        });
        
        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.customers.index', [
            'customers' => $customers
        ])->layout('layouts.app');
    }
}
