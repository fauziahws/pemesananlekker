<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesanan - {{ $order->order_code }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-700">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                    <div><p class="text-sm text-gray-600">Kode Pesanan</p><p class="font-bold text-lg">{{ $order->order_code }}</p></div>
                    <div><p class="text-sm text-gray-600">Waktu Pesan</p><p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p></div>
                    <div><p class="text-sm text-gray-600">Nama Pemesan</p><p class="font-semibold">{{ $order->customer_name }}</p></div>
                    <div><p class="text-sm text-gray-600">Nomor Meja</p><p class="font-semibold text-xl">{{ $order->table_number }}</p></div>
                </div>

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
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Status Pesanan:</p>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Status Pembayaran:</p>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->paid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $order->paid ? '✓ Sudah Dibayar' : 'Belum Dibayar' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
