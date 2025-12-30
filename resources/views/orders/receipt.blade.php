<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <!-- Header -->
                <div class="text-center mb-6 pb-6 border-b-2">
                    <h1 class="text-3xl font-bold text-gray-900">🍽️ Lekker</h1>
                    <p class="text-gray-600 mt-2">Sistem Pemesanan</p>
                </div>

                <!-- Order Info -->
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div>
                            <p class="text-sm text-gray-600">Kode Pesanan:</p>
                            <p class="font-bold text-lg">{{ $order->order_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal:</p>
                            <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama Pemesan:</p>
                            <p class="font-semibold">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Meja:</p>
                            <p class="font-semibold">{{ $order->table_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-3 border-b pb-2">Detail Pesanan</h3>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <p class="font-semibold">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t-2 border-gray-800 pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Payment Notice -->
                <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 mb-6">
                    <p class="text-center text-blue-900 font-semibold">
                        ⚠️ Pembayaran dilakukan di kasir
                    </p>
                </div>

                <!-- Status -->
                <div class="text-center mb-6">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        Status: {{ $order->status_label }}
                    </span>
                </div>

                <!-- Footer -->
                <div class="text-center text-sm text-gray-600 mb-6 pt-6 border-t">
                    <p>Terima kasih atas pesanan Anda!</p>
                    <p class="mt-1">Simpan struk ini sebagai bukti pesanan</p>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ route('menu.index') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-center transition duration-300">
                        Kembali ke Menu
                    </a>
                    <button onclick="window.print()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition duration-300">
                        Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .max-w-2xl, .max-w-2xl * {
                visibility: visible;
            }
            .max-w-2xl {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            button, a {
                display: none;
            }
        }
    </style>
    @endpush
</x-app-layout>
