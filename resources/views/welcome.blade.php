<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoERP — SaaS ERP Accounting, Inventory & Production</title>
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
        @keyframes floatSlow { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        @keyframes shimmer { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
        .animate-float { animation: floatSlow 5s ease-in-out infinite }
        .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(.16,1,.3,1) forwards }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent 25%, rgba(255,255,255,.08) 50%, transparent 75%);
            background-size: 200% 100%;
            animation: shimmer 2s ease-in-out infinite;
        }
        .delay-1 { animation-delay: 0.1s }
        .delay-2 { animation-delay: 0.25s }
        .delay-3 { animation-delay: 0.4s }
        .delay-4 { animation-delay: 0.55s }
    </style>
</head>
<body class="h-full bg-white dark:bg-zinc-950 antialiased text-zinc-900 dark:text-zinc-100">

<div class="relative min-h-screen flex flex-col items-center justify-center px-4">

    {{-- Background gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-violet-50 dark:from-zinc-950 dark:via-zinc-950 dark:to-zinc-900"></div>

    {{-- Decorative blobs --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-indigo-200/30 to-violet-200/20 dark:from-indigo-500/10 dark:to-violet-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gradient-to-tr from-indigo-300/20 to-blue-300/10 dark:from-indigo-600/5 dark:to-blue-600/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>

    <div class="relative z-10 w-full max-w-3xl text-center">

        {{-- Logo + Icon --}}
        <div class="animate-fade-up opacity-0 mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/25 mb-6 animate-float">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <h1 class="text-5xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Go</span><span class="text-zinc-900 dark:text-white">ERP</span>
            </h1>
        </div>

        {{-- Tagline --}}
        <p class="animate-fade-up delay-1 opacity-0 text-lg text-zinc-600 dark:text-zinc-400 max-w-xl mx-auto leading-relaxed mb-8">
            SaaS ERP lengkap dengan <span class="font-semibold text-zinc-800 dark:text-zinc-200">Accounting</span>, <span class="font-semibold text-zinc-800 dark:text-zinc-200">Inventory</span>, <span class="font-semibold text-zinc-800 dark:text-zinc-200">Production</span> &amp; <span class="font-semibold text-zinc-800 dark:text-zinc-200">Marketplace</span> untuk bisnis Indonesia. Multi-tenant, double-entry accounting, real-time reports.
        </p>

        {{-- CTA Buttons --}}
        <div class="animate-fade-up delay-2 opacity-0 flex flex-col sm:flex-row items-center justify-center gap-3 mb-12">
            <a href="{{ url('/admin') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-semibold shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Masuk Admin Panel
            </a>
            <a href="{{ url('/docs') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:border-zinc-400 dark:hover:border-zinc-600 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Dokumentasi
            </a>
        </div>

        {{-- Modules Grid --}}
        <div class="animate-fade-up delay-3 opacity-0 grid grid-cols-2 sm:grid-cols-4 gap-3 mb-12">
            @php
            $modules = [
                ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Accounting'],
                ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'label' => 'Inventory'],
                ['icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z', 'label' => 'Production'],
                ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z', 'label' => 'Marketplace'],
            ];
            @endphp
            @foreach ($modules as $mod)
            <div class="group relative overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 text-center hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-md transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/50 to-transparent dark:from-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $mod['icon'] }}" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $mod['label'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Demo Login Box --}}
        <div class="animate-fade-up delay-4 opacity-0 inline-block text-left bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 max-w-sm mx-auto">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Demo Login</span>
            </div>
            <div class="space-y-1.5 text-xs text-zinc-600 dark:text-zinc-400 font-mono">
                <div class="flex justify-between">
                    <span class="font-semibold text-zinc-700 dark:text-zinc-300">Admin</span>
                    <span>admin@goerp.test / password</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="relative z-10 mt-auto py-6 text-center text-xs text-zinc-400 dark:text-zinc-600">
        &copy; {{ date('Y') }} GoERP &middot; Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot; PHP {{ PHP_VERSION }}
    </div>
</div>

</body>
</html>
