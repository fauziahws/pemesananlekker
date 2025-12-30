<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                Our Menu
            </h1>
            <p class="text-gray-600">Discover delicious food & drinks</p>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">No products available yet</p>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-[#A0724B]">
                        <!-- Product Image -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            @if($product->image_url)
                                <img 
                                    src="{{ $product->image_url }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Availability Badge -->
                            @if(!$product->is_available)
                                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                    Sold Out
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-1">
                                {{ $product->name }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[40px]">
                                {{ $product->description }}
                            </p>

                            <!-- Price & Add Button -->
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                @if($product->is_available)
                                    <button 
                                        class="add-to-cart-btn group/btn bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white p-3 rounded-xl hover:shadow-lg hover:scale-110 transition-all duration-300"
                                        data-product-id="{{ $product->id }}"
                                        title="Add to cart"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-red-500 text-sm font-semibold">Not Available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        (function() {
            console.log('🚀 Cart script loaded!');
            
            const addUrl = '<?php echo route('cart.add'); ?>';
            const csrfToken = '<?php echo csrf_token(); ?>';
            
            console.log('Add URL:', addUrl);

            document.addEventListener('DOMContentLoaded', function() {
                console.log('✅ DOM Content Loaded');
                
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.add-to-cart-btn')) {
                        console.log('🛒 Add to cart button clicked!');
                        const btn = e.target.closest('.add-to-cart-btn');
                        const productId = btn.dataset.productId;
                        console.log('Product ID:', productId);
                        addToCart(productId, btn);
                    }
                });
            });

            async function addToCart(productId, btn) {
                console.log('Adding to cart, product ID:', productId);
                
                // Disable button
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                
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
                            cartCountElement.classList.add('animate-bounce');
                            setTimeout(() => cartCountElement.classList.remove('animate-bounce'), 1000);
                            console.log('Cart count updated:', data.cart_count);
                        }
                        
                        // Show success animation
                        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        btn.classList.add('bg-green-500');
                        
                        setTimeout(() => {
                            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>';
                            btn.classList.remove('bg-green-500');
                            btn.disabled = false;
                        }, 1500);
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menambahkan ke keranjang');
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>';
                }
            }
        })();
    </script>
    @endpush
</x-modern-app-layout>
