<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Quick Actions removed - now in FAB -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Sales -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Sales</h3>
                        <a href="{{ route('sales.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">View All →</a>
                    </div>
                    <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalSales, 2) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $salesCount }} orders</p>
                </div>
            </div>

            <!-- Inventory Value -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Inventory Value</h3>
                        <a href="{{ route('products.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">View All →</a>
                    </div>
                    <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($inventoryValue, 2) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Current stock</p>
                </div>
            </div>

            <!-- Total Profit -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Profit</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalProfit, 2) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Net earnings</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Top Customers -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Top Customers</h3>
                        <a href="{{ route('customers.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">View All →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($topCustomers as $customer)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 dark:text-gray-100">{{ $customer->full_name }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $customer->sales_count }} orders</span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No customers yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Best Selling Products -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Best Selling Products</h3>
                        <a href="{{ route('products.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">View All →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($bestProducts as $product)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $product->sale_items_count }} sold</span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No products sold yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Most Returned Products -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Most Returned Products</h3>
                        <a href="{{ route('returns.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">View All →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($mostReturned as $product)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
                                <span class="text-sm text-red-600 dark:text-red-400">{{ $product->return_items_sum_quantity }} returned</span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No returns yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAB for Global Context -->
    <livewire:floating-action-button context="global" />
</div>
