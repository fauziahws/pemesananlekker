<x-modern-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                    Order Details
                </h1>
                <p class="text-gray-600">Manage and process order</p>
            </div>
            <a href="{{ route('cashier.orders') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-50 border border-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Information Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Information</h2>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Order Code</p>
                            <p class="font-mono font-bold text-xl text-gray-900">{{ $order->order_code }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Order Time</p>
                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Customer Name</p>
                            <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Order Type</p>
                            <p class="font-semibold text-gray-900 flex items-center">
                                @if($order->order_type === 'takeaway')
                                    <svg class="w-5 h-5 mr-2 text-[#A0724B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Takeaway
                                @else
                                    <svg class="w-5 h-5 mr-2 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dine In
                                @endif
                            </p>
                        </div>

                        @if($order->order_type === 'dine_in' && $order->table_number)
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Table Number</p>
                            <p class="font-bold text-2xl text-gray-900">{{ $order->table_number }}</p>
                        </div>
                        @endif

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-2">Payment Method</p>
                            <p class="font-semibold text-gray-900">
                                @if($order->payment_method === 'cash')
                                    <span class="flex items-center text-green-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Cash
                                    </span>
                                @else
                                    <span class="flex items-center text-[#7B542F]">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Virtual Account
                                    </span>
                                @endif
                            </p>
                            @if($order->payment_method === 'virtual_account' && $order->virtual_account_number)
                                <p class="text-xs text-gray-500 mt-1 font-mono">{{ $order->virtual_account_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Items</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                @if($item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-xl">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <p class="font-bold text-lg text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <p class="font-bold text-xl text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4">
                            <span class="text-xl font-bold text-gray-900">Total Amount:</span>
                            <span class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Order Status</h3>
                    
                    <!-- Current Status -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-3">Current Status</p>
                        <span class="inline-block px-6 py-3 rounded-xl text-base font-bold w-full text-center
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Update Status Form -->
                    <form action="{{ route('cashier.orders.updateStatus', $order) }}" method="POST" class="mb-6">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-medium text-gray-700 mb-3">Update Status</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent mb-4">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Update Status
                        </button>
                    </form>

                    <!-- Payment Status -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-3">Payment Status</p>
                        @if($order->paid)
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center text-green-800">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold">Paid</span>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
                                <div class="flex items-center text-red-800 mb-4">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold">Unpaid</span>
                                </div>
                                
                                <form action="{{ route('cashier.orders.markAsPaid', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                                        Mark as Paid
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Receipt Actions -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-3">Receipt</p>
                        <a href="{{ route('cashier.orders.receipt', $order) }}" target="_blank" class="w-full py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-center block">
                            View/Print Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-modern-app-layout>
