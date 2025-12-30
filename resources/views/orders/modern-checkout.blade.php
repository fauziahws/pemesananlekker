<x-modern-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                Checkout
            </h1>
            <p class="text-gray-600">Complete your order</p>
        </div>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Order Details & Customer Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Type Selection -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Order Type
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Dine In -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#A0724B] transition has-[:checked]:border-[#7B542F] has-[:checked]:bg-amber-50">
                                <input 
                                    type="radio" 
                                    name="order_type" 
                                    value="dine_in" 
                                    checked
                                    class="sr-only peer"
                                    onchange="toggleTableNumber()"
                                >
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3 peer-checked:bg-[#7B542F] transition">
                                        <svg class="w-8 h-8 text-[#7B542F] peer-checked:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div class="font-semibold text-gray-900 mb-1">Dine In</div>
                                    <div class="text-sm text-gray-600">Eat at restaurant</div>
                                </div>
                            </label>

                            <!-- Takeaway -->
                            <label class="relative flex flex-col p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#A0724B] transition has-[:checked]:border-[#7B542F] has-[:checked]:bg-amber-50">
                                <input 
                                    type="radio" 
                                    name="order_type" 
                                    value="takeaway"
                                    class="sr-only peer"
                                    onchange="toggleTableNumber()"
                                >
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-3 peer-checked:bg-[#A0724B] transition">
                                        <svg class="w-8 h-8 text-[#A0724B] peer-checked:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <div class="font-semibold text-gray-900 mb-1">Takeaway</div>
                                    <div class="text-sm text-gray-600">Take to go</div>
                                </div>
                            </label>
                        </div>
                        @error('order_type')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Customer Information
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="customer_name" 
                                    id="customer_name" 
                                    value="{{ old('customer_name', auth()->user()->name) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition"
                                    placeholder="Enter your name"
                                >
                                @error('customer_name')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="tableNumberField">
                                <label for="table_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Table Number <span class="text-red-500" id="tableRequired">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="table_number" 
                                    id="table_number" 
                                    value="{{ old('table_number') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition"
                                    placeholder="e.g. A1, B2, C3"
                                >
                                @error('table_number')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Payment Method
                        </h2>

                        <div class="space-y-3">
                            <!-- Cash Payment -->
                            <label class="relative flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#A0724B] transition has-[:checked]:border-[#7B542F] has-[:checked]:bg-amber-50">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="cash" 
                                    checked
                                    class="mt-1 h-4 w-4 text-[#7B542F] focus:ring-[#7B542F]">
                                >
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Cash at Cashier</p>
                                                <p class="text-sm text-gray-600">Pay directly at the cashier counter</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Virtual Account Payment -->
                            <label class="relative flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#A0724B] transition has-[:checked]:border-[#7B542F] has-[:checked]:bg-amber-50">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="virtual_account"
                                    class="mt-1 h-4 w-4 text-[#7B542F] focus:ring-[#7B542F]">
                                >
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mr-3">
                                                <svg class="w-6 h-6 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Virtual Account</p>
                                                <p class="text-sm text-gray-600">Pay via bank transfer with virtual account number</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 sticky top-24">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <!-- Order Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between text-sm">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $item['product']->name }}</p>
                                        <p class="text-gray-600">{{ $item['quantity'] }} × Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-semibold text-gray-900 ml-2">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span class="text-2xl bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="w-full py-4 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7B542F]"
                        >
                            Place Order
                        </button>

                        <a 
                            href="{{ route('cart.index') }}"
                            class="block w-full py-3 mt-3 bg-gray-100 text-gray-700 text-center font-medium rounded-xl hover:bg-gray-200 transition"
                        >
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleTableNumber() {
            const orderType = document.querySelector('input[name="order_type"]:checked').value;
            const tableField = document.getElementById('tableNumberField');
            const tableInput = document.getElementById('table_number');
            const tableRequired = document.getElementById('tableRequired');
            
            if (orderType === 'takeaway') {
                tableField.style.display = 'none';
                tableInput.removeAttribute('required');
                tableInput.value = '';
            } else {
                tableField.style.display = 'block';
                tableInput.setAttribute('required', 'required');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleTableNumber();
        });
    </script>
</x-modern-app-layout>
