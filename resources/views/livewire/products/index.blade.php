<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Products & Inventory
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-4">
                            <input wire:model.live="search" type="text" placeholder="Search products..." 
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <a href="{{ route('categories.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">Manage Categories</a>
                        </div>
                        <a href="{{ route('products.create') }}" class="bg-mary-kay-pink hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                            Add Product
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">SKU</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Cost</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $product->sku }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">${{ number_format($product->base_cost, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600 dark:text-green-400 font-semibold">${{ number_format($product->base_retail_price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $stock = $product->inventory->sum('quantity');
                                                $lowStock = $product->inventory->where('quantity', '<=', 'low_stock_threshold')->count() > 0;
                                            @endphp
                                            <span class="{{ $stock < 0 ? 'text-red-600 dark:text-red-400 font-bold' : ($lowStock ? 'text-yellow-600 dark:text-yellow-400 font-bold' : 'text-gray-900 dark:text-gray-100') }}">
                                                {{ $stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="openAdjustModal({{ $product->id }}, '{{ $product->name }}')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-bold mr-2">Adjust</button>
                                            <a href="{{ route('products.edit', $product->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs font-bold mr-2">Edit</a>
                                            <button wire:click="delete({{ $product->id }})" wire:confirm="Delete this product?" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inventory Adjustment Modal -->
    @if($showAdjustModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Adjust Stock: {{ $adjustProductName }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adjustment Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model="adjustType" value="add" class="mr-2">
                                <span class="text-gray-900 dark:text-gray-100">Add Stock</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="adjustType" value="remove" class="mr-2">
                                <span class="text-gray-900 dark:text-gray-100">Remove Stock</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity *</label>
                        <input wire:model="adjustQuantity" type="number" min="1" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        @error('adjustQuantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason *</label>
                        <select wire:model="adjustReason" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Select reason...</option>
                            <option value="Sample given out">Sample given out</option>
                            <option value="Damaged/Defective">Damaged/Defective</option>
                            <option value="Personal use">Personal use</option>
                            <option value="Inventory correction">Inventory correction</option>
                            <option value="Received shipment">Received shipment</option>
                            <option value="Found extra stock">Found extra stock</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('adjustReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" wire:click="closeAdjustModal" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="button" wire:click="saveAdjustment" class="bg-mary-kay-pink hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        Save Adjustment
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
