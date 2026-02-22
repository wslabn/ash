<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Business Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Configure your sale and invoice numbering.') }}
        </p>
    </header>

    <form wire:submit="save" class="mt-6 space-y-6">
        <div>
            <x-input-label for="sale_starting_number" :value="__('Sale Number Starting Point')" />
            <select wire:model="sale_starting_number" id="sale_starting_number" name="sale_starting_number" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="1">1 (0001, 0002, 0003...)</option>
                <option value="100">100 (0100, 0101, 0102...)</option>
                <option value="1000">1000 (1000, 1001, 1002...)</option>
                <option value="10000">10000 (10000, 10001, 10002...)</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('sale_starting_number')" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Choose where your sale numbers begin. Current sales will not be affected.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('settings-saved'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
