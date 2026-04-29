<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Auth</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-300 antialiased bg-slate-950 selection:bg-blue-500 selection:text-white">
        <!-- Abstract Background Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-[40%] -left-[20%] w-[70%] h-[70%] rounded-full bg-blue-900/20 blur-[120px]"></div>
            <div class="absolute top-[60%] -right-[20%] w-[60%] h-[60%] rounded-full bg-cyan-900/20 blur-[100px]"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-12">
            <div class="mb-8 text-center">
                <a href="/" class="inline-block group">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300 drop-shadow-[0_0_15px_rgba(56,189,248,0.4)] group-hover:drop-shadow-[0_0_25px_rgba(56,189,248,0.6)] transition-all duration-300">
                        SalesPage<span class="text-white">AI</span>
                    </h1>
                    <p class="mt-2 text-sm text-blue-200/60 font-medium tracking-wide uppercase">AI-Powered Conversion</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md p-8 bg-slate-900/60 backdrop-blur-xl border border-slate-700/50 shadow-[0_0_40px_-10px_rgba(59,130,246,0.3)] rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
