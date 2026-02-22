@if($showModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" wire:click="closeModal">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden" @click.stop>
            <div class="p-6 border-b dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        @if($step === 1)
                            Select Sale to Return
                        @else
                            Process Return - {{ $selectedSale->sale_number }}
                        @endif
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 200px);">
                @if($step === 1)
                    <!-- Step 1: Search and Select Sale -->
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Search by sale number or customer name..."
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 mb-4"
                    >
                    
                    @if(strlen($search) >= 2)
                        <div class="space-y-2">
                            @forelse($sales as $sale)
                                <button 
                                    wire:click="selectSale({{ $sale->id }})"
                                    class="w-full text-left p-4 border dark:border-gray-700 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $sale->sale_number }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $sale->customer->full_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ $sale->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <p class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($sale->total_amount, 2) }}</p>
                                    </div>
                                </button>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No sales found</p>
                            @endforelse
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">Type at least 2 characters to search</p>
                    @endif
                    
                @else
                    <!-- Step 2: Process Return -->
                    <button wire:click="backToSearch" class="text-purple-600 dark:text-purple-400 text-sm mb-4">← Back to search</button>
                    
                    <form wire:submit="processReturn">
                        <div class="space-y-4 mb-6">
                            @foreach($selectedSale->items as $item)
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
                            <button type="button" wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold">
                                Cancel
                            </button>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold">
                                Process Return
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endif
