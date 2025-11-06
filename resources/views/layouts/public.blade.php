<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bimbingan Konseling')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                        <span class="font-bold text-xl text-gray-800">BK System</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition @if(request()->routeIs('home')) text-blue-600 font-semibold @endif">
                        Beranda
                    </a>
                    <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-blue-600 transition @if(request()->routeIs('articles.*')) text-blue-600 font-semibold @endif">
                        Artikel
                    </a>
                    <a href="{{ route('agendas.index') }}" class="text-gray-700 hover:text-blue-600 transition @if(request()->routeIs('agendas.*')) text-blue-600 font-semibold @endif">
                        Agenda
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 transition @if(request()->routeIs('contact')) text-blue-600 font-semibold @endif">
                        Kontak
                    </a>
                    @auth
                        @if(auth()->user()->role === 'guru_bk')
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Dashboard Siswa
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 font-semibold transition flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded @if(request()->routeIs('home')) bg-blue-50 text-blue-600 @endif">
                    Beranda
                </a>
                <a href="{{ route('articles.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded @if(request()->routeIs('articles.*')) bg-blue-50 text-blue-600 @endif">
                    Artikel
                </a>
                <a href="{{ route('agendas.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded @if(request()->routeIs('agendas.*')) bg-blue-50 text-blue-600 @endif">
                    Agenda
                </a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded @if(request()->routeIs('contact')) bg-blue-50 text-blue-600 @endif">
                    Kontak
                </a>
                @auth
                    @if(auth()->user()->role === 'guru_bk')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">
                            Dashboard Siswa
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 rounded flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Bimbingan Konseling</h3>
                    <p class="text-gray-400">Layanan konseling profesional untuk mendukung perkembangan siswa.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Menu</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('articles.index') }}" class="text-gray-400 hover:text-white">Artikel</a></li>
                        <li><a href="{{ route('agendas.index') }}" class="text-gray-400 hover:text-white">Agenda</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone mr-2"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-envelope mr-2"></i> bk@sekolah.sch.id</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Pendidikan No. 123</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Bimbingan Konseling. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>