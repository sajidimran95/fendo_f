<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Fendo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: background .15s, color .15s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(99,102,241,.15); color: #818cf8; }
        .sidebar-link.active { border-right: 3px solid #6366f1; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex">

    <!-- ===== SIDEBAR ===== -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-900 border-r border-white/5 flex flex-col z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

        <!-- Logo -->
        <div class="p-5 border-b border-white/5 flex items-center space-x-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Fendo</p>
                <p class="text-xs text-indigo-400 font-medium">Admin Panel</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold px-3 pt-2 pb-1">Main</p>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Users</span>
            </a>

            <a href="{{ route('admin.transactions') }}" class="sidebar-link {{ request()->routeIs('admin.transactions*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Loans</span>
            </a>

            <a href="{{ route('admin.feedback') }}" class="sidebar-link {{ request()->routeIs('admin.feedback*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>Feedback</span>
            </a>

            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold px-3 pt-4 pb-1">Account</p>

            <a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>My Profile</span>
            </a>

            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold px-3 pt-4 pb-1">System</p>

            <a href="{{ url('/') }}" target="_blank" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-300">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Website</span>
            </a>
        </nav>

        <!-- Admin user info -->
        <div class="p-4 border-t border-white/5">
            <div class="flex items-center space-x-3 mb-3">
                @if(Auth::user()->avatarUrl())
                    <img src="{{ Auth::user()->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-2 text-xs text-gray-400 hover:text-red-400 transition-colors w-full px-2 py-1.5 rounded-lg hover:bg-red-500/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <!-- Top Bar -->
        <header class="sticky top-0 z-20 bg-gray-950/90 backdrop-blur border-b border-white/5 px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Mobile menu btn -->
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-base font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500 hidden sm:block">@yield('page-subtitle', 'Welcome back, ' . Auth::user()->name)</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="hidden sm:flex items-center space-x-1.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-medium px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
                    <span>Administrator</span>
                </span>
                @if(Auth::user()->avatarUrl())
                    <img src="{{ Auth::user()->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover">
                @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-xs font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6">
            @if (session('success'))
                <div class="flex items-center space-x-3 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl px-4 py-3 mb-5 text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            const isOpen   = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay.classList.toggle('hidden', isOpen);
        }
    </script>
    @stack('scripts')
</body>
</html>
