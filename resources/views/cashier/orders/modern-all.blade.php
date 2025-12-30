<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                All Orders
            </h1>
            <p class="text-gray-600">Complete order history</p>
        </div>

        <!-- Navigation Tab -->
        <div class="flex space-x-2 mb-6">
            <a href="{{ route('cashier.orders') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-50 border border-gray-200 transition">
                Pending Orders
            </a>
            <a href="{{ route('cashier.orders.all') }}" class="px-6 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white rounded-xl font-medium shadow-md">
                All Orders
            </a>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-gray-100">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                <p class="text-gray-600">Orders will appear here once customers place them</p>
            </div>
        @else
            <!-- Orders Grid -->
            <div class="grid grid-cols-1 gap-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <!-- Order Code -->
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-[#7B542F] to-[#A0724B] rounded-xl flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">{{ substr($order->order_code, -3) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Order Code</p>
                                        <p class="font-mono font-bold text-lg text-gray-900">{{ $order->order_code }}</p>
                                    </div>
                                </div>

                                <!-- Status Badges -->
                                <div class="flex items-center space-x-3">
                                    <span class="px-4 py-2 rounded-xl text-sm font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    
                                    @if($order->paid)
                                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-xl text-sm font-semibold flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Paid
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-xl text-sm font-semibold flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Unpaid
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Order Details Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-600 mb-1">Customer</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-600 mb-1">Order Type</p>
                                    <p class="font-semibold text-gray-900 flex items-center">
                                        @if($order->order_type === 'takeaway')
                                            <svg class="w-4 h-4 mr-1 text-[#A0724B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Takeaway
                                        @else
                                            <svg class="w-4 h-4 mr-1 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dine In
                                        @endif
                                    </p>
                                </div>

                                @if($order->order_type === 'dine_in' && $order->table_number)
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-600 mb-1">Table</p>
                                    <p class="font-semibold text-gray-900">{{ $order->table_number }}</p>
                                </div>
                                @endif

                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-600 mb-1">Total Amount</p>
                                    <p class="font-bold text-lg bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-600 mb-1">Payment Method</p>
                                    <p class="font-semibold text-gray-900">
                                        @if($order->payment_method === 'cash')
                                            <span class="flex items-center text-green-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Cash
                                            </span>
                                        @else
                                            <span class="flex items-center text-[#7B542F]">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                Virtual Account
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Time -->
                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ordered {{ $order->created_at->diffForHumans() }}
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('cashier.orders.show', $order) }}" class="block w-full py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-center font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-modern-app-layout>
