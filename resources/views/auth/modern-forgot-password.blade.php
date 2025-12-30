<x-modern-guest-layout>
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/50">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-center bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                Forgot Password
            </h2>
            <p class="text-gray-600">Reset your password</p>
        </div>

        <!-- Info -->
        <div class="mb-6 p-4 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl">
            <p class="text-sm text-[#7B542F]">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-transparent transition @error('email') border-red-500 @enderror"
                    placeholder="you@example.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7B542F]"
            >
                Email Password Reset Link
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Remember your password? 
                <a href="{{ route('login') }}" class="font-semibold text-[#7B542F] hover:text-[#5D3F22] transition">
                    Back to Login
                </a>
            </p>
        </div>
    </div>
</x-modern-guest-layout>