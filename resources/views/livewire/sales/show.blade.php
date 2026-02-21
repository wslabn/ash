<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $sale->sale_number }}</h2>
                            <p class="text-gray-600">{{ $sale->created_at->format('F d, Y g:i A') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($sale->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($sale->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Customer</h3>
                            <p class="text-gray-900">{{ $sale->customer->full_name }}</p>
                            <p class="text-gray-600 text-sm">{{ $sale->customer->email }}</p>
                            <p class="text-gray-600 text-sm">{{ $sale->customer->phone }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Sale Details</h3>
                            <p class="text-gray-900">Type: <span class="font-medium">{{ ucfirst($sale->sale_type) }}</span></p>
                            <p class="text-gray-900">Payment: <span class="font-medium">{{ ucfirst($sale->payment_method) }}</span></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Items</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sale->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal:</span>
                                <span>${{ number_format($sale->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Tax:</span>
                                <span>${{ number_format($sale->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-gray-900 border-t pt-2">
                                <span>Total:</span>
                                <span>${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('sales.index') }}" class="text-pink-600 hover:text-pink-900">← Back to Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
