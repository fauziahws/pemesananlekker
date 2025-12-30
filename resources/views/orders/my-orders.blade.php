<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($orders->isEmpty())
                    <p class="text-gray-500 text-center py-8">Anda belum memiliki pesanan.</p>
                @else
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-4 hover:shadow-md transition duration-300">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $order->order_code }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="text-sm text-gray-600">Meja: {{ $order->table_number }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $order->status_label }}
                                        </span>
                                        @if($order->paid)
                                            <span class="block mt-1 text-xs text-green-600 font-semibold">✓ Sudah Dibayar</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="border-t pt-3 mb-3">
                                    <div class="space-y-2">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex justify-between text-sm">
                                                <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                                                <span>Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex justify-between items-center border-t pt-3">
                                    <span class="font-bold">Total:</span>
                                    <span class="font-bold text-lg text-blue-600">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('orders.receipt', $order) }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                        Lihat Struk →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
