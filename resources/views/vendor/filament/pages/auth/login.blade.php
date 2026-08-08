<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — GoERP</title>
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
    @filamentStyles
    <style>
        @keyframes floatSlow { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-float { animation: floatSlow 5s ease-in-out infinite }
        .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(.16,1,.3,1) forwards }
        .delay-1 { animation-delay: 0.1s }
        .delay-2 { animation-delay: 0.25s }
        .delay-3 { animation-delay: 0.4s }

        /* Override Filament form inside our two-column layout */
        .fi-simple-page {
            max-width: none !important;
            padding: 0 !important;
        }
        .fi-simple-main {
            max-width: none !important;
            width: 100% !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
        }
        .fi-simple-page .fi-logo {
            display: none !important;
        }
    </style>
</head>
<body class="h-full bg-white antialiased text-zinc-900">

<div class="min-h-screen flex">
    {{-- Left: Brand Hero Panel --}}
    <div class="hidden lg:flex lg:w-1/2 xl:w-5/12 relative bg-gradient-to-br from-indigo-700 via-indigo-800 to-zinc-900 p-12 flex-col justify-between overflow-hidden">
        {{-- Decorative gradient circles --}}
        <div class="absolute inset-0 opacity-30"
             style="background-image: radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.4) 0%, transparent 50%), radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.3) 0%, transparent 50%)"></div>

        {{-- Large decorative icon --}}
        <div class="absolute -bottom-20 -right-20 text-[20rem] opacity-10 select-none">🏢</div>

        {{-- Logo + Brand --}}
        <div class="relative z-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-white group">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/15 backdrop-blur shadow-lg group-hover:bg-white/20 transition-colors">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <span class="font-extrabold text-3xl tracking-tight">GoERP</span>
            </a>
        </div>

        {{-- Tagline + Benefit Cards --}}
        <div class="relative z-10 text-white">
            <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-3 tracking-tight">
                SaaS ERP Accounting, Inventory & Production untuk bisnis Indonesia
            </h2>
            <p class="text-indigo-200 text-lg leading-relaxed mb-10 max-w-md">
                Kelola keuangan, gudang, produksi, dan marketplace dalam satu dashboard. Double-entry accounting, multi-warehouse, real-time reports.
            </p>
            <div class="grid grid-cols-3 gap-4 max-w-md">
                <div class="bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10 hover:bg-white/15 transition-colors">
                    <svg class="w-6 h-6 text-indigo-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs font-semibold text-white">Accounting Double-Entry</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10 hover:bg-white/15 transition-colors">
                    <svg class="w-6 h-6 text-indigo-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <p class="text-xs font-semibold text-white">Multi-Warehouse Inventory</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10 hover:bg-white/15 transition-colors">
                    <svg class="w-6 h-6 text-indigo-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                    </svg>
                    <p class="text-xs font-semibold text-white">Marketplace Import</p>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="relative z-10 text-indigo-200/70 text-xs">
            &copy; {{ date('Y') }} GoERP &middot; Powered by Laravel
        </div>
    </div>

    {{-- Right: Login Form --}}
    <div class="flex-1 flex items-center justify-center p-8 lg:p-16 bg-white">
        <div class="w-full max-w-md">
            {{-- Mobile logo (visible only on small screens) --}}
            <div class="lg:hidden mb-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/25 mb-4 animate-float">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-zinc-900">
                    <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Go</span><span class="text-zinc-900">ERP</span>
                </h1>
            </div>

            <h1 class="text-4xl font-extrabold text-zinc-900 mb-2">Masuk ke GoERP</h1>
            <p class="text-zinc-500 mb-8">
                @if (filament()->hasRegistration())
                Belum punya akun?
                <a href="{{ filament()->getRegistrationUrl() }}" class="text-indigo-600 font-semibold hover:underline">Daftar gratis</a>
                @endif
            </p>

            {{-- Error Display --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-800 mb-1">Login gagal</p>
                        <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- Filament Form --}}
            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}
            </x-filament-panels::form>

            {{-- Divider --}}
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-4 text-sm text-zinc-400 font-medium">atau</span>
                </div>
            </div>

            {{-- Demo Login Box --}}
            <div class="bg-zinc-50 border border-zinc-200 rounded-xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span class="text-sm font-semibold text-zinc-800">Demo Login</span>
                </div>
                <div class="space-y-1.5 text-xs text-zinc-600 font-mono">
                    <div class="flex justify-between">
                        <span class="font-semibold text-zinc-700">Admin</span>
                        <span>admin@goerp.test / password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@filamentScripts
</body>
</html>
