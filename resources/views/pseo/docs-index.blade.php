<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi — GoERP</title>
    <meta name="description" content="Dokumentasi lengkap GoERP — sistem ERP multi-tenant dengan akuntansi, inventory, produksi, dan marketplace.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,700" rel="stylesheet" />
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
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased">

{{-- Header --}}
<header class="bg-white border-b border-stone-200 sticky top-0 z-50 backdrop-blur-md bg-white/80">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2 text-indigo-700 font-extrabold text-xl">
                <span class="text-2xl">&#x2699;</span> GoERP
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="/docs" class="text-indigo-600">Dokumentasi</a>
                <a href="/blog" class="text-stone-600 hover:text-stone-900">Blog</a>
                <a href="/admin" class="text-stone-600 hover:text-stone-900">Admin Panel</a>
            </nav>
        </div>
    </div>
</header>

{{-- Jump Nav --}}
<nav class="bg-white border-b border-stone-200 sticky top-16 z-40 overflow-x-auto">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-6 text-sm py-3 whitespace-nowrap">
        <a href="#demo" class="text-indigo-600 font-medium hover:text-indigo-800">Akun Demo</a>
        <a href="#struktur" class="text-stone-600 font-medium hover:text-stone-900">Struktur Menu</a>
        <a href="#tutorial" class="text-stone-600 font-medium hover:text-stone-900">Tutorial</a>
        <a href="#fitur" class="text-stone-600 font-medium hover:text-stone-900">Fitur Lengkap</a>
        <a href="#cta" class="text-stone-600 font-medium hover:text-stone-900">Mulai Sekarang</a>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-20">

{{-- Hero --}}
<section class="text-center max-w-3xl mx-auto">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-stone-900 mb-4">Dokumentasi GoERP</h1>
    <p class="text-lg text-stone-500 leading-relaxed">Panduan lengkap penggunaan GoERP — sistem ERP modern dengan akuntansi double-entry, inventory multi-gudang, manajemen produksi, dan integrasi marketplace.</p>
</section>

{{-- Demo Accounts --}}
<section id="demo">
    <h2 class="text-2xl font-bold text-stone-900 mb-6">&#x1f9ea; Akun Demo</h2>
    <div class="overflow-x-auto rounded-xl border border-stone-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 border-b border-stone-200">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-stone-700 uppercase text-xs tracking-wider">Role</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-700 uppercase text-xs tracking-wider">Email</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-700 uppercase text-xs tracking-wider">Password</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-700 uppercase text-xs tracking-wider">Cakupan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($demoAccounts as $acct)
                <tr class="hover:bg-stone-50/50">
                    <td class="px-5 py-3 font-semibold text-indigo-700">{{ $acct['role'] }}</td>
                    <td class="px-5 py-3 font-mono text-sm text-stone-600">{{ $acct['email'] }}</td>
                    <td class="px-5 py-3 font-mono text-sm text-stone-600">{{ $acct['password'] }}</td>
                    <td class="px-5 py-3 text-stone-600">{{ $acct['scope'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{-- Struktur Menu --}}
<section id="struktur">
    <h2 class="text-2xl font-bold text-stone-900 mb-6">&#x1f4cb; Struktur Menu Admin</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
        $menuGroups = [
            ['icon' => '&#x1f3e2;', 'name' => 'Perusahaan', 'items' => ['Tenant', 'Company', 'Branch', 'User']],
            ['icon' => '&#x1f4e6;', 'name' => 'Master Data', 'items' => ['Kategori', 'Produk', 'Varian', 'Kontak', 'Akun COA', 'Rekening Bank']],
            ['icon' => '&#x1f4b0;', 'name' => 'Penjualan', 'items' => ['Penawaran', 'Sales Order', 'Pengiriman', 'Faktur Penjualan', 'Pembayaran']],
            ['icon' => '&#x1f6d2;', 'name' => 'Pembelian', 'items' => ['Purchase Order', 'Faktur Pembelian', 'Pembayaran']],
            ['icon' => '&#x1f4b5;', 'name' => 'Kas & Bank', 'items' => ['Transaksi Bank', 'Biaya']],
            ['icon' => '&#x1f4ca;', 'name' => 'Akuntansi', 'items' => ['Jurnal', 'Lock Period']],
            ['icon' => '&#x1f3ed;', 'name' => 'Produksi', 'items' => ['BOM', 'Production Order', 'Work Order', 'Piece Rate']],
            ['icon' => '&#x1f4c8;', 'name' => 'Laporan', 'items' => ['Laba Rugi', 'Neraca', 'Arus Kas']],
            ['icon' => '&#x2699;', 'name' => 'Pengaturan', 'items' => ['Settings', 'Audit Log']],
            ['icon' => '&#x1f510;', 'name' => 'Approval & Audit', 'items' => ['Approval', 'Approval Steps']],
        ];
        @endphp
        @foreach($menuGroups as $group)
        <div class="bg-white rounded-xl border border-stone-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="font-bold text-stone-900 mb-2">{!! $group['icon'] !!} {{ $group['name'] }}</h3>
            <ul class="text-sm text-stone-500 space-y-1">
                @foreach($group['items'] as $item)
                <li class="flex items-center gap-2 before:content-[''] before:w-1.5 before:h-1.5 before:rounded-full before:bg-indigo-300">{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</section>

{{-- Tutorial --}}
<section id="tutorial">
    <h2 class="text-2xl font-bold text-stone-900 mb-6">&#x1f4d6; Tutorial Langkah Demi Langkah</h2>
    <div class="space-y-4">
        @foreach($tutorialPhases as $index => $phase)
        <details class="group bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden" {{ $index === 0 ? 'open' : '' }}>
            <summary class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-stone-50 list-none">
                <h3 class="font-semibold text-stone-900">{{ $phase['title'] }}</h3>
                <span class="text-stone-400 group-open:rotate-180 transition-transform">&#x25bc;</span>
            </summary>
            <div class="px-6 pb-5 space-y-2">
                @foreach($phase['steps'] as $i => $step)
                <div class="flex items-start gap-3 text-sm text-stone-600">
                    <span class="flex-shrink-0 w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">{{ $i + 1 }}</span>
                    <span class="pt-1">{{ $step }}</span>
                </div>
                @endforeach
            </div>
        </details>
        @endforeach
    </div>
</section>

{{-- Fitur Lengkap --}}
<section id="fitur">
    <h2 class="text-2xl font-bold text-stone-900 mb-6">&#x2b50; Fitur Lengkap</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($features as $feature)
        <div class="bg-white rounded-xl border border-stone-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="font-bold text-stone-900 mb-3">{{ $feature['group'] }}</h3>
            <ul class="space-y-1.5">
                @foreach($feature['items'] as $item)
                <li class="flex items-center gap-2 text-sm text-stone-600">
                    <span class="text-indigo-500">&#x2713;</span> {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section id="cta" class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-2xl p-10 sm:p-16 text-center text-white shadow-xl">
    <h2 class="text-3xl sm:text-4xl font-extrabold mb-3">Siap Memulai?</h2>
    <p class="text-indigo-100 text-lg mb-8 max-w-lg mx-auto">Akses panel admin GoERP sekarang dan kelola bisnis Anda lebih efisien.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="/admin" class="inline-flex items-center justify-center px-8 py-3 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
            Buka Admin Panel &#x2192;
        </a>
        <a href="/docs" class="inline-flex items-center justify-center px-8 py-3 bg-indigo-500/30 text-white font-semibold rounded-xl hover:bg-indigo-500/50 transition-colors border border-white/20">
            Lihat Dokumentasi
        </a>
    </div>
</section>

</main>

{{-- Footer --}}
<footer class="border-t border-stone-200 bg-white mt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-stone-400">
        &copy; {{ date('Y') }} GoERP. Dibangun dengan Laravel + Filament.
    </div>
</footer>

</body>
</html>
