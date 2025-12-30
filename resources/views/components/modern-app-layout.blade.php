<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lekker') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ open: false, userOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#7B542F] to-[#A0724B] rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold text-xl">L</span>
                            </div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                                Lekker
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products*') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Products
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users*') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Users
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.orders*') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Orders
                            </a>
                        @elseif(auth()->user()->isCashier())
                            <a href="{{ route('cashier.orders') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cashier.orders') && !request()->routeIs('cashier.orders.all') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Pending Orders
                            </a>
                            <a href="{{ route('cashier.orders.all') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cashier.orders.all') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                All Orders
                            </a>
                        @else
                            <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('menu.index') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Menu
                            </a>
                            <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cart.index') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                Cart
                                @php
                                    $cartCount = session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full font-bold">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.my-orders') }}" class="text-gray-700 hover:text-[#7B542F] px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('orders.my-orders') ? 'text-[#7B542F] bg-amber-50' : '' }}">
                                My Orders
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-[#7B542F] transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#7B542F] to-[#A0724B] rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-200">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-[#7B542F] transition">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" class="text-gray-700 hover:text-[#7B542F]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="open" x-transition class="sm:hidden border-t border-gray-200 bg-white">
                <div class="px-4 py-3 space-y-1">
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Products</a>
                        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Users</a>
                        <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Orders</a>
                    @elseif(auth()->user()->isCashier())
                        <a href="{{ route('cashier.orders') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Pending Orders</a>
                        <a href="{{ route('cashier.orders.all') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">All Orders</a>
                    @else
                        <a href="{{ route('menu.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Menu</a>
                        <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Cart</a>
                        <a href="{{ route('orders.my-orders') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">My Orders</a>
                    @endif
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-[#7B542F]">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-8">
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
