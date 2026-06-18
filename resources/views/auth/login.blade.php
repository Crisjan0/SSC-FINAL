<x-guest-layout>
    <!-- Container set to relative so the absolute image is attached to the card -->
    <div class="relative w-full max-w-[420px] mx-auto mt-32 sm:mt-24 md:mt-0 z-10 px-4 sm:px-0">

        <!-- Login Card Wrapper with sitting characters -->
        <div class="relative">
            <!-- Characters sitting on top of the card (mobile only) -->
            <div class="lg:hidden absolute -top-[93px] left-0 right-0 z-20 flex justify-between px-1 pointer-events-none">
                <!-- Teacher sitting on left edge -->
                <div class="w-[155px]">
                    <img src="{{ asset('images/teacher-sitting.png') }}" alt="Teacher" class="w-full h-auto drop-shadow-lg" onerror="this.parentElement.style.display='none'" />
                </div>
                <!-- Student sitting on right edge -->
                <div class="w-[155px]">
                    <img src="{{ asset('images/student-sitting.png') }}" alt="Student" class="w-full h-auto drop-shadow-lg" onerror="this.parentElement.style.display='none'" />
                </div>
            </div>

            <!-- The Main Login Card -->
            <div class="bg-white rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(86,74,242,0.2)] overflow-hidden relative z-10 border border-indigo-50/50 transition-all duration-300 hover:shadow-[0_20px_60px_-15px_rgba(86,74,242,0.3)]">
                <!-- Header section featuring the logo and school name (replacing the plain "LOG IN" text) -->
                <div class="bg-[#564af2] pt-4 pb-6 px-6 text-center relative flex flex-col items-center">
                    <!-- School Logo -->
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-lg mb-2 z-10">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="SSC Logo" class="w-full h-full object-cover">
                    </div>
                    <!-- School Name -->
                    <h2 class="text-sm font-extrabold text-white tracking-wide leading-tight px-2 z-10">
                        Northlink Technological College
                    </h2>
                    <!-- Subtitle -->
                    <p class="text-[9px] text-indigo-100 font-extrabold uppercase tracking-widest mt-1 z-10">
                        Supreme Student Council
                    </p>
                </div>
                
                <!-- Form body -->
                <div class="px-6 py-6 sm:px-10 sm:py-10">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div class="group">
                            <label for="email" class="block text-xs font-extrabold text-[#564af2] mb-1.5 ml-1">{{ __('Email Address') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#564af2] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <input id="email" 
                                    class="block w-full border border-gray-200 focus:border-[#564af2] focus:ring-[#564af2] rounded-xl shadow-sm pl-11 pr-4 py-3 text-gray-700 bg-gray-50/50 focus:bg-white text-sm transition-all" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    placeholder="jondoe32@gmail.com"
                                    required 
                                    autofocus 
                                    autocomplete="username" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <label for="password" class="block text-xs font-extrabold text-[#564af2] mb-1.5 ml-1">{{ __('Password') }}</label>
                            <div class="relative" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#564af2] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input id="password" 
                                    class="block w-full border border-gray-200 focus:border-[#564af2] focus:ring-[#564af2] rounded-xl shadow-sm pl-11 pr-10 py-3 text-gray-700 bg-gray-50/50 focus:bg-white text-sm transition-all"
                                    :type="show ? 'text' : 'password'"
                                    name="password"
                                    required 
                                    autocomplete="current-password" 
                                    placeholder="••••••••" />
                                <!-- Password Eye Toggle -->
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center opacity-50 hover:opacity-100 transition-opacity">
                                    <svg x-show="!show" class="h-4 w-4 text-[#564af2]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    <svg x-show="show" x-cloak class="h-4 w-4 text-[#564af2]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="flex items-center justify-start pt-1">
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-[#564af2] hover:text-indigo-800 transition-colors ml-1" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="pt-5">
                            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-[#564af2]/30 text-sm font-bold text-white bg-gradient-to-r from-[#564af2] to-[#6b5eff] hover:from-[#473adb] hover:to-[#5749ff] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#564af2] transition-all duration-300 tracking-wider">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- The 3D Character Image (Teacher on the left side of the card) - Desktop only -->
        <div class="absolute lg:-left-[220px] xl:-left-[290px] top-[10%] z-20 pointer-events-none w-[320px] xl:w-[380px] hidden lg:block">
            <img src="{{ asset('images/teacher.png') }}" alt="Teacher" class="w-full h-auto drop-shadow-2xl transition-transform duration-500 hover:scale-105" onerror="this.style.display='none'" />
        </div>

        <!-- The 3D Character Image (Student on the right side of the card) - Desktop only -->
        <div class="absolute lg:-right-[180px] xl:-right-[220px] top-[10%] z-20 pointer-events-none w-[280px] xl:w-[350px] hidden lg:block">
            <img src="{{ asset('images/student.png') }}" alt="Student" class="w-full h-auto drop-shadow-2xl transition-transform duration-500 hover:scale-105" onerror="this.style.display='none'" />
        </div>
    </div>
</x-guest-layout>