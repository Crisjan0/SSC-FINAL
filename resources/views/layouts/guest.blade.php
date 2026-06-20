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
        @vite(['resources/js/app.js'])

        <!-- Custom Animations -->
        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-12px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-[#f8f9fa] to-[#e2e8f0]" x-data="{ loading: true }" x-init="window.addEventListener('load', () => setTimeout(() => loading = false, 500)); document.readyState === 'complete' && setTimeout(() => loading = false, 500)">
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

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden relative">
            <!-- Decorative subtle glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#564af2] rounded-full mix-blend-multiply filter blur-[120px] opacity-10 pointer-events-none z-0"></div>
            
            <div class="relative z-10 w-full">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
