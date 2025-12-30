<x-modern-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center text-[#7B542F] hover:text-[#5D3F22] mb-4 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                    Order Details
                </h1>
                <p class="text-gray-600 mt-1">View complete order information</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Information -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] px-6 py-4">
                            <h2 class="text-xl font-bold text-white">Order Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Order Code</p>
                                    <p class="font-bold text-gray-900">{{ $order->order_code }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Customer</p>
                                    <p class="font-bold text-gray-900">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Order Type</p>
                                    <p class="font-bold text-gray-900">
                                        @if($order->order_type === 'dine_in')
                                            Dine In
                                        @else
                                            Takeaway
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Table Number</p>
                                    <p class="font-bold text-gray-900">{{ $order->table_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                                    <p class="font-bold text-gray-900">
                                        @if($order->payment_method === 'cash')
                                            Cash at Cashier
                                        @else
                                            Virtual Account
                                        @endif
                                    </p>
                                </div>
                                @if($order->payment_method === 'virtual_account' && $order->virtual_account_number)
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500 mb-1">Virtual Account Number</p>
                                        <p class="font-mono font-bold text-gray-900 text-lg">
                                            {{ chunk_split($order->virtual_account_number, 4, ' ') }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Order Time</p>
                                    <p class="font-bold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] px-6 py-4">
                            <h2 class="text-xl font-bold text-white">Order Items</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                                        @if($item->product->image)
                                            <img src="{{ Storage::url($item->product->image) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-20 h-20 object-cover rounded-xl">
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-r from-[#7B542F] to-[#A0724B] rounded-xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-lg bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                                Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total -->
                            <div class="mt-6 pt-6 border-t-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-gray-900">Total Amount</span>
                                    <span class="text-2xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden sticky top-6">
                        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] px-6 py-4">
                            <h2 class="text-xl font-bold text-white">Order Status</h2>
                        </div>
                        <div class="p-6">
                            <!-- Current Status -->
                            <div class="mb-6 text-center">
                                <p class="text-sm text-gray-500 mb-2">Current Status</p>
                                @if($order->status === 'pending')
                                    <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-lg font-bold">
                                        Pending
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-lg font-bold">
                                        Processing
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full text-lg font-bold">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded-full text-lg font-bold">
                                        Cancelled
                                    </span>
                                @endif
                            </div>

                            <!-- Payment Status -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm text-gray-500 mb-3">Payment Status</p>
                                @if($order->paid)
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                                        <svg class="w-12 h-12 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-green-800 font-bold">Paid</p>
                                    </div>
                                @else
                                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                                        <svg class="w-12 h-12 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-red-800 font-bold">Unpaid</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-modern-app-layout>