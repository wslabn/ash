<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-purple-600 to-pink-500 text-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if($consultant->profile_photo)
                <img src="{{ Storage::url($consultant->profile_photo) }}" alt="{{ $consultant->name }}" class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-white shadow-lg object-cover">
            @else
                <div class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-white shadow-lg bg-white text-purple-600 flex items-center justify-center text-4xl font-bold">
                    {{ strtoupper(substr($consultant->name, 0, 1)) }}
                </div>
            @endif
            
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $consultant->name }}</h1>
            
            @if($consultant->headline)
                <p class="text-xl md:text-2xl mb-6 text-purple-100">{{ $consultant->headline }}</p>
            @endif
            
            @if($consultant->bio)
                <p class="text-lg max-w-2xl mx-auto text-white/90">{{ $consultant->bio }}</p>
            @endif
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                <p class="text-gray-600 mb-8">I'd love to hear from you! Fill out the form and I'll get back to you as soon as possible.</p>
                
                <div class="space-y-4">
                    
                    <!-- Social Links -->
                    @if($consultant->facebook_url || $consultant->instagram_url || $consultant->youtube_url || $consultant->website_url)
                        <div class="flex gap-4 mt-6">
                            @if($consultant->facebook_url)
                                <a href="{{ $consultant->facebook_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($consultant->instagram_url)
                                <a href="{{ $consultant->instagram_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($consultant->youtube_url)
                                <a href="{{ $consultant->youtube_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if($consultant->website_url)
                                <a href="{{ $consultant->website_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                @if($submitted)
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Thank You!</h3>
                        <p class="text-gray-600">I'll get back to you soon.</p>
                    </div>
                @else
                    <form wire:submit="submit" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" wire:model="first_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" wire:model="last_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" wire:model="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" wire:model="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea wire:model="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                            @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition">
                            Send Message
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-900 text-white py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">© {{ date('Y') }} {{ $consultant->name }}. All rights reserved.</p>
        </div>
    </div>
</div>
