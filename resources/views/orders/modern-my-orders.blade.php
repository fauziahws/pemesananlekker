<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                My Orders
            </h1>
            <p class="text-gray-600">Track your order history</p>
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
                <p class="text-gray-600 mb-6">Start ordering your favorite food!</p>
                <a href="{{ route('menu.index') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    Browse Menu
                </a>
            </div>
        @else
            <!-- Orders Grid -->
            <div class="grid grid-cols-1 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-[#7B542F] to-[#A0724B] rounded-xl flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">{{ substr($order->order_code, -3) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-mono font-bold text-xl text-gray-900">{{ $order->order_code }}</p>
                                        <div class="flex items-center space-x-3 text-sm text-gray-600 mt-1">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </span>
                                            @if($order->order_type === 'dine_in' && $order->table_number)
                                                <span class="text-gray-400">•</span>
                                                <span>Table {{ $order->table_number }}</span>
                                            @elseif($order->order_type === 'takeaway')
                                                <span class="text-gray-400">•</span>
                                                <span class="inline-flex items-center text-[#A0724B]">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg>
                                                    Takeaway
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badges -->
                                <div class="flex flex-col items-end space-y-2">
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

                            <!-- Order Items -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                                <div class="space-y-3">
                                    @foreach($order->orderItems as $item)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                            <div class="flex items-center space-x-3">
                                                @if($item->product->image_url)
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded-lg">
                                                @else
                                                    <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                                    <p class="text-sm text-gray-600">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <p class="font-bold text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                                    <p class="text-2xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('orders.receipt', $order) }}" class="px-6 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    View Receipt
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-modern-app-layout>
