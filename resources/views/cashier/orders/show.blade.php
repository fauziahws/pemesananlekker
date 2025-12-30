<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan') }} - {{ $order->order_code }}
            </h2>
            <a href="{{ route('cashier.orders') }}" class="text-blue-600 hover:text-blue-700">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Order Info -->
                <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                    <div>
                        <p class="text-sm text-gray-600">Kode Pesanan</p>
                        <p class="font-bold text-lg">{{ $order->order_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Waktu Pesan</p>
                        <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Pemesan</p>
                        <p class="font-semibold">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nomor Meja</p>
                        <p class="font-semibold text-xl">{{ $order->table_number }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-4">Detail Pesanan</h3>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex gap-4 items-center p-3 bg-gray-50 rounded-lg">
                                @if($item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <p class="font-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Status Management -->
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-lg mb-4">Kelola Status</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Status Pesanan:</p>
                        <form action="{{ route('cashier.orders.updateStatus', $order) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="rounded-lg border-gray-300 flex-1">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-2">Status Pembayaran:</p>
                        @if($order->paid)
                            <div class="flex items-center gap-2">
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                                    ✓ Sudah Dibayar
                                </span>
                                <form action="{{ route('cashier.orders.markAsUnpaid', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                        Tandai Belum Bayar
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cashier.orders.markAsPaid', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-300">
                                    Tandai Sudah Dibayar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
