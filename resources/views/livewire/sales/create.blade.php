<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">New Sale</h2>

                    @if (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form wire:submit="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
                                <select wire:model="customer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sale Type *</label>
                                <select wire:model="sale_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    <option value="retail">Retail</option>
                                    <option value="party">Party</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                                <select wire:model="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="check">Check</option>
                                    <option value="venmo">Venmo</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                                <input wire:model="tax_rate" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
                                <button type="button" wire:click="addItem" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm">
                                    + Add Item
                                </button>
                            </div>

                            @foreach($items as $index => $item)
                                <div class="grid grid-cols-12 gap-4 mb-3 items-start">
                                    <div class="col-span-5">
                                        <select wire:model.live="items.{{ $index }}.product_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.product_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <input wire:model="items.{{ $index }}.quantity" type="number" min="1" placeholder="Qty" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                        @error("items.$index.quantity") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <input wire:model="items.{{ $index }}.unit_price" type="number" step="0.01" placeholder="Price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                        @error("items.$index.unit_price") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2 flex items-center">
                                        <span class="text-gray-700 font-medium">${{ number_format($item['quantity'] * $item['unit_price'], 2) }}</span>
                                    </div>
                                    <div class="col-span-1">
                                        @if(count($items) > 1)
                                            <button type="button" wire:click="removeItem({{ $index }})" class="text-red-600 hover:text-red-900">✕</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-end space-y-2">
                                <div class="w-64">
                                    <div class="flex justify-between text-gray-700">
                                        <span>Subtotal:</span>
                                        <span>${{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']), 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <span>Tax ({{ $tax_rate }}%):</span>
                                        <span>${{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * ($tax_rate / 100), 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold text-gray-900 border-t mt-2 pt-2">
                                        <span>Total:</span>
                                        <span>${{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * (1 + $tax_rate / 100), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('sales.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg">
                                Create Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
