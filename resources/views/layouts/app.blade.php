<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coffee Shop') }}</title>

    <!-- Fonts - Poppins untuk coffee shop vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-coffee-100 dark:bg-black-coffee">
    
    <div class="flex h-screen overflow-hidden">
        
        {{-- SIDEBAR COFFEE THEME --}}
        <aside class="w-72 bg-gradient-to-b from-coffee-800 to-coffee-900 shadow-2xl">
            <div class="flex flex-col h-full">
                
                {{-- LOGO AREA dengan Coffee Icon --}}
                <div class="flex items-center justify-center h-20 border-b border-coffee-700 bg-coffee-900/50">
                    <div class="text-center">
                        <div class="text-4xl mb-1">☕</div>
                        <h1 class="text-2xl font-bold text-coffee-50 tracking-wide">
                            Coffee Shop
                        </h1>
                        <p class="text-xs text-coffee-300 mt-1">Admin Dashboard</p>
                    </div>
                </div>

                {{-- NAVIGATION MENU --}}
                <nav class="flex-1 overflow-y-auto py-6 px-4">
                    <div class="space-y-2">
                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-coffee-700 shadow-lg' : '' }}">
                            <span class="text-2xl mr-3">🏠</span>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        {{-- Categories --}}
                        <a href="{{ route('categories.index') }}" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-coffee-700 shadow-lg' : '' }}">
                            <span class="text-2xl mr-3">📋</span>
                            <span class="font-medium">Categories</span>
                        </a>

                        {{-- Products --}}
                        <a href="#" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group">
                            <span class="text-2xl mr-3">🫘</span>
                            <span class="font-medium">Products</span>
                        </a>

                        {{-- Orders --}}
                        <a href="#" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group">
                            <span class="text-2xl mr-3">🛒</span>
                            <span class="font-medium">Orders</span>
                        </a>

                        {{-- Customers --}}
                        <a href="#" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group">
                            <span class="text-2xl mr-3">👥</span>
                            <span class="font-medium">Customers</span>
                        </a>

                        {{-- Divider --}}
                        <div class="border-t border-coffee-700 my-4"></div>

                        {{-- Settings --}}
                        <a href="#" 
                           class="flex items-center px-4 py-3 text-coffee-100 hover:bg-coffee-700/50 rounded-xl transition-all duration-200 group">
                            <span class="text-2xl mr-3">⚙️</span>
                            <span class="font-medium">Settings</span>
                        </a>
                    </div>
                </nav>

                {{-- USER INFO & LOGOUT --}}
                <div class="border-t border-coffee-700 p-4 bg-coffee-900/30">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-caramel-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-coffee-50">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-coffee-300">Administrator</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            <span class="mr-2">🚪</span>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>

            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            
            {{-- HEADER --}}
            <header class="bg-white dark:bg-coffee-800 shadow-md">
                <div class="px-8 py-5">
                    {{-- PAGE HEADER --}}
                    <div class="flex items-center justify-between">
                        <div>
                            {{ $header ?? '' }}
                        </div>
                        <div class="flex items-center space-x-4">
                            {{-- Notification Bell --}}
                            <button class="relative p-2 text-coffee-600 dark:text-coffee-200 hover:bg-coffee-100 dark:hover:bg-coffee-700 rounded-lg transition-colors">
                                <span class="text-2xl">🔔</span>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            {{-- Current Date --}}
                            <div class="text-sm text-coffee-600 dark:text-coffee-300">
                                {{ now()->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 overflow-y-auto p-8 bg-coffee-50 dark:bg-gray-900">
                {{-- PAGE CONTENT --}}
                {{ $slot }}
            </main>

        </div>

    </div>

</body>
</html>