<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $customer->full_name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('customers.edit', $customer->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-bold text-sm">
                    Edit Customer
                </a>
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold text-sm">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Customer Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->email ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->phone ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                            <p class="text-gray-900 dark:text-gray-100">
                                @if($customer->city || $customer->state)
                                    {{ $customer->city }}{{ $customer->city && $customer->state ? ', ' : '' }}{{ $customer->state }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">How Met</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->how_met ?: 'N/A' }}</p>
                        </div>
                    </div>
                    @if($customer->notes)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Spent</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalSpent, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</h3>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalOrders }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Purchase</h3>
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                            {{ $lastPurchase ? $lastPurchase->format('M d, Y') : 'Never' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Purchase History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Purchase History</h3>
                    
                    @if($customer->sales->count() > 0)
                        <div class="space-y-4">
                            @foreach($customer->sales->sortByDesc('created_at') as $sale)
                                <div class="border dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <a href="{{ route('sales.show', $sale->id) }}" class="text-lg font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                                {{ $sale->sale_number }}
                                            </a>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $sale->created_at->format('F d, Y g:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-green-600 dark:text-green-400">${{ number_format($sale->total_amount, 2) }}</p>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($sale->sale_type === 'party') bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-200
                                                @elseif($sale->sale_type === 'online') bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200
                                                @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                                                {{ ucfirst($sale->sale_type) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Items:</p>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 ml-4">
                                            @foreach($sale->items as $item)
                                                <li>{{ $item->quantity }}x {{ $item->product->name }} - ${{ number_format($item->subtotal, 2) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No purchases yet</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
