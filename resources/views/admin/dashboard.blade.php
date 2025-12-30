<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Total Pesanan</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Pesanan Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Total User</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="bg-amber-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-[#7B542F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                    <h3 class="font-semibold text-lg mb-2">Kelola Produk</h3>
                    <p class="text-gray-600 text-sm">Tambah, edit, atau hapus produk</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                    <h3 class="font-semibold text-lg mb-2">Kelola User</h3>
                    <p class="text-gray-600 text-sm">Atur user dan role</p>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                    <h3 class="font-semibold text-lg mb-2">Lihat Pesanan</h3>
                    <p class="text-gray-600 text-sm">Monitor semua pesanan</p>
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Pesanan Terbaru</h3>
                @if($recentOrders->isEmpty())
                    <p class="text-gray-500 text-center py-8">Belum ada pesanan.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold">{{ $order->order_code }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->customer_name }} - Meja {{ $order->table_number }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    <span class="text-xs px-2 py-1 rounded-full
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
