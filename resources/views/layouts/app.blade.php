<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Scripts -->
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-hidden" x-data="{ loading: true, sidebarOpen: false }" x-init="window.addEventListener('load', () => setTimeout(() => loading = false, 500)); document.readyState === 'complete' && setTimeout(() => loading = false, 500)">
        <div x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/95 backdrop-blur-sm">
            <div class="relative flex items-center justify-center">
                <div class="absolute h-36 w-36 rounded-full border-4 border-[#564af2]/25 border-t-[#564af2] animate-spin sm:h-44 sm:w-44"></div>
                <div class="absolute h-28 w-28 rounded-full border-4 border-transparent border-b-[#8b5cf6] animate-spin sm:h-36 sm:w-36"
                     style="animation-duration: 1.4s; animation-direction: reverse;"></div>
                <img src="{{ asset('images/logo.jpeg') }}"
                     alt="Loading"
                     class="relative h-20 w-20 rounded-full object-cover shadow-xl ring-4 ring-white sm:h-28 sm:w-28">
            </div>
        </div>

    <div class="flex h-screen overflow-hidden bg-gray-100">
        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 lg:hidden"
             @click="sidebarOpen = false"
             x-cloak>
        </div>

        {{-- Sidebar --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:overscroll-contain">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col min-w-0">
            @include('layouts.navigation')

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    </body>
</html>
