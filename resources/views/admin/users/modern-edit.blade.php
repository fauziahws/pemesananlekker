<x-modern-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center text-[#7B542F] hover:text-[#5D3F22] mb-4 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Users
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent">
                    Edit User
                </h1>
                <p class="text-gray-600 mt-1">Update user account information</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-[#7B542F] transition-colors duration-200" 
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-[#7B542F] transition-colors duration-200" 
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                            User Role
                        </label>
                        <select id="role" 
                                name="role" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-[#7B542F] transition-colors duration-200" 
                                required>
                            <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="cashier" {{ old('role', $user->role) === 'cashier' ? 'selected' : '' }}>Cashier</option>
                            <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Change Password (Optional)</h3>
                        <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-[#7B542F] transition-colors duration-200">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#7B542F] focus:border-[#7B542F] transition-colors duration-200">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4">
                        <button type="submit" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white font-semibold rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-colors duration-200 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-modern-app-layout>
