<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal') — GoERP</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        @media (max-width: 640px) {
            .sidebar { transform: translateX(-100%); position: fixed; z-index: 50; transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 40; }
            .overlay.open { display: block; }
        }
    </style>
</head>
<body class="h-full bg-stone-50 antialiased font-sans text-stone-800">
<div class="flex h-full">
    {{-- Mobile overlay --}}
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar w-64 bg-gradient-to-b from-indigo-900 to-indigo-950 text-white flex flex-col fixed lg:relative h-full shadow-xl z-50" id="sidebar">
        <div class="p-5 border-b border-white/10">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center font-bold text-white text-sm">E</div>
                <span class="font-bold text-lg tracking-tight">GoERP Portal</span>
            </a>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors hover:bg-white/10 {{ request()->routeIs('portal.dashboard') ? 'bg-white/15 font-semibold' : '' }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('portal.invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors hover:bg-white/10 {{ request()->routeIs('portal.invoices') ? 'bg-white/15 font-semibold' : '' }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Faktur
            </a>
            <a href="{{ route('portal.payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors hover:bg-white/10 {{ request()->routeIs('portal.payments') ? 'bg-white/15 font-semibold' : '' }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Pembayaran
            </a>
        </nav>
        <div class="p-4 border-t border-white/10">
            <form action="{{ route('portal.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors hover:bg-white/10 w-full text-left text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-auto">
        {{-- Topbar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-stone-200 px-6 py-3 flex items-center justify-between">
            <button class="lg:hidden p-1.5 rounded-lg hover:bg-stone-100 text-stone-600" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="text-sm text-stone-500">Selamat datang di Portal Customer</div>
        </header>
        <div class="p-6">
            @yield('content')
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('open');
    }
</script>
</body>
</html>
