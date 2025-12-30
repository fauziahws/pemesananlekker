<x-modern-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                Shopping Cart
            </h1>
            <p class="text-gray-600">Review your items before checkout</p>
        </div>

        @if(empty($cartItems))
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-6">Add some delicious items to get started!</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Browse Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition">
                            <div class="flex items-center space-x-4">
                                <!-- Product Image -->
                                <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                    @if($item['product']->image_url)
                                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-lg text-gray-900 truncate">{{ $item['product']->name }}</h3>
                                    <p class="text-gray-600 text-sm truncate">{{ $item['product']->description }}</p>
                                    <p class="text-[#7B542F] font-bold text-lg mt-1">
                                        Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-3">
                                    <button 
                                        class="decrease-qty w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition"
                                        data-product-id="{{ $item['product']->id }}"
                                        data-quantity="{{ $item['quantity'] - 1 }}"
                                    >
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <span class="w-12 text-center font-bold text-gray-900">{{ $item['quantity'] }}</span>
                                    
                                    <button 
                                        class="increase-qty w-8 h-8 bg-amber-100 hover:bg-amber-200 rounded-lg flex items-center justify-center transition"
                                        data-product-id="{{ $item['product']->id }}"
                                        data-quantity="{{ $item['quantity'] + 1 }}"
                                    >
                                        <svg class="w-4 h-4 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Subtotal & Remove -->
                                <div class="text-right">
                                    <p class="font-bold text-xl text-gray-900 mb-2">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </p>
                                    <button 
                                        class="remove-item text-red-500 hover:text-red-700 text-sm font-medium transition"
                                        data-product-id="{{ $item['product']->id }}"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 sticky top-24">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Items ({{ array_sum(array_column($cartItems, 'quantity')) }})</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span class="text-2xl bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('orders.checkout') }}" class="block w-full py-4 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-center font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform mb-3">
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('menu.index') }}" class="block w-full py-3 bg-gray-100 text-gray-700 text-center font-medium rounded-xl hover:bg-gray-200 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        (function() {
            const updateUrl = '<?php echo route('cart.update'); ?>';
            const removeUrl = '<?php echo route('cart.remove'); ?>';
            const csrfToken = '<?php echo csrf_token(); ?>';

            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.increase-qty')) {
                        const btn = e.target.closest('.increase-qty');
                        updateQuantity(btn.dataset.productId, btn.dataset.quantity);
                    }
                    if (e.target.closest('.decrease-qty')) {
                        const btn = e.target.closest('.decrease-qty');
                        updateQuantity(btn.dataset.productId, btn.dataset.quantity);
                    }
                    if (e.target.closest('.remove-item')) {
                        const btn = e.target.closest('.remove-item');
                        removeItem(btn.dataset.productId);
                    }
                });
            });

            async function updateQuantity(productId, quantity) {
                if (quantity < 0) return;

                try {
                    const response = await fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                }
            }

            async function removeItem(productId) {
                if (!confirm('Remove this item from cart?')) return;

                try {
                    const response = await fetch(removeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                }
            }
        })();
    </script>
    @endpush
</x-modern-app-layout>
