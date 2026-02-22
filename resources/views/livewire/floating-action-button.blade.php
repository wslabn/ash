<div x-data="{ open: @entangle('isOpen') }" @click.away="open = false" class="fixed bottom-6 right-6 z-50">
    <!-- Action Menu (appears when open) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute bottom-20 right-0 mb-2 space-y-2 min-w-[200px]">
        
        <!-- Global Actions -->
        <a href="{{ route('sales.create') }}" wire:navigate class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition">
            <span class="text-xl">💰</span>
            <span class="font-medium">New Sale</span>
        </a>
        
        <a href="{{ route('customers.create') }}" wire:navigate class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition">
            <span class="text-xl">👤</span>
            <span class="font-medium">Add Customer</span>
        </a>
        
        <a href="{{ route('products.create') }}" wire:navigate class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition">
            <span class="text-xl">📦</span>
            <span class="font-medium">Add Product</span>
        </a>

        <button wire:click="$dispatch('openProcessReturn')" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
            <span class="text-xl">🔄</span>
            <span class="font-medium">Process Return</span>
        </button>
        
        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
        
        <button @click="Livewire.dispatch('openFeedbackModal', { type: 'bug' })" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
            <span class="text-xl">🐛</span>
            <span class="font-medium">Report Bug</span>
        </button>
        
        <button @click="Livewire.dispatch('openFeedbackModal', { type: 'feature' })" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
            <span class="text-xl">💡</span>
            <span class="font-medium">Request Feature</span>
        </button>

        <!-- Customer Context Actions -->
        @if($context === 'customer' && $customerId)
            <button wire:click="$dispatch('openNotesModal')" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
                <span class="text-xl">📝</span>
                <span class="font-medium">Notes</span>
            </button>
            
            <a href="{{ route('sales.create') }}?customer_id={{ $customerId }}" wire:navigate class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition">
                <span class="text-xl">🛍️</span>
                <span class="font-medium">Sale for Customer</span>
            </a>
            
            <button wire:click="$dispatch('logInteraction')" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
                <span class="text-xl">📞</span>
                <span class="font-medium">Log Call</span>
            </button>
        @endif

        <!-- Product Context Actions -->
        @if($context === 'product')
            <button wire:click="$dispatch('openAdjustModal')" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
                <span class="text-xl">📦</span>
                <span class="font-medium">Adjust Inventory</span>
            </button>
            
            <a href="{{ route('categories.index') }}" wire:navigate class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition">
                <span class="text-xl">🏷️</span>
                <span class="font-medium">Manage Categories</span>
            </a>
        @endif

        <!-- Sales Context Actions -->
        @if($context === 'sales')
            <button wire:click="$dispatch('exportReport')" class="flex items-center gap-3 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition w-full text-left">
                <span class="text-xl">📄</span>
                <span class="font-medium">Export Report</span>
            </button>
        @endif
    </div>

    <!-- Main FAB Button -->
    <button 
        @click="open = !open"
        class="w-14 h-14 bg-purple-600 hover:bg-purple-700 text-white rounded-full shadow-lg flex items-center justify-center text-2xl transition-transform"
        :class="{ 'rotate-45': open }"
    >
        <span x-show="!open">➕</span>
        <span x-show="open">✕</span>
    </button>
</div>
