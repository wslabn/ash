<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-semibold mb-6">Platform Settings</h2>

                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="save" class="space-y-8">
                    <!-- Email Settings -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-lg font-medium mb-4">Email Settings (SendGrid)</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">SendGrid API Key</label>
                                <input type="password" wire:model="sendgrid_api_key" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="SG.xxxxxxxxxxxxx">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Get from SendGrid dashboard → Settings → API Keys</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">From Email Address *</label>
                                <input type="email" wire:model="mail_from_address" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="noreply@ashbrooke.com" required>
                                @error('mail_from_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">From Name *</label>
                                <input type="text" wire:model="mail_from_name" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="Ashbrooke CRM" required>
                                @error('mail_from_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SMS Settings -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-lg font-medium mb-4">SMS Settings (Twilio)</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">For future SMS notifications and reminders</p>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Twilio Account SID</label>
                                <input type="password" wire:model="twilio_account_sid" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="ACxxxxxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Twilio Auth Token</label>
                                <input type="password" wire:model="twilio_auth_token" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="xxxxxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Twilio Phone Number</label>
                                <input type="text" wire:model="twilio_phone_number" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="+1234567890">
                            </div>
                        </div>
                    </div>

                    <!-- Discord Settings -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-lg font-medium mb-4">Discord Community</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Official Ashbrooke CRM community for support, tips, and feature requests</p>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Community Discord Invite Link</label>
                                <input type="url" wire:model="discord_community_invite" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="https://discord.gg/yourlink">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Consultants will see "Community" link in navigation</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Feedback Webhook URL</label>
                                <input type="password" wire:model="discord_feedback_webhook" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"
                                    placeholder="https://discord.com/api/webhooks/...">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bug reports and feature requests will post here</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-lg font-medium mb-4">Payment Methods</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Manage available payment methods for sales</p>
                        
                        <div class="space-y-3 mb-4">
                            @foreach($payment_methods as $index => $method)
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                                    <span>{{ $method }}</span>
                                    <button type="button" wire:click="removePaymentMethod({{ $index }})" 
                                        class="text-red-600 hover:text-red-800 dark:text-red-400">
                                        Remove
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex gap-2">
                            <input type="text" wire:model="newPaymentMethod" 
                                placeholder="Add new payment method"
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                            <button type="button" wire:click="addPaymentMethod" 
                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                                Add
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                            class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
