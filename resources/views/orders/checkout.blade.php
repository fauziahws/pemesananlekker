<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Pesanan</h3>
                        
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center py-2 border-b">
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $item['product']->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center text-xl font-bold border-t-2 pt-4">
                            <span>Total:</span>
                            <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pemesan</h3>
                        
                        <div class="mb-4">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pemesan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                id="customer_name" 
                                value="{{ old('customer_name', auth()->user()->name) }}"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="table_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Meja <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="table_number" 
                                id="table_number" 
                                value="{{ old('table_number') }}"
                                required
                                placeholder="Contoh: 5 atau A12"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('table_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-yellow-800">
                            <strong>Catatan:</strong> Setelah pesanan dikonfirmasi, Anda akan menerima struk pesanan. 
                            Silakan melakukan pembayaran di kasir.
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('cart.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-center transition duration-300">
                            Kembali
                        </a>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
