<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $facebook_url = '';
    public string $instagram_url = '';
    public string $youtube_url = '';
    public string $website_url = '';
    public $profile_photo;
    public $business_logo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone ?? '';
        $this->facebook_url = Auth::user()->facebook_url ?? '';
        $this->instagram_url = Auth::user()->instagram_url ?? '';
        $this->youtube_url = Auth::user()->youtube_url ?? '';
        $this->website_url = Auth::user()->website_url ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'business_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'facebook_url' => $validated['facebook_url'],
            'instagram_url' => $validated['instagram_url'],
            'youtube_url' => $validated['youtube_url'],
            'website_url' => $validated['website_url'],
        ]);

        // Handle profile photo upload
        if ($this->profile_photo) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $this->profile_photo->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // Handle business logo upload
        if ($this->business_logo) {
            if ($user->business_logo) {
                Storage::disk('public')->delete($user->business_logo);
            }
            $path = $this->business_logo->store('business-logos', 'public');
            $user->business_logo = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        $this->profile_photo = null;
        $this->business_logo = null;
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input wire:model="phone" id="phone" name="phone" type="text" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="facebook_url" :value="__('Facebook URL')" />
            <x-text-input wire:model="facebook_url" id="facebook_url" name="facebook_url" type="url" placeholder="https://facebook.com/yourpage" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('facebook_url')" />
        </div>

        <div>
            <x-input-label for="instagram_url" :value="__('Instagram URL')" />
            <x-text-input wire:model="instagram_url" id="instagram_url" name="instagram_url" type="url" placeholder="https://instagram.com/yourprofile" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('instagram_url')" />
        </div>

        <div>
            <x-input-label for="youtube_url" :value="__('YouTube URL')" />
            <x-text-input wire:model="youtube_url" id="youtube_url" name="youtube_url" type="url" placeholder="https://youtube.com/@yourchannel" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('youtube_url')" />
        </div>

        <div>
            <x-input-label for="website_url" :value="__('Website URL')" />
            <x-text-input wire:model="website_url" id="website_url" name="website_url" type="url" placeholder="https://yourwebsite.com" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('website_url')" />
        </div>

        <div>
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            @if(auth()->user()->profile_photo)
                <img src="{{ Storage::url(auth()->user()->profile_photo) }}" class="w-20 h-20 rounded-full object-cover mt-2 mb-2">
            @endif
            <input wire:model="profile_photo" id="profile_photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-gray-700 dark:file:text-gray-300" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Your personal photo for your account.</p>
        </div>

        <div>
            <x-input-label for="business_logo" :value="__('Business Logo')" />
            @if(auth()->user()->business_logo)
                <img src="{{ Storage::url(auth()->user()->business_logo) }}" class="w-20 h-20 rounded-full object-cover mt-2 mb-2">
            @endif
            <input wire:model="business_logo" id="business_logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-gray-700 dark:file:text-gray-300" />
            <x-input-error class="mt-2" :messages="$errors->get('business_logo')" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Your business logo for invoices and marketing materials.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
