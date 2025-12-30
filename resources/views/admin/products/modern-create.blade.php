<x-modern-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                    Add Product
                </h1>
                <p class="text-gray-600">Create a new menu item</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-50 border border-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition"
                            placeholder="e.g. Nasi Goreng Spesial">
                        @error('name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition"
                            placeholder="Describe your product...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Price (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                value="{{ old('price') }}"
                                required
                                min="0"
                                step="1000"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition"
                                placeholder="25000">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Image
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-[#7B542F] transition">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Availability -->
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                        <input 
                            type="checkbox" 
                            name="is_available" 
                            id="is_available" 
                            value="1"
                            {{ old('is_available', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-[#7B542F] border-gray-300 rounded focus:ring-[#7B542F]">
                        <label for="is_available" class="ml-3">
                            <span class="text-sm font-semibold text-gray-900">Available for order</span>
                            <p class="text-xs text-gray-600">Customers can see and order this product</p>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        Create Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-modern-app-layout>
