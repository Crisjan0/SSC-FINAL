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
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-[#f8f9fa] to-[#e2e8f0]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden relative">
            <!-- Decorative subtle glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#564af2] rounded-full mix-blend-multiply filter blur-[120px] opacity-10 pointer-events-none z-0"></div>
            
            <div class="relative z-10 w-full">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
