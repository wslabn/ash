<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Returns & Refunds
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <input wire:model.live="search" type="text" placeholder="Search returns..." 
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm w-full md:w-64">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Return #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Sale #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Refund</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($returns as $return)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 font-medium">
                                            {{ $return->return_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('sales.show', $return->sale_id) }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                                                {{ $return->sale->sale_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $return->customer->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $return->returned_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-red-600 dark:text-red-400 font-semibold">
                                            ${{ number_format($return->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($return->status === 'completed') bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200
                                                @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 @endif">
                                                {{ ucfirst($return->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50 dark:bg-gray-900">
                                        <td colspan="6" class="px-6 py-3">
                                            <div class="text-sm">
                                                <p class="text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="font-medium">Items:</span>
                                                    @foreach($return->items as $item)
                                                        {{ $item->quantity }}x {{ $item->product->name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </p>
                                                <p class="text-gray-700 dark:text-gray-300">
                                                    <span class="font-medium">Reason:</span> {{ $return->reason }}
                                                </p>
                                                @if($return->restore_inventory)
                                                    <p class="text-green-600 dark:text-green-400 text-xs mt-1">✓ Inventory restored</p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No returns found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $returns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAB for Global Context -->
    <livewire:floating-action-button context="global" />
</div>
