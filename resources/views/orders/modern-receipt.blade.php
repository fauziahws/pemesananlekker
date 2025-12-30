<x-modern-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center text-green-800">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Receipt Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] p-8 text-white text-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Order Successful!</h1>
                <p class="text-amber-100">Thank you for your order</p>
            </div>

            <!-- Order Details -->
            <div class="p-8">
                <!-- Order Code & Status -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Order Code</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->order_code }}</p>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Order Type</p>
                        <p class="text-lg font-bold text-gray-900">
                            @if($order->order_type === 'takeaway')
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-[#A0724B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Takeaway
                                </span>
                            @else
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dine In
                                </span>
                            @endif
                        </p>
                    </div>
                    @if($order->order_type === 'dine_in' && $order->table_number)
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Table Number</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->table_number }}</p>
                    </div>
                    @endif
                    <div class="text-center p-4 rounded-xl
                        @if($order->status === 'pending') bg-yellow-50
                        @elseif($order->status === 'processing') bg-blue-50
                        @elseif($order->status === 'completed') bg-green-50
                        @else bg-gray-50
                        @endif">
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <p class="text-lg font-bold
                            @if($order->status === 'pending') text-yellow-800
                            @elseif($order->status === 'processing') text-blue-800
                            @elseif($order->status === 'completed') text-green-800
                            @else text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </p>
                    </div>
                </div>

                <!-- Payment Method Info -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payment Information
                    </h2>

                    @if($order->payment_method === 'virtual_account')
                        <!-- Virtual Account Payment -->
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border-2 border-amber-200">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <p class="text-sm text-[#5D3F22] font-medium mb-1">Virtual Account Number</p>
                                    <p class="text-2xl font-bold text-[#5D3F22] tracking-wider">
                                        {{ chunk_split($order->virtual_account_number, 4, ' ') }}
                                    </p>
                                </div>
                                <button 
                                    onclick="copyVA()" 
                                    class="px-4 py-2 bg-white hover:bg-gray-50 text-[#7B542F] font-medium rounded-lg transition flex items-center space-x-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span>Copy</span>
                                </button>
                            </div>

                            <div class="bg-white/70 backdrop-blur-sm rounded-lg p-4 mb-4">
                                <p class="text-sm text-gray-700 mb-2">
                                    <strong>Cara Pembayaran:</strong>
                                </p>
                                <ol class="text-sm text-gray-700 space-y-1 list-decimal list-inside">
                                    <li>Buka aplikasi mobile banking Anda</li>
                                    <li>Pilih menu Transfer Virtual Account</li>
                                    <li>Masukkan nomor virtual account di atas</li>
                                    <li>Konfirmasi pembayaran sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></li>
                                    <li>Setelah transfer, klik tombol "Cek Status Pembayaran" di bawah</li>
                                </ol>
                            </div>

                            <!-- Payment Status -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full {{ $order->paid ? 'bg-green-500' : 'bg-yellow-500' }} animate-pulse"></div>
                                    <span class="text-sm font-medium {{ $order->paid ? 'text-green-800' : 'text-yellow-800' }}">
                                        {{ $order->paid ? 'Pembayaran Terkonfikasi' : 'Menunggu Pembayaran' }}
                                    </span>
                                </div>

                                @if(!$order->paid)
                                    <form action="{{ route('orders.checkPayment', $order) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="px-6 py-2 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition transform"
                                        >
                                            Cek Status Pembayaran
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Cash Payment -->
                        <div class="bg-green-50 rounded-xl p-6 border-2 border-green-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-green-900 mb-1">Cash at Cashier</p>
                                    <p class="text-sm text-green-700">Please proceed to the cashier counter to make your payment</p>
                                </div>
                                <div class="w-3 h-3 rounded-full {{ $order->paid ? 'bg-green-500' : 'bg-yellow-500' }} animate-pulse"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Order Items
                    </h2>

                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-bold text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t-2 border-gray-200 pt-6 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-gray-900">Total Amount</span>
                        <span class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a 
                        href="{{ route('orders.my-orders') }}"
                        class="flex-1 py-3 bg-gray-100 text-gray-700 text-center font-medium rounded-xl hover:bg-gray-200 transition"
                    >
                        View My Orders
                    </a>
                    <a 
                        href="{{ route('menu.index') }}"
                        class="flex-1 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-center font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform"
                    >
                        Order More
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyVA() {
            const vaNumber = '{{ $order->virtual_account_number }}';
            navigator.clipboard.writeText(vaNumber).then(() => {
                alert('Virtual Account Number copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
    </script>
    @endpush
</x-modern-app-layout>
