<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoERP — SaaS ERP Accounting, Inventory & Production untuk Bisnis Indonesia</title>
    <meta name="description" content="GoERP adalah ERP SaaS lengkap dengan Accounting, Inventory, Production, CRM, Marketplace & AI. Multi-tenant, double-entry accounting, real-time reports. Coba demo gratis.">
    <meta property="og:title" content="GoERP — SaaS ERP untuk Bisnis Indonesia">
    <meta property="og:description" content="ERP SaaS lengkap: Accounting, Inventory, Production, CRM & Marketplace. Coba demo gratis.">
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url('/') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|jetbrains-mono:400,500,700" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes floatSlow { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes floatSlowReverse { 0%,100%{transform:translateY(0)} 50%{transform:translateY(12px)} }
        @keyframes fadeSlideUp { 0%{transform:translateY(40px);opacity:0} 100%{transform:translateY(0);opacity:1} }
        @keyframes fadeSlideRight { 0%{transform:translateX(-30px);opacity:0} 100%{transform:translateX(0);opacity:1} }
        @keyframes fadeSlideLeft { 0%{transform:translateX(30px);opacity:0} 100%{transform:translateX(0);opacity:1} }
        @keyframes scaleIn { 0%{transform:scale(.85);opacity:0} 100%{transform:scale(1);opacity:1} }
        @keyframes shimmer { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
        @keyframes pingSlow { 0%{transform:scale(1);opacity:1} 100%{transform:scale(1.5);opacity:0} }
        @keyframes gradientShift { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        @keyframes countUp { 0%{opacity:0;transform:translateY(10px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-float { animation: floatSlow 5s ease-in-out infinite }
        .animate-float-reverse { animation: floatSlowReverse 6s ease-in-out infinite }
        .animate-floating-delayed { animation: floatSlow 6s ease-in-out 2s infinite }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent 25%, rgba(255,255,255,.15) 50%, transparent 75%);
            background-size: 200% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        .animate-ping-slow { animation: pingSlow 2s cubic-bezier(0,0,.2,1) infinite }
        .reveal { opacity:0;transform:translateY(30px);transition:opacity .7s,transform .7s cubic-bezier(.16,1,.3,1) }
        .reveal.visible { opacity:1;transform:translateY(0) }
        .reveal-left { opacity:0;transform:translateX(-30px);transition:opacity .7s,transform .7s cubic-bezier(.16,1,.3,1) }
        .reveal-left.visible { opacity:1;transform:translateX(0) }
        .reveal-right { opacity:0;transform:translateX(30px);transition:opacity .7s,transform .7s cubic-bezier(.16,1,.3,1) }
        .reveal-right.visible { opacity:1;transform:translateX(0) }
        .reveal-scale { opacity:0;transform:scale(.85);transition:opacity .7s,transform .7s cubic-bezier(.16,1,.3,1) }
        .reveal-scale.visible { opacity:1;transform:scale(1) }
        .delay-1 { transition-delay: .1s }
        .delay-2 { transition-delay: .2s }
        .delay-3 { transition-delay: .3s }
        .delay-4 { transition-delay: .4s }
        .delay-5 { transition-delay: .5s }
        .card-lift { transition: transform .35s,box-shadow .35s }
        .card-lift:hover { transform:translateY(-6px);box-shadow:0 24px 48px -12px rgba(0,0,0,.18) }
        .stagger>* { opacity:0;transform:translateY(20px);transition:opacity .6s,transform .6s cubic-bezier(.16,1,.3,1) }
        .stagger.visible>*:nth-child(1){transition-delay:.05s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(2){transition-delay:.15s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(3){transition-delay:.25s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(4){transition-delay:.35s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(5){transition-delay:.45s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(6){transition-delay:.55s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(7){transition-delay:.65s;opacity:1;transform:translateY(0)}
        .stagger.visible>*:nth-child(8){transition-delay:.75s;opacity:1;transform:translateY(0)}
        .glass { backdrop-filter:blur(12px) saturate(180%);-webkit-backdrop-filter:blur(12px) saturate(180%) }
        @media (prefers-reduced-motion:reduce) {
            *{animation-duration:.01ms!important;transition-duration:.01ms!important}
        }
        html{scroll-padding-top:80px}
    </style>
</head>
<body class="bg-white text-stone-900 antialiased font-sans">

{{-- ===== STICKY HEADER ===== --}}
<header x-data="{ open: false }" class="fixed top-0 inset-x-0 z-50 bg-white/80 glass border-b border-stone-200/60 transition-colors duration-300">
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
        <a href="/" class="flex items-center gap-2.5 shrink-0">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
            </div>
            <span class="font-extrabold text-xl tracking-tight">Go<span class="text-indigo-600">ERP</span></span>
        </a>
        <div class="hidden lg:flex items-center gap-1 text-sm font-medium text-stone-600">
            <a href="#fitur" class="px-3 py-2 rounded-lg hover:text-stone-900 hover:bg-stone-100 transition-colors">Fitur</a>
            <a href="#modul" class="px-3 py-2 rounded-lg hover:text-stone-900 hover:bg-stone-100 transition-colors">Modul</a>
            <a href="#harga" class="px-3 py-2 rounded-lg hover:text-stone-900 hover:bg-stone-100 transition-colors">Harga</a>
            <a href="#demo" class="px-3 py-2 rounded-lg hover:text-stone-900 hover:bg-stone-100 transition-colors">Demo</a>
            <a href="/docs" class="px-3 py-2 rounded-lg hover:text-stone-900 hover:bg-stone-100 transition-colors">Dokumentasi</a>
        </div>
        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ url('/app') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200">Masuk</a>
        </div>
        <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-stone-600 hover:bg-stone-100">
            <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            <svg x-show="open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </nav>
    <div x-show="open" x-transition class="lg:hidden border-t border-stone-200 bg-white px-4 py-4 space-y-2">
        <a href="#fitur" @click="open=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-600 hover:bg-stone-100">Fitur</a>
        <a href="#modul" @click="open=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-600 hover:bg-stone-100">Modul</a>
        <a href="#harga" @click="open=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-600 hover:bg-stone-100">Harga</a>
        <a href="#demo" @click="open=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-600 hover:bg-stone-100">Demo</a>
        <a href="/docs" @click="open=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-600 hover:bg-stone-100">Dokumentasi</a>
        <a href="{{ url('/app') }}" class="block px-3 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold text-center">Masuk</a>
    </div>
</header>

{{-- ===== HERO SECTION ===== --}}
<section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-violet-50"></div>
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-bl from-indigo-200/40 to-violet-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 animate-float"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-300/20 to-blue-300/10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4 animate-float-reverse"></div>
    <div class="absolute top-1/2 left-1/3 w-3 h-3 bg-indigo-400 rounded-full animate-ping-slow opacity-20"></div>
    <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-violet-400 rounded-full animate-ping-slow opacity-20" style="animation-delay:1s"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 w-full">
        <div class="max-w-4xl mx-auto text-center">
            <div class="reveal opacity-0 mb-6" style="opacity:0">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                    <span class="relative flex h-2 w-2"><span class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
                    SaaS ERP Multi-Tenant
                </span>
            </div>
            <h1 class="reveal opacity-0 delay-1 text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-stone-900 leading-tight" style="opacity:0">
                Satu Platform ERP
                <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent animate-gradient">Lengkap</span>
                untuk Bisnis Anda
            </h1>
            <p class="reveal opacity-0 delay-2 text-lg sm:text-xl text-stone-500 max-w-2xl mx-auto leading-relaxed mt-6" style="opacity:0">
                Accounting, Inventory, Production, CRM, Marketplace &mdash; semua dalam satu dashboard. Double-entry accounting otomatis, real-time reports, multi-cabang, dan AI-powered analytics. Dibuat untuk bisnis Indonesia.
            </p>
            <div class="reveal opacity-0 delay-3 mt-10 flex flex-col sm:flex-row items-center justify-center gap-4" style="opacity:0">
                <a href="{{ url('/app') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-semibold text-lg shadow-xl shadow-indigo-500/25 hover:shadow-2xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200 card-lift">
                    Coba Demo Gratis
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
                <a href="/docs" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl border-2 border-stone-300 text-stone-700 font-semibold text-lg hover:bg-stone-50 hover:border-stone-400 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Dokumentasi
                </a>
            </div>
            <p class="reveal opacity-0 delay-4 mt-6 text-sm text-stone-400">Tanpa install · Tanpa server · Langsung pakai di browser</p>
        </div>
    </div>
</section>

{{-- ===== STATS COUNTER BAR ===== --}}
<section class="relative -mt-20 z-20 max-w-4xl mx-auto px-4 sm:px-6">
    <div class="reveal opacity-0 bg-white border border-stone-200 rounded-2xl shadow-xl shadow-stone-200/50 p-6 sm:p-8 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6" style="opacity:0">
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">14</div>
            <div class="text-sm text-stone-500 mt-1">Role Pengguna</div>
        </div>
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">22</div>
            <div class="text-sm text-stone-500 mt-1">Grup Modul</div>
        </div>
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">69+</div>
            <div class="text-sm text-stone-500 mt-1">Resource</div>
        </div>
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">99.9%</div>
            <div class="text-sm text-stone-500 mt-1">Uptime SLA</div>
        </div>
    </div>
</section>

{{-- ===== TRUST STRIP — WHO IS THIS FOR ===== --}}
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-14" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Siapa yang Cocok Pakai GoERP?</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Dari UMKM sampai enterprise — GoERP fleksibel untuk berbagai skala bisnis</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 stagger">
            @php
            $personas = [
                ['icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z', 'label' => 'Multi-Cabang', 'desc' => 'Bisnis dengan banyak cabang & gudang'],
                ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Finance Team', 'desc' => 'Tim finance & accounting yang butuh akurasi'],
                ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'label' => 'Gudang & Logistik', 'desc' => 'Manajemen stok multi-gudang & mutasi'],
                ['icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z', 'label' => 'Manufaktur', 'desc' => 'Produksi dengan BOM, WO, QC, piece rate'],
                ['icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z', 'label' => 'Owner Bisnis', 'desc' => 'Pantau semua dari satu dashboard'],
            ];
            @endphp
            @foreach($personas as $p)
            <div class="group relative overflow-hidden rounded-2xl border border-stone-200 bg-white p-5 sm:p-6 text-center hover:border-indigo-300 hover:shadow-lg transition-all duration-300 card-lift">
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $p['icon'] }}" /></svg>
                    </div>
                    <h3 class="font-bold text-stone-900 text-sm sm:text-base">{{ $p['label'] }}</h3>
                    <p class="text-xs sm:text-sm text-stone-500 mt-1">{{ $p['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== PROBLEM / SOLUTION ===== --}}
<section class="py-20 lg:py-28 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Stop Pakai Excel, Mulai Pakai ERP</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Bisnis modern butuh sistem terintegrasi, bukan spreadsheet yang rawan error dan susah di-track</p>
        </div>
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
            <div class="reveal-left opacity-0 rounded-2xl border-2 border-red-200 bg-red-50/50 p-8" style="opacity:0">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <h3 class="font-extrabold text-xl text-red-800">Tanpa ERP</h3>
                </div>
                <ul class="space-y-3 text-sm text-red-700">
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Data terpisah-pisah di Excel &mdash; susah konsolidasi</li>
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Stok tidak real-time &mdash; sering kelebihan atau kehabisan</li>
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Laporan keuangan manual &mdash; lambat & rawan human error</li>
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Tidak bisa track biaya produksi per item</li>
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Approval transaksi tidak terstruktur</li>
                    <li class="flex gap-2"><span class="text-red-400 mt-0.5">&times;</span> Multi-cabang? Beda file, beda versi &mdash; chaos</li>
                </ul>
            </div>
            <div class="reveal-right opacity-0 rounded-2xl border-2 border-emerald-200 bg-emerald-50/50 p-8" style="opacity:0">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </div>
                    <h3 class="font-extrabold text-xl text-emerald-800">Dengan GoERP</h3>
                </div>
                <ul class="space-y-3 text-sm text-emerald-700">
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> Satu database terpusat &mdash; semua tim akses data yang sama</li>
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> Stok real-time multi-gudang &mdash; tahu persis posisi inventory</li>
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> Laporan otomatis &mdash; P&L, Neraca, Arus Kas langsung jadi</li>
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> HPP produksi akurat &mdash; material, labour, overhead ter-track</li>
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> Workflow approval multi-level &mdash; transaksi terkontrol</li>
                    <li class="flex gap-2"><span class="text-emerald-500 mt-0.5">&check;</span> Multi-cabang, multi-gudang &mdash; semua dalam satu dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURE SECTIONS (Alternating) ===== --}}
<section id="fitur" class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Fitur Unggulan GoERP</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Dibangun untuk menangani kompleksitas bisnis nyata di Indonesia</p>
        </div>

        @php
        $features = [
            [
                'title' => 'Double-Entry Accounting',
                'desc' => 'Sistem akuntansi double-entry penuh dengan Chart of Accounts, jurnal otomatis dari setiap transaksi, general ledger, trial balance, sampai laporan keuangan.',
                'bullets' => ['COA multi-level & hierarchical', 'Jurnal otomatis dari Sales, Purchase, Finance', 'General Ledger real-time', 'Tutup buku per periode fiskal', 'Jurnal berulang (recurring)', 'Lock period untuk keamanan data'],
                'color' => 'indigo',
                'icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'image' => 'accounting',
            ],
            [
                'title' => 'Inventory Multi-Gudang',
                'desc' => 'Kelola stok di banyak gudang secara real-time. Mutasi, transfer antar gudang, stock adjustment, dan stock opname dalam satu sistem terintegrasi.',
                'bullets' => ['Saldo stok real-time per gudang', 'Mutasi stok otomatis dari transaksi', 'Transfer antar gudang', 'Stock adjustment & stock opname', 'Batch & expiry tracking', 'Notifikasi stok minimum'],
                'color' => 'emerald',
                'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
                'image' => 'inventory',
            ],
            [
                'title' => 'Alur Penjualan Lengkap',
                'desc' => 'Dari penawaran harga sampai pembayaran lunas — seluruh siklus penjualan terintegrasi dengan inventory dan accounting secara otomatis.',
                'bullets' => ['Sales Quotation → Sales Order', 'Delivery Order dengan tracking', 'Sales Invoice auto-generate', 'Multi-metode pembayaran', 'Retur penjualan terintegrasi', 'Laporan penjualan per customer & produk'],
                'color' => 'violet',
                'icon' => 'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z',
                'image' => 'sales',
            ],
            [
                'title' => 'Manufacturing & Produksi',
                'desc' => 'Kelola proses produksi dari Bill of Materials, Production Order, Work Order, sampai output jadi/reject/rework. HPP produksi terhitung otomatis.',
                'bullets' => ['Bill of Materials (BOM) multi-level', 'Production Order & Work Order', 'Material Request ke gudang', 'Output: Good / Reject / Rework', 'Piece rate / borongan', 'HPP produksi real-time'],
                'color' => 'amber',
                'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z',
                'image' => 'production',
            ],
            [
                'title' => 'Finance & Kas',
                'desc' => 'Manajemen keuangan lengkap: rekening bank, transaksi kas/bank, biaya operasional, kas kecil, cash advance, dan rekonsiliasi otomatis.',
                'bullets' => ['Multi rekening bank', 'Transaksi kas/bank terintegrasi', 'Biaya operasional & petty cash', 'Cash advance tracking', 'Rekonsiliasi bank otomatis', 'Laporan arus kas real-time'],
                'color' => 'cyan',
                'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
                'image' => 'finance',
            ],
            [
                'title' => 'Marketplace & POS',
                'desc' => 'Import pesanan dari Shopee, TikTok, Tokopedia, Lazada. Mapping SKU otomatis. POS outlet untuk transaksi offline. Semua terintegrasi ke stok & accounting.',
                'bullets' => ['Import Excel marketplace', 'SKU mapping otomatis', 'POS outlet multi-lokasi', 'Integrasi stok real-time', 'Promo & diskon', 'Laporan penjualan per channel'],
                'color' => 'rose',
                'icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z',
                'image' => 'marketplace',
            ],
            [
                'title' => 'Laporan & Dashboard',
                'desc' => 'Dashboard interaktif per role + laporan keuangan standar PSAK: Laba Rugi, Neraca, Arus Kas. Sales report, stock report, dan custom report template.',
                'bullets' => ['P&L, Balance Sheet, Cash Flow', 'Sales & Stock reports', 'Dashboard per role (Owner, Finance, Sales, dll)', 'Export PDF & Excel', 'Report template custom', 'Real-time data refresh'],
                'color' => 'blue',
                'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                'image' => 'reports',
            ],
            [
                'title' => 'AI & Workflow Automation',
                'desc' => 'BYOK AI (bawa kunci sendiri) — integrasi OpenAI, DeepSeek, Gemini, atau LLM lain. Workflow approval multi-level untuk kontrol transaksi.',
                'bullets' => ['AI provider manager (BYOK)', 'Dashboard analitik AI', 'Approval workflow multi-level', 'Aturan workflow custom per modul', 'Audit log semua aktivitas', 'Notifikasi real-time'],
                'color' => 'purple',
                'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z',
                'image' => 'ai',
            ],
        ];
        @endphp

        @foreach($features as $i => $f)
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center {{ $i > 0 ? 'mt-20 lg:mt-28' : '' }}">
            <div class="reveal-left opacity-0 {{ $i % 2 === 1 ? 'lg:order-2' : '' }}" style="opacity:0">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-{{ $f['color'] }}-100 text-{{ $f['color'] }}-600 mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" /></svg>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-stone-900 mb-4">{{ $f['title'] }}</h3>
                <p class="text-stone-500 leading-relaxed mb-6">{{ $f['desc'] }}</p>
                <ul class="space-y-2.5">
                    @foreach($f['bullets'] as $b)
                    <li class="flex items-start gap-3 text-sm text-stone-600">
                        <svg class="w-5 h-5 text-{{ $f['color'] }}-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        {{ $b }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="reveal-right opacity-0 {{ $i % 2 === 1 ? 'lg:order-1' : '' }}" style="opacity:0">
                <div class="relative rounded-2xl border border-stone-200 bg-stone-50 overflow-hidden shadow-lg">
                    <div class="flex items-center gap-1.5 px-4 py-3 border-b border-stone-200 bg-white">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        <div class="ml-3 flex-1 h-6 rounded-md bg-stone-100 text-[10px] text-stone-400 flex items-center px-3 font-mono truncate">app.goerp.test / {{ strtolower(str_replace(' ', '-', $f['title'])) }}</div>
                    </div>
                    <div class="p-6 sm:p-8 min-h-[280px] flex items-center justify-center bg-gradient-to-br from-stone-50 to-{{ $f['color'] }}-50/30">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-{{ $f['color'] }}-100 text-{{ $f['color'] }}-600 mb-4">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" /></svg>
                            </div>
                            <p class="text-sm text-stone-400 font-mono">Screenshot {{ $f['title'] }}</p>
                            <p class="text-xs text-stone-300 mt-1">Run <code class="text-{{ $f['color'] }}-500">scripts/screenshot.cjs</code> to capture</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== MODULES GRID ===== --}}
<section id="modul" class="py-20 lg:py-28 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">22 Grup Modul — Satu Platform</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Semua yang dibutuhkan bisnis modern dalam satu aplikasi terintegrasi</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 stagger">
            @php
            $modules = [
                ['icon' => '🏠', 'name' => 'Dashboard', 'count' => '4 dashboard per role'],
                ['icon' => '🏢', 'name' => 'Organisasi', 'count' => '6 resource'],
                ['icon' => '📚', 'name' => 'Master Data', 'count' => '8 resource'],
                ['icon' => '👥', 'name' => 'CRM', 'count' => '3 resource'],
                ['icon' => '💰', 'name' => 'Penjualan', 'count' => '5 resource'],
                ['icon' => '🛒', 'name' => 'Pembelian', 'count' => '5 resource'],
                ['icon' => '📦', 'name' => 'Inventory', 'count' => '5 resource'],
                ['icon' => '🏭', 'name' => 'Warehouse', 'count' => '3 resource'],
                ['icon' => '🏗️', 'name' => 'Manufacturing', 'count' => '6 resource'],
                ['icon' => '💵', 'name' => 'Finance', 'count' => '5 resource'],
                ['icon' => '📊', 'name' => 'Accounting', 'count' => '9 resource'],
                ['icon' => '🧾', 'name' => 'Tax', 'count' => '1 resource'],
                ['icon' => '🏦', 'name' => 'Asset', 'count' => '2 resource'],
                ['icon' => '🛍️', 'name' => 'Marketplace', 'count' => '4 resource'],
                ['icon' => '📈', 'name' => 'Reports', 'count' => '6 laporan'],
                ['icon' => '🔄', 'name' => 'Workflow', 'count' => '2 resource'],
                ['icon' => '🔐', 'name' => 'Security', 'count' => 'Audit log'],
                ['icon' => '🔌', 'name' => 'Integrations', 'count' => '2 resource'],
                ['icon' => '🤖', 'name' => 'AI', 'count' => '2 resource'],
                ['icon' => '📥', 'name' => 'Import/Export', 'count' => '1 resource'],
                ['icon' => '🔔', 'name' => 'Notifikasi', 'count' => '2 resource'],
                ['icon' => '⚙️', 'name' => 'Settings', 'count' => '7 halaman'],
            ];
            @endphp
            @foreach($modules as $m)
            <div class="group relative overflow-hidden rounded-xl border border-stone-200 bg-white p-4 sm:p-5 hover:border-indigo-300 hover:shadow-md transition-all duration-300 card-lift">
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <span class="text-2xl">{{ $m['icon'] }}</span>
                    <h3 class="font-bold text-stone-900 mt-2 text-sm sm:text-base">{{ $m['name'] }}</h3>
                    <p class="text-xs text-stone-400 mt-1">{{ $m['count'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== USE CASES ===== --}}
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Use Cases — GoERP di Berbagai Industri</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Fleksibel untuk berbagai jenis bisnis di Indonesia</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 stagger">
            @php
            $cases = [
                ['icon' => '👕', 'title' => 'Fashion & Retail', 'desc' => 'Kelola ribuan SKU dengan varian (warna, ukuran). Inventory multi-gudang, POS outlet, marketplace integration (Shopee/TikTok). HPP akurat per item.', 'roles' => 'Owner, Gudang, Sales, Kasir, Finance'],
                ['icon' => '📱', 'title' => 'Elektronik & Gadget', 'desc' => 'Serial number tracking, warranty management. Purchase order ke supplier, penerimaan QC, retur. Multi-cabang dengan stok real-time.', 'roles' => 'Owner, Purchasing, Warehouse, Sales'],
                ['icon' => '🏭', 'title' => 'Manufaktur & Produksi', 'desc' => 'BOM multi-level, production order, work order, material request. Output tracking (good/reject/rework). Piece rate untuk buruh produksi. HPP produksi real-time.', 'roles' => 'Owner, Production, Warehouse, Finance'],
                ['icon' => '🍽️', 'title' => 'F&B & Restoran', 'desc' => 'Multi-outlet POS, central kitchen production ke cabang. Inventory bahan baku dengan batch tracking. COGS per menu item. Laporan laba rugi per outlet.', 'roles' => 'Owner, Production, Kasir, Warehouse, Finance'],
            ];
            @endphp
            @foreach($cases as $c)
            <div class="group rounded-2xl border border-stone-200 bg-white p-6 sm:p-8 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 card-lift">
                <div class="text-4xl mb-4">{{ $c['icon'] }}</div>
                <h3 class="text-xl font-extrabold text-stone-900 mb-3">{{ $c['title'] }}</h3>
                <p class="text-stone-500 text-sm leading-relaxed mb-4">{{ $c['desc'] }}</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(explode(', ', $c['roles']) as $r)
                    <span class="text-xs px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-600 font-medium">{{ $r }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== DEMO ACCOUNTS ===== --}}
<section id="demo" class="py-20 lg:py-28 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Coba Demo Sekarang</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Semua akun demo sudah aktif — gunakan yang sesuai role Anda. Password: <code class="bg-stone-200 px-2 py-0.5 rounded text-sm font-mono text-stone-700">password</code></p>
        </div>

        {{-- Two Panels --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            <div class="reveal-left opacity-0" style="opacity:0">
                <div class="bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
                        <h3 class="font-extrabold text-lg">Platform Admin</h3>
                        <p class="text-indigo-100 text-sm">goerp.whitelabel.co.id/admin</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-stone-50 border-b border-stone-200">
                                <tr><th class="text-left px-5 py-3 text-xs font-semibold text-stone-500 uppercase tracking-wider">Role</th><th class="text-left px-5 py-3 text-xs font-semibold text-stone-500 uppercase tracking-wider">Email</th></tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Super Admin</td><td class="px-5 py-3 font-mono text-xs text-stone-600">admin@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Platform Admin</td><td class="px-5 py-3 font-mono text-xs text-stone-600">platform@goerp.test</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="reveal-right opacity-0" style="opacity:0">
                <div class="bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                        <h3 class="font-extrabold text-lg">ERP Customer Panel</h3>
                        <p class="text-emerald-100 text-sm">goerp.whitelabel.co.id/app</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-stone-50 border-b border-stone-200">
                                <tr><th class="text-left px-5 py-3 text-xs font-semibold text-stone-500 uppercase tracking-wider">Role</th><th class="text-left px-5 py-3 text-xs font-semibold text-stone-500 uppercase tracking-wider">Email</th></tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Pemilik</td><td class="px-5 py-3 font-mono text-xs text-stone-600">owner@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Admin</td><td class="px-5 py-3 font-mono text-xs text-stone-600">admin@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Finance</td><td class="px-5 py-3 font-mono text-xs text-stone-600">finance@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Akuntansi</td><td class="px-5 py-3 font-mono text-xs text-stone-600">accounting@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Sales</td><td class="px-5 py-3 font-mono text-xs text-stone-600">sales@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Purchasing</td><td class="px-5 py-3 font-mono text-xs text-stone-600">purchasing@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Warehouse</td><td class="px-5 py-3 font-mono text-xs text-stone-600">warehouse@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Produksi</td><td class="px-5 py-3 font-mono text-xs text-stone-600">production@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Kasir</td><td class="px-5 py-3 font-mono text-xs text-stone-600">cashier@goerp.test</td></tr>
                                <tr class="hover:bg-stone-50"><td class="px-5 py-3 font-semibold text-stone-800">Auditor</td><td class="px-5 py-3 font-mono text-xs text-stone-600">auditor@goerp.test</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal-scale opacity-0 text-center" style="opacity:0">
            <a href="{{ url('/app') }}" class="inline-flex items-center gap-2 px-10 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-lg shadow-xl shadow-indigo-500/25 hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-200 card-lift">
                Masuk Dashboard Demo
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>
</section>

{{-- ===== PRICING ===== --}}
<section id="harga" class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal opacity-0 text-center mb-16" style="opacity:0">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-stone-900">Harga yang Transparan</h2>
            <p class="text-stone-500 text-lg mt-3 max-w-2xl mx-auto">Pilih paket yang sesuai dengan skala bisnis Anda</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto stagger">
            @php
            $plans = [
                ['name' => 'Free', 'price' => 'Rp 0', 'period' => '/bulan', 'desc' => 'Untuk mencoba & UMKM kecil', 'features' => ['5 user', '1 cabang', '1 gudang', 'Accounting dasar', 'Inventory dasar', 'Dashboard basic', 'Community support'], 'cta' => 'Coba Gratis', 'highlight' => false],
                ['name' => 'Growth', 'price' => 'Rp 999rb', 'period' => '/bulan', 'desc' => 'Untuk bisnis yang berkembang', 'features' => ['25 user', '5 cabang', '3 gudang', 'Accounting lengkap', 'Inventory & Manufacture', 'Marketplace import', 'AI analytics', 'Approval workflow', 'Priority support'], 'cta' => 'Mulai Growth', 'highlight' => true],
                ['name' => 'Enterprise', 'price' => 'Rp 2.9jt', 'period' => '/bulan', 'desc' => 'Untuk enterprise & multi-entitas', 'features' => ['999 user', 'Unlimited cabang', 'Unlimited gudang', 'Full modul ERP', 'Multi-tenant SaaS', 'API & webhook', 'Custom report', 'Dedicated support', 'SLA 99.9%'], 'cta' => 'Hubungi Sales', 'highlight' => false],
            ];
            @endphp
            @foreach($plans as $p)
            <div class="relative rounded-2xl border-2 {{ $p['highlight'] ? 'border-indigo-600 shadow-2xl shadow-indigo-500/20 scale-[1.02]' : 'border-stone-200' }} bg-white p-6 sm:p-8 card-lift">
                @if($p['highlight'])
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-indigo-600 text-white text-xs font-bold uppercase tracking-wider">Populer</div>
                @endif
                <h3 class="text-xl font-extrabold text-stone-900">{{ $p['name'] }}</h3>
                <p class="text-sm text-stone-500 mt-1">{{ $p['desc'] }}</p>
                <div class="mt-6 mb-6">
                    <span class="text-4xl font-extrabold text-stone-900">{{ $p['price'] }}</span>
                    <span class="text-stone-500 text-sm">{{ $p['period'] }}</span>
                </div>
                <ul class="space-y-3 mb-8">
                    @foreach($p['features'] as $feat)
                    <li class="flex items-start gap-3 text-sm text-stone-600">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ url('/app') }}" class="block text-center py-3 rounded-xl font-bold text-sm {{ $p['highlight'] ? 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-500/25' : 'border-2 border-stone-300 text-stone-700 hover:bg-stone-50' }} transition-all duration-200">{{ $p['cta'] }}</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== SOURCE CODE CTA ===== --}}
<section class="py-16 bg-gradient-to-r from-indigo-600 to-violet-600 relative overflow-hidden">
    <div class="absolute inset-0 animate-shimmer"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <div class="reveal opacity-0" style="opacity:0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white/80 text-xs font-semibold mb-6 backdrop-blur-sm">💻 Source Code</span>
        </div>
        <h2 class="reveal opacity-0 delay-1 text-3xl sm:text-4xl font-extrabold text-white mb-4" style="opacity:0">Ingin Punya Aplikasi ERP Sendiri?</h2>
        <p class="reveal opacity-0 delay-2 text-lg text-indigo-100 max-w-xl mx-auto mb-8" style="opacity:0">Source code GoERP tersedia untuk dibeli. Full source code, bisa di-rebrand, di-host sendiri, dan dimodifikasi sesuai kebutuhan bisnis Anda.</p>
        <div class="reveal opacity-0 delay-3 flex flex-col sm:flex-row items-center justify-center gap-4" style="opacity:0">
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-white text-indigo-700 font-bold shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp
            </a>
            <a href="/docs" class="inline-flex items-center gap-2 px-8 py-3 rounded-xl border-2 border-white/30 text-white font-bold hover:bg-white/10 transition-all duration-200">
                Lihat Dokumentasi Lengkap
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>
</section>

{{-- ===== FINAL CTA ===== --}}
<section class="py-20 lg:py-28 bg-stone-900 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/40 via-transparent to-transparent"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-3xl sm:text-5xl font-extrabold text-white mb-6 reveal opacity-0" style="opacity:0">Siap Transformasi Bisnis Anda?</h2>
        <p class="text-lg text-stone-400 max-w-xl mx-auto mb-10 reveal opacity-0 delay-1" style="opacity:0">Dari UMKM ke enterprise — GoERP skalabel untuk setiap tahap pertumbuhan bisnis Anda. Mulai gratis, upgrade sesuai kebutuhan.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 reveal opacity-0 delay-2" style="opacity:0">
            <a href="{{ url('/app') }}" class="px-10 py-4 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-500 text-white font-bold text-lg shadow-2xl shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200 card-lift">Coba Demo Gratis</a>
            <a href="/docs" class="px-10 py-4 rounded-xl border-2 border-stone-700 text-stone-300 font-bold text-lg hover:bg-stone-800 hover:border-stone-600 transition-all duration-200">Baca Dokumentasi</a>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-stone-950 text-stone-400 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    </div>
                    <span class="font-extrabold text-xl text-white tracking-tight">Go<span class="text-indigo-400">ERP</span></span>
                </div>
                <p class="text-sm text-stone-500 max-w-md leading-relaxed">SaaS ERP lengkap untuk bisnis Indonesia. Accounting, Inventory, Production, CRM & Marketplace dalam satu platform.</p>
            </div>
            <div>
                <h4 class="font-semibold text-stone-300 mb-4">Produk</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#fitur" class="hover:text-white transition-colors">Fitur</a></li>
                    <li><a href="#modul" class="hover:text-white transition-colors">Modul</a></li>
                    <li><a href="#harga" class="hover:text-white transition-colors">Harga</a></li>
                    <li><a href="#demo" class="hover:text-white transition-colors">Demo</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-stone-300 mb-4">Links</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="/docs" class="hover:text-white transition-colors">Dokumentasi</a></li>
                    <li><a href="/blog" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{ url('/app') }}" class="hover:text-white transition-colors">Login</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-stone-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-600">
            <p>&copy; {{ date('Y') }} GoERP. All rights reserved.</p>
            <p>Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot; PHP {{ PHP_VERSION }}</p>
        </div>
    </div>
</footer>

{{-- === SCROLL REVEAL OBSERVER === --}}
<script>
(function () {
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                if (entry.target.classList.contains('stagger')) {
                    observer.unobserve(entry.target);
                }
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .stagger').forEach(function (el) {
        el.style.opacity = '0';
        observer.observe(el);
    });
})();
</script>

</body>
</html>
