<div class="relative" x-data="{ open: @entangle('showResults') }" @click.away="$wire.closeResults()">
    <input 
        wire:model.live.debounce.300ms="query" 
        type="text" 
        placeholder="Search..." 
        class="w-64 px-4 py-2 text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
        @focus="if($wire.query.length >= 2) open = true"
    >

    @if($showResults && strlen($query) >= 2)
        <div class="absolute z-50 mt-2 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 max-h-96 overflow-y-auto">
            @if(count($results['customers']) > 0)
                <div class="p-3 border-b dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Customers</h3>
                    @foreach($results['customers'] as $customer)
                        <a href="{{ route('customers.edit', $customer->id) }}" wire:navigate class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customer->full_name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->email }}</div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if(count($results['products']) > 0)
                <div class="p-3 border-b dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Products</h3>
                    @foreach($results['products'] as $product)
                        <a href="{{ route('products.edit', $product->id) }}" wire:navigate class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if(count($results['sales']) > 0)
                <div class="p-3">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Sales</h3>
                    @foreach($results['sales'] as $sale)
                        <a href="{{ route('sales.show', $sale->id) }}" wire:navigate class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $sale->sale_number }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $sale->customer->full_name }} - ${{ number_format($sale->total_amount, 2) }}</div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if(count($results['customers']) == 0 && count($results['products']) == 0 && count($results['sales']) == 0)
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    No results found
                </div>
            @endif
        </div>
    @endif
</div>
