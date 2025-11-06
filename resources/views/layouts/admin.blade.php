<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Bimbingan Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-collapsed {
            width: 5rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
        .sidebar-transition {
            transition: width 0.3s ease-in-out;
        }
        .text-hide {
            opacity: 0;
            transition: opacity 0.2s;
        }
        .text-show {
            opacity: 1;
            transition: opacity 0.3s 0.1s;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-transition sidebar-expanded fixed inset-y-0 left-0 z-50 bg-gradient-to-b from-blue-800 to-blue-900 text-white transform lg:translate-x-0 lg:static">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 bg-blue-900">
                <div class="flex items-center overflow-hidden">
                    <i class="fas fa-graduation-cap text-2xl flex-shrink-0"></i>
                    <span id="logo-text" class="font-bold text-lg ml-3 whitespace-nowrap">Admin BK</span>
                </div>
                <button id="close-sidebar" class="lg:hidden text-white hover:text-gray-300 flex-shrink-0">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Toggle Collapse Button (Desktop Only) -->
            <div class="hidden lg:flex items-center justify-center py-2 border-b border-blue-700">
                <button id="toggle-collapse" class="text-white hover:bg-blue-700 p-2 rounded-lg transition">
                    <i id="collapse-icon" class="fas fa-chevron-left"></i>
                </button>
            </div>

            <!-- User Info -->
            <div id="user-info" class="px-6 py-4 border-b border-blue-700">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        @if(auth()->user()->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-xl"></i>
                        @endif
                    </div>
                    <div class="ml-3 overflow-hidden sidebar-text">
                        <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-blue-200">Guru BK</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 240px);">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition @if(request()->routeIs('admin.dashboard')) bg-blue-700 @endif"
                   title="Dashboard">
                    <i class="fas fa-chart-line w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ route('admin.konseling.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition relative @if(request()->routeIs('admin.konseling.*')) bg-blue-700 @endif"
                   title="Konseling">
                    <i class="fas fa-clipboard-list w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Konseling</span>
                    @php
                        $pending = \App\Models\Konseling::menunggu()->count();
                    @endphp
                    @if($pending > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full sidebar-text">{{ $pending }}</span>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center sidebar-icon-badge hidden">{{ $pending > 9 ? '9+' : $pending }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.messages.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition relative @if(request()->routeIs('admin.messages.*')) bg-blue-700 @endif"
                   title="Pesan">
                    <i class="fas fa-comments w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Pesan</span>
                    @php
                        $unread = \App\Models\Message::where('receiver_id', auth()->id())->unread()->count();
                    @endphp
                    @if($unread > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full sidebar-text">{{ $unread }}</span>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center sidebar-icon-badge hidden">{{ $unread > 9 ? '9+' : $unread }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition @if(request()->routeIs('admin.articles.*')) bg-blue-700 @endif"
                   title="Artikel">
                    <i class="fas fa-newspaper w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Artikel</span>
                </a>

                <a href="{{ route('admin.agendas.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition @if(request()->routeIs('admin.agendas.*')) bg-blue-700 @endif"
                   title="Agenda">
                    <i class="fas fa-calendar-alt w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Agenda</span>
                </a>

                <div class="border-t border-blue-700 my-4"></div>

                <a href="{{ route('home') }}" 
                   target="_blank" 
                   class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700 transition"
                   title="Lihat Website">
                    <i class="fas fa-globe w-6 flex-shrink-0"></i>
                    <span class="ml-3 sidebar-text whitespace-nowrap">Lihat Website</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-4 py-3 rounded-lg hover:bg-red-600 transition text-left"
                            title="Logout">
                        <i class="fas fa-sign-out-alt w-6 flex-shrink-0"></i>
                        <span class="ml-3 sidebar-text whitespace-nowrap">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between h-16 px-6">
                    <button id="open-sidebar" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <h1 class="text-xl font-semibold text-gray-800 hidden lg:block">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="relative text-gray-600 hover:text-gray-900">
                                <i class="fas fa-bell text-xl"></i>
                                @php
                                    $totalNotif = \App\Models\Konseling::menunggu()->count() + 
                                                  \App\Models\Message::where('receiver_id', auth()->id())->unread()->count();
                                @endphp
                                @if($totalNotif > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                        {{ $totalNotif > 9 ? '9+' : $totalNotif }}
                                    </span>
                                @endif
                            </button>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center">
                            <span class="text-sm text-gray-700 mr-2 hidden md:block">{{ auth()->user()->name }}</span>
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                @if(auth()->user()->foto)
                                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span class="text-white font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <script>
        // Sidebar elements
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');
        const toggleCollapseBtn = document.getElementById('toggle-collapse');
        const collapseIcon = document.getElementById('collapse-icon');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarIconBadges = document.querySelectorAll('.sidebar-icon-badge');
        const logoText = document.getElementById('logo-text');
        const userInfo = document.getElementById('user-info');

        // Check localStorage for collapse state
        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        // Apply initial state
        if (isCollapsed && window.innerWidth >= 1024) {
            collapseSidebar();
        }

        // Mobile sidebar toggle
        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Desktop collapse toggle
        toggleCollapseBtn.addEventListener('click', () => {
            if (isCollapsed) {
                expandSidebar();
            } else {
                collapseSidebar();
            }
        });

        function collapseSidebar() {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
            collapseIcon.classList.remove('fa-chevron-left');
            collapseIcon.classList.add('fa-chevron-right');
            
            // Hide text elements
            sidebarTexts.forEach(text => {
                text.classList.add('hidden');
            });
            logoText.classList.add('hidden');
            userInfo.classList.add('hidden');
            
            // Show icon badges
            sidebarIconBadges.forEach(badge => {
                badge.classList.remove('hidden');
            });
            
            isCollapsed = true;
            localStorage.setItem('sidebarCollapsed', 'true');
        }

        function expandSidebar() {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
            collapseIcon.classList.remove('fa-chevron-right');
            collapseIcon.classList.add('fa-chevron-left');
            
            // Show text elements with delay
            setTimeout(() => {
                sidebarTexts.forEach(text => {
                    text.classList.remove('hidden');
                });
                logoText.classList.remove('hidden');
                userInfo.classList.remove('hidden');
                
                // Hide icon badges
                sidebarIconBadges.forEach(badge => {
                    badge.classList.add('hidden');
                });
            }, 150);
            
            isCollapsed = false;
            localStorage.setItem('sidebarCollapsed', 'false');
        }

        // Reset on mobile
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                
                // Reapply collapse state
                if (isCollapsed) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            } else {
                // On mobile, always expanded when visible
                sidebar.classList.add('sidebar-expanded');
                sidebar.classList.remove('sidebar-collapsed');
                sidebarTexts.forEach(text => text.classList.remove('hidden'));
                logoText.classList.remove('hidden');
                userInfo.classList.remove('hidden');
                sidebarIconBadges.forEach(badge => badge.classList.add('hidden'));
            }
        });
    </script>
    @stack('scripts')
</body>
</html>