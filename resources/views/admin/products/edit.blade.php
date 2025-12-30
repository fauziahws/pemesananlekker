<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Produk') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-700">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        {{ implode(', ', $errors->all()) }}
                    </div>
                @endif

                {{-- FORM UPDATE PRODUK --}}
                <form action="{{ route('admin.products.update', $product) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- NAMA --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $product->name) }}"
                               required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Deskripsi</label>
                        <textarea name="description"
                                  rows="3"
                                  class="w-full rounded-lg border-gray-300">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- HARGA --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="price"
                               value="{{ old('price', $product->price) }}"
                               min="0"
                               required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    {{-- GAMBAR SAAT INI --}}
                    @if($product->image_url)
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Gambar Saat Ini</label>
                            <img src="{{ $product->image_url }}"
                                 class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif

                    {{-- UPLOAD GAMBAR --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Upload Gambar Baru</label>
                        <input type="file"
                               name="image"
                               accept="image/jpeg,image/png,image/webp"
                               class="w-full rounded-lg border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">
                            JPEG, PNG, WebP • Max 2MB
                        </p>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox"
                                   name="is_available"
                                   value="1"
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600">
                            <span class="ml-2 text-sm">Produk tersedia</span>
                        </label>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-4">
                        <a href="{{ route('admin.products.index') }}"
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-center py-3 rounded-lg">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
                            Update Produk
                        </button>
                    </div>
                </form>

                {{-- FORM DELETE GAMBAR (DIPISAH, BUKAN DI DALAM FORM) --}}
                @if($product->image_url)
                    <form action="{{ route('admin.products.deleteImage', $product) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus gambar ini?')"
                          class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 text-sm hover:underline">
                            Hapus Gambar
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
