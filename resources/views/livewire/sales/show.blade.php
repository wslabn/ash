<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sale Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Process Return Button (removed - now in FAB) -->

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $sale->sale_number }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->created_at->format('F d, Y g:i A') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($sale->payment_status === 'paid') bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200
                            @elseif($sale->payment_status === 'pending') bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200
                            @else bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 @endif">
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
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->product->name }}
                                            @if($item->discount_amount > 0)
                                                <span class="ml-2 text-xs text-red-600 dark:text-red-400 font-medium">
                                                    (Discounted ${{ number_format($item->discount_amount, 2) }})
                                                </span>
                                            @endif
                                        </td>
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
                            @if($sale->shipping_amount > 0)
                                <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                    <span>Shipping:</span>
                                    <span>${{ number_format($sale->shipping_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-xl font-bold border-t dark:border-gray-700 pt-2">
                                <span class="text-gray-900 dark:text-gray-100">Total:</span>
                                <span class="text-green-600 dark:text-green-400">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('sales.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">← Back to Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    @if($showReturnModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" wire:click="closeReturnModal">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden" @click.stop>
                <div class="p-6 border-b dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Process Return</h3>
                        <button wire:click="closeReturnModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 200px);">
                    <form wire:submit="processReturn">
                        <div class="space-y-4 mb-6">
                            @foreach($sale->items as $item)
                                <div class="border dark:border-gray-700 rounded p-4">
                                    <div class="flex items-start gap-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model="returnItems.{{ $item->id }}.selected"
                                            class="mt-1 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                        >
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Unit Price: ${{ number_format($item->unit_price, 2) }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Sold Quantity: {{ $item->quantity }}</p>
                                            
                                            @if($returnItems[$item->id]['selected'])
                                                <div class="mt-2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Return Quantity</label>
                                                    <input 
                                                        type="number" 
                                                        wire:model="returnItems.{{ $item->id }}.quantity"
                                                        min="1"
                                                        max="{{ $item->quantity }}"
                                                        class="mt-1 block w-32 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                                    >
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    wire:model="restoreInventory"
                                    class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                >
                                <span class="text-sm text-gray-700 dark:text-gray-300">Restore items to inventory</span>
                            </label>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Return *</label>
                            <textarea 
                                wire:model="returnReason"
                                rows="3"
                                placeholder="Why is this being returned?"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                            ></textarea>
                            @error('returnReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-2 justify-end">
                            <button type="button" wire:click="closeReturnModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold">
                                Cancel
                            </button>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold">
                                Process Return
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- FAB for Sales Context -->
    <livewire:floating-action-button context="sales" />
</div>
