<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $customer->full_name }}
            </h2>
            <div class="flex gap-2">
                <button 
                    wire:click="openNotesModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold text-sm"
                >
                    Notes ({{ $customer->customerNotes->count() }})
                </button>
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
            
            @if (session()->has('message'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

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

            <!-- Recruiting Section -->
            @if($customer->converted_to_user_id)
                <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">✓ Converted to Consultant</h3>
                            <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                This customer is now a consultant: {{ $customer->convertedToUser->name }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recruiting</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track recruiting interest and convert to consultant</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        wire:click="toggleRecruitingInterest"
                                        {{ $customer->recruiting_interest ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                    >
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Interested in Joining</span>
                                </label>
                                @if($customer->recruiting_interest)
                                    <button 
                                        wire:click="convertToConsultant"
                                        wire:confirm="Convert this customer to a consultant? They will receive login credentials."
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold text-sm"
                                    >
                                        Convert to Consultant
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Purchase History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Purchase History</h3>
                    
                    @if($customer->sales->count() > 0)
                        <div class="space-y-4">
                            @foreach($customer->sales->sortByDesc('created_at') as $sale)
                                <a href="{{ route('sales.show', $sale->id) }}" class="block border dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-lg font-semibold text-purple-600 dark:text-purple-400">
                                                {{ $sale->sale_number }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $sale->created_at->format('F d, Y g:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-green-600 dark:text-green-400">${{ number_format($sale->total_amount, 2) }}</p>
                                            <div class="flex items-center gap-2 justify-end mt-1">
                                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-200">
                                                    {{ ucfirst($sale->sale_type) }}
                                                </span>
                                                <span class="text-xs text-purple-600 dark:text-purple-400 font-medium">View →</span>
                                            </div>
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
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No purchases yet</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Notes Modal -->
    @if($showNotesModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" wire:click="closeNotesModal">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden" @click.stop>
                <div class="p-6 border-b dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Notes & Timeline</h3>
                        <button wire:click="closeNotesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 180px);">
                    <!-- Add Note Form -->
                    <form wire:submit="addNote" class="mb-6">
                        <div class="flex gap-2">
                            <textarea 
                                wire:model="newNote" 
                                placeholder="Add a note about this customer..."
                                rows="2"
                                class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600"
                            ></textarea>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-bold self-start">
                                Add
                            </button>
                        </div>
                        @error('newNote') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </form>

                    <!-- Timeline -->
                    @if($customer->customerNotes->count() > 0)
                        <div class="space-y-4">
                            @foreach($customer->customerNotes->sortByDesc('created_at') as $note)
                                <div class="border-l-4 border-purple-500 pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-gray-900 dark:text-gray-100">{{ $note->note }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $note->created_at->format('M d, Y g:i A') }}
                                            </p>
                                        </div>
                                        <button 
                                            wire:click="deleteNote({{ $note->id }})" 
                                            wire:confirm="Are you sure you want to delete this note?"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm ml-4"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No notes yet</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
