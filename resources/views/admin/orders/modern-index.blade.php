<x-modern-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                    All Orders
                </h1>
                <p class="text-gray-600 mt-1">View and monitor all customer orders</p>
            </div>

            <!-- Orders Grid -->
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                            <div class="p-6">
                                <!-- Order Header -->
                                <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
                                    <div class="flex items-center gap-3">
                                        <span class="px-4 py-2 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-bold rounded-xl text-sm">
                                            #{{ substr($order->order_code, -3) }}
                                        </span>
                                        
                                        @if($order->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                                Pending
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                                Processing
                                            </span>
                                        @elseif($order->status === 'completed')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                                Completed
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                                Cancelled
                                            </span>
                                        @endif

                                        @if($order->paid)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Paid
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                                Unpaid
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="px-4 py-2 bg-[#7B542F] text-white font-semibold rounded-xl hover:bg-[#5D3F22] transition-colors duration-200">
                                        View Details
                                    </a>
                                </div>

                                <!-- Order Details Grid -->
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                    <!-- Customer -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Customer</p>
                                        <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                    </div>

                                    <!-- Order Type -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Order Type</p>
                                        <p class="font-semibold text-gray-900 flex items-center">
                                            @if($order->order_type === 'dine_in')
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                </svg>
                                                Dine In
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                Takeaway
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Table -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Table</p>
                                        <p class="font-semibold text-gray-900">{{ $order->table_number ?? '-' }}</p>
                                    </div>

                                    <!-- Payment Method -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Payment</p>
                                        <p class="font-semibold text-gray-900 flex items-center">
                                            @if($order->payment_method === 'cash')
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Cash
                                            @else
                                                <svg class="w-4 h-4 mr-1 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                                Virtual Account
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Total -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Total</p>
                                        <p class="font-bold text-lg bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- Time -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Ordered</p>
                                        <p class="text-sm text-gray-900 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $order->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-[#7B542F] to-[#A0724B] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                    <p class="text-gray-600">Orders from customers will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</x-modern-app-layout>