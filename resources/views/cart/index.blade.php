<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(empty($cartItems))
                    <div class="text-center py-8">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 text-lg mb-4">Keranjang Anda kosong</p>
                        <a href="{{ route('menu.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300">
                            Mulai Belanja
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex gap-4 p-4 border rounded-lg">
                                <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                                    @if($item['product']->image_url)
                                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">{{ $item['product']->name }}</h3>
                                    <p class="text-gray-600 text-sm">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                    
                                    <div class="flex items-center gap-3 mt-3">
                                        <button 
                                            class="decrease-qty bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-lg flex items-center justify-center transition duration-300"
                                            data-product-id="{{ $item['product']->id }}"
                                            data-quantity="{{ $item['quantity'] - 1 }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        
                                        <span class="font-semibold w-8 text-center">{{ $item['quantity'] }}</span>
                                        
                                        <button 
                                            class="increase-qty bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-lg flex items-center justify-center transition duration-300"
                                            data-product-id="{{ $item['product']->id }}"
                                            data-quantity="{{ $item['quantity'] + 1 }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-lg">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                    <button 
                                        class="remove-item text-red-600 hover:text-red-700 text-sm mt-2"
                                        data-product-id="{{ $item['product']->id }}">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t mt-6 pt-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xl font-semibold">Total:</span>
                            <span id="total-amount" class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('menu.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-center transition duration-300">
                                Lanjut Belanja
                            </a>
                            <a href="{{ route('orders.checkout') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-center transition duration-300">
                                Checkout
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            // Routes configuration
            const updateUrl = '<?php echo route('cart.update'); ?>';
            const removeUrl = '<?php echo route('cart.remove'); ?>';
            const csrfToken = '<?php echo csrf_token(); ?>';

            // Event delegation for cart buttons
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
                if (!confirm('Hapus item ini dari keranjang?')) return;

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
</x-app-layout>
