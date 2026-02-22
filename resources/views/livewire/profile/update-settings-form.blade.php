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
            <x-text-input wire:model="sale_starting_number" id="sale_starting_number" name="sale_starting_number" type="number" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('sale_starting_number')" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Start your sale numbers at 1, 100, 1000, etc. Current sales will not be affected.
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
