<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIM Klinik Pratama')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">SIM Klinik</h1>
                            <p class="text-xs text-gray-500">Pratama</p>
                        </div>
                    </div>
                    <div class="hidden md:ml-8 md:flex md:space-x-1">
                        <a href="{{ route('admissions.index') }}" class="{{ request()->routeIs('admissions.index') ? 'text-blue-600 border-blue-600' : 'text-gray-600 hover:text-gray-900 border-transparent' }} px-3 py-2 text-sm font-medium border-b-2 transition-colors">
                            Dashboard
                        </a>
                        <a href="{{ route('admissions.create') }}" class="{{ request()->routeIs('admissions.create') ? 'text-blue-600 border-blue-600' : 'text-gray-600 hover:text-gray-900 border-transparent' }} px-3 py-2 text-sm font-medium border-b-2 transition-colors">
                            Pendaftaran Baru
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-medium text-gray-700">Admin SIM</p>
                        <p class="text-xs text-gray-500">{{ now()->format('d M Y') }}</p>
                    </div>
                    <div class="w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admissions.index') }}" class="{{ request()->routeIs('admissions.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }} block px-3 py-2 rounded-md text-sm font-medium">
                    Dashboard
                </a>
                <a href="{{ route('admissions.create') }}" class="{{ request()->routeIs('admissions.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }} block px-3 py-2 rounded-md text-sm font-medium">
                    Pendaftaran Baru
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start space-x-6">
                    <span class="text-sm text-gray-500">&copy; {{ date('Y') }} SIM Klinik Pratama</span>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-center md:text-right text-xs text-gray-400">Built with Laravel 11 & Tailwind CSS</p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
