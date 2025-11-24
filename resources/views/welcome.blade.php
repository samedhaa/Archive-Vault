<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ArchiveVault - Preserve Your Memories</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">ArchiveVault</span>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ route('archives.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                                    Go to My Archives
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                        Preserve Your <span class="text-indigo-600">Memories</span> Forever
                    </h1>
                    <p class="text-xl text-gray-600 mb-10">
                        A secure personal archive system to organize, store, and preserve your photos, videos, documents, and cherished moments in one beautiful place.
                    </p>

                    @auth
                        <a href="{{ route('archives.index') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            View My Archives
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Start Your Archive
                        </a>
                    @endauth
                </div>

                <!-- Features -->
                <div class="mt-24 grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Organize Everything</h3>
                        <p class="text-gray-600">Create unlimited archives to organize your photos, videos, PDFs, and documents by events, dates, or categories.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Find Instantly</h3>
                        <p class="text-gray-600">Powerful search and filtering by keywords, dates, file types, and categories to find any memory in seconds.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure & Private</h3>
                        <p class="text-gray-600">Your archives are completely private. Only you can access, view, and manage your personal collection.</p>
                    </div>
                </div>

                <!-- Stats/Highlights -->
                <div class="mt-20 bg-white rounded-xl shadow-lg p-12">
                    <div class="grid md:grid-cols-3 gap-8 text-center">
                        <div>
                            <div class="text-4xl font-bold text-indigo-600 mb-2">Unlimited</div>
                            <div class="text-gray-600">Archives & Collections</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-indigo-600 mb-2">20MB</div>
                            <div class="text-gray-600">Per File Upload</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-indigo-600 mb-2">100%</div>
                            <div class="text-gray-600">Private & Secure</div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                @guest
                <div class="mt-20 text-center bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-12 text-white">
                    <h2 class="text-3xl font-bold mb-4">Ready to Start Preserving?</h2>
                    <p class="text-xl mb-8 opacity-90">Join ArchiveVault today and never lose a precious memory again.</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-100 text-indigo-600 text-lg font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        Create Free Account
                    </a>
                </div>
                @endguest
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-gray-600">
                    <p>&copy; {{ date('Y') }} ArchiveVault. Built with Laravel.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
