<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->showResults = true;
        $userId = auth()->id();

        $this->results = [
            'customers' => Customer::where('user_id', $userId)
                ->where(function($q) {
                    $q->where('first_name', 'like', '%' . $this->query . '%')
                      ->orWhere('last_name', 'like', '%' . $this->query . '%')
                      ->orWhere('email', 'like', '%' . $this->query . '%');
                })
                ->limit(5)
                ->get(),
            'products' => Product::where('user_id', $userId)
                ->where(function($q) {
                    $q->where('name', 'like', '%' . $this->query . '%')
                      ->orWhere('sku', 'like', '%' . $this->query . '%')
                      ->orWhereHas('category', function($query) {
                          $query->where('name', 'like', '%' . $this->query . '%');
                      });
                })
                ->limit(5)
                ->get(),
            'sales' => Sale::where('user_id', $userId)
                ->where('sale_number', 'like', '%' . $this->query . '%')
                ->with('customer')
                ->limit(5)
                ->get(),
        ];
    }

    public function closeResults()
    {
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
