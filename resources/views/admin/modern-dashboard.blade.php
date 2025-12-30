<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                Admin Dashboard
            </h1>
            <p class="text-gray-600">Overview and manage your restaurant</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Available items</p>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <p class="text-sm font-medium text-gray-600 mb-1">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                <p class="text-xs text-gray-500 mt-2">All time</p>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Need attention</p>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Registered</p>
            </div>
        </div>

        <!-- 🔥 Income Summary (TAMBAHAN) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.income.weekly') }}" class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">Penghasilan Minggu Ini</p>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <p class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($incomeWeek, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Click to see weekly breakdown</p>
            </a>

            <a href="{{ route('admin.income.monthly') }}" class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">Penghasilan Bulan Ini</p>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <p class="text-3xl font-bold text-blue-600">
                    Rp {{ number_format($incomeMonth, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Click to see monthly breakdown</p>
            </a>

            <a href="{{ route('admin.income.yearly') }}" class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">Penghasilan Tahun Ini</p>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <p class="text-3xl font-bold text-amber-600">
                    Rp {{ number_format($incomeYear, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Click to see yearly breakdown</p>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.products.index') }}" class="bg-gradient-to-br from-[#7B542F] to-[#5D3F22] rounded-2xl shadow-lg p-6 text-white">
                <h3 class="font-bold text-xl mb-2">Manage Products</h3>
                <p class="text-amber-100 text-sm">Add, edit, or delete items</p>
            </a>

            <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-[#7B542F] to-[#A0724B] rounded-2xl shadow-lg p-6 text-white">
                <h3 class="font-bold text-xl mb-2">Manage Users</h3>
                <p class="text-orange-100 text-sm">Control users and roles</p>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="bg-gradient-to-br from-[#CD853F] to-[#D2691E] rounded-2xl shadow-lg p-6 text-white">
                <h3 class="font-bold text-xl mb-2">View Orders</h3>
                <p class="text-orange-100 text-sm">Monitor all orders</p>
            </a>
        </div>

        <!-- Recent Orders (TETAP ASLI) -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Orders</h2>

            @foreach($recentOrders as $order)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl mb-2">
                    <div>
                        <p class="font-semibold">{{ $order->order_code }}</p>
                        <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <span class="text-xs text-gray-500">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-modern-app-layout>
