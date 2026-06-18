<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ __('Add New Officer Account') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-6">
                <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Officer List
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 sm:p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800">Officer Registration</h3>
                        <p class="text-sm text-gray-500">Fill in the details below to create a new system access account.</p>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" placeholder="e.g. Juan Dela Cruz" value="{{ old('name') }}" required 
                                    class="w-full capitalize rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('name') border-red-500 @enderror">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" placeholder="officer@ssc.com" value="{{ old('email') }}" required 
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('email') border-red-500 @enderror">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Role</label>
                                <select name="role" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    <option value="admin">Admin / Officer</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Regular User</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Initial Password</label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" name="password" placeholder="Minimum 8 characters" required 
                                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm pr-10 @error('password') border-red-500 @enderror">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 italic">Note: Provide a strong temporary password for the officer.</p>
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end space-x-4">
                            <button type="reset" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                                Reset Form
                            </button>
                            <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-blue-700 shadow-md transition duration-150">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>