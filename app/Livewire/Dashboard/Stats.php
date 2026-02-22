<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\ReturnItem;
use Illuminate\Support\Facades\DB;

class Stats extends Component
{
    public function render()
    {
        $userId = auth()->id();
        
        // Sales summary
        $totalSales = Sale::where('user_id', $userId)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        $salesCount = Sale::where('user_id', $userId)->count();
        
        // Inventory value
        $inventoryValue = Inventory::where('user_id', $userId)
            ->sum(DB::raw('quantity * cost_per_unit'));
        
        // Top customers
        $topCustomers = Customer::where('user_id', $userId)
            ->withCount('sales')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();
        
        // Best selling products
        $bestProducts = Product::where('user_id', $userId)
            ->withCount('saleItems')
            ->orderBy('sale_items_count', 'desc')
            ->limit(5)
            ->get();
        
        // Profit calculation
        $totalProfit = Sale::where('user_id', $userId)
            ->where('payment_status', 'paid')
            ->get()
            ->sum(function($sale) {
                return $sale->items->sum(function($item) {
                    return ($item->unit_price - $item->unit_cost) * $item->quantity;
                });
            });
        
        // Most returned products
        $mostReturned = Product::where('user_id', $userId)
            ->withSum('returnItems', 'quantity')
            ->having('return_items_sum_quantity', '>', 0)
            ->orderBy('return_items_sum_quantity', 'desc')
            ->limit(5)
            ->get();

        // Recruiting pipeline
        $recruitingInterest = Customer::where('user_id', $userId)
            ->where('recruiting_interest', true)
            ->whereNull('converted_to_user_id')
            ->count();
        
        $convertedConsultants = Customer::where('user_id', $userId)
            ->whereNotNull('converted_to_user_id')
            ->count();
        
        $activeTeamMembers = \App\Models\User::where('recruited_by', $userId)
            ->where('status', 'active')
            ->count();

        return view('livewire.dashboard.stats', [
            'totalSales' => $totalSales,
            'salesCount' => $salesCount,
            'inventoryValue' => $inventoryValue,
            'topCustomers' => $topCustomers,
            'bestProducts' => $bestProducts,
            'totalProfit' => $totalProfit,
            'mostReturned' => $mostReturned,
            'recruitingInterest' => $recruitingInterest,
            'convertedConsultants' => $convertedConsultants,
            'activeTeamMembers' => $activeTeamMembers,
        ]);
    }
}
