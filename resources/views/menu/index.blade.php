<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Lekker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($products->isEmpty())
                    <p class="text-gray-500 text-center py-8">Belum ada produk tersedia.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                                <div class="relative h-48 bg-gray-200">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2 text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>

                                        @if($product->is_available)
                                            <button 
                                                class="add-to-cart-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center gap-2"
                                                data-product-id="{{ $product->id }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Tambah
                                            </button>
                                        @else
                                            <span class="text-red-500 text-sm font-semibold">Tidak Tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            console.log('Cart script loaded!');
            
            // Routes configuration
            const addUrl = '<?php echo route('cart.add'); ?>';
            const csrfToken = '<?php echo csrf_token(); ?>';
            
            console.log('Add URL:', addUrl);
            console.log('CSRF Token:', csrfToken);

            // Event delegation for add to cart buttons
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded');
                
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.add-to-cart-btn')) {
                        console.log('Add to cart button clicked!');
                        const btn = e.target.closest('.add-to-cart-btn');
                        const productId = btn.dataset.productId;
                        console.log('Product ID:', productId);
                        addToCart(productId);
                    }
                });
            });

            async function addToCart(productId) {
                console.log('Adding to cart, product ID:', productId);
                
                try {
                    const response = await fetch(addUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    });

                    console.log('Response status:', response.status);
                    const data = await response.json();
                    console.log('Response data:', data);

                    if (data.success) {
                        // Update cart count
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                            console.log('Cart count updated:', data.cart_count);
                        }
                        
                        // Show success message
                        alert(data.message);
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menambahkan ke keranjang');
                }
            }
        })();
    </script>
    @endpush
</x-app-layout>
