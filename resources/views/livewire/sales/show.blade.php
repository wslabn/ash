<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sale Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $sale->sale_number }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->created_at->format('F d, Y g:i A') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($sale->payment_status === 'paid') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                            @elseif($sale->payment_status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b dark:border-gray-700">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Customer</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $sale->customer->full_name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $sale->customer->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $sale->customer->phone }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Sale Details</h3>
                            <p class="text-gray-900 dark:text-gray-100">Type: <span class="font-medium">{{ ucfirst($sale->sale_type) }}</span></p>
                            <p class="text-gray-900 dark:text-gray-100">Payment: <span class="font-medium">{{ ucfirst($sale->payment_method) }}</span></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Items</h3>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Product</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($sale->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $item->product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-right">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Subtotal:</span>
                                <span class="text-green-600 dark:text-green-400 font-semibold">${{ number_format($sale->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Tax:</span>
                                <span>${{ number_format($sale->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold border-t dark:border-gray-700 pt-2">
                                <span class="text-gray-900 dark:text-gray-100">Total:</span>
                                <span class="text-green-600 dark:text-green-400">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('sales.index') }}" class="text-purple-accent hover:text-purple-900">← Back to Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
