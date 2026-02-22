<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $product->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-bold text-sm">
                    Edit Product
                </a>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold text-sm">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Product Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Product Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $product->sku ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $product->category->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Cost</p>
                            <p class="text-gray-900 dark:text-gray-100">${{ number_format($product->base_cost, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Retail Price</p>
                            <p class="text-gray-900 dark:text-gray-100">${{ number_format($product->base_retail_price, 2) }}</p>
                        </div>
                    </div>
                    @if($product->description)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $product->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Stock</h3>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $currentStock }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sold</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $totalSold }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Profit</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalProfit, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Sales History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sales History</h3>
                    
                    @if($product->saleItems->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Sale</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($product->saleItems->sortByDesc('created_at') as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('sales.show', $item->sale->id) }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                                                    {{ $item->sale->sale_number }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('customers.show', $item->sale->customer->id) }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                                                    {{ $item->sale->customer->full_name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                ${{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No sales yet</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- FAB for Product Context -->
    <livewire:floating-action-button context="product" />
</div>
