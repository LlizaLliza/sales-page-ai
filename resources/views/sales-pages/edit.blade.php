<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit & Re-generate AI Sales Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('sales-pages.update', $salesPage) }}" id="generate-form">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div class="mt-4">
                            <x-input-label for="product_name" :value="__('Product / Service Name')" />
                            <x-text-input id="product_name" class="block mt-1 w-full" type="text" name="product_name" :value="old('product_name', $salesPage->product_name)" required autofocus />
                            <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Product Description')" />
                            <textarea id="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="description" rows="3" required>{{ old('description', $salesPage->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Features -->
                        <div class="mt-4">
                            <x-input-label for="features" :value="__('Key Features (comma separated)')" />
                            <textarea id="features" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="features" rows="2" required>{{ old('features', $salesPage->features) }}</textarea>
                            <x-input-error :messages="$errors->get('features')" class="mt-2" />
                        </div>

                        <!-- Target Audience -->
                        <div class="mt-4">
                            <x-input-label for="target_audience" :value="__('Target Audience')" />
                            <x-text-input id="target_audience" class="block mt-1 w-full" type="text" name="target_audience" :value="old('target_audience', $salesPage->target_audience)" placeholder="e.g. Small business owners, students..." required />
                            <x-input-error :messages="$errors->get('target_audience')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price', $salesPage->price)" placeholder="e.g. $99, Free trial, $10/month" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Unique Selling Points -->
                        <div class="mt-4">
                            <x-input-label for="selling_points" :value="__('Unique Selling Points (Optional)')" />
                            <textarea id="selling_points" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="selling_points" rows="2">{{ old('selling_points', $salesPage->selling_points) }}</textarea>
                            <x-input-error :messages="$errors->get('selling_points')" class="mt-2" />
                        </div>

                        <!-- Design Style -->
                        <div class="mt-4">
                            <x-input-label for="design_style" :value="__('Design Style / Template')" />
                            <select id="design_style" name="design_style" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="Minimalist" {{ old('design_style', $salesPage->design_style) == 'Minimalist' ? 'selected' : '' }}>Minimalist & Clean</option>
                                <option value="Dark & Futuristic" {{ old('design_style', $salesPage->design_style) == 'Dark & Futuristic' ? 'selected' : '' }}>Dark & Futuristic (Cyberpunk)</option>
                                <option value="Corporate Blue" {{ old('design_style', $salesPage->design_style) == 'Corporate Blue' ? 'selected' : '' }}>Corporate Blue (Professional)</option>
                                <option value="Vibrant & Playful" {{ old('design_style', $salesPage->design_style) == 'Vibrant & Playful' ? 'selected' : '' }}>Vibrant & Playful (Colorful)</option>
                            </select>
                            <x-input-error :messages="$errors->get('design_style')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('sales-pages.show', $salesPage) }}">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button class="ms-4" id="generate-btn">
                                <svg id="spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Re-generate Sales Page') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generate-form').addEventListener('submit', function() {
            document.getElementById('generate-btn').setAttribute('disabled', 'disabled');
            document.getElementById('spinner').classList.remove('hidden');
        });
    </script>
</x-app-layout>
