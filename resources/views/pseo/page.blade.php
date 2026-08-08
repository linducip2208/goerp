<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — GoERP</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta name="twitter:card" content="summary">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "{{ $title }}",
        "description": "{{ $description }}",
        "numberOfItems": 10
    }
    </script>
</head>
<body class="bg-white font-sans antialiased text-zinc-900">

<div class="min-h-screen bg-gradient-to-b from-zinc-50 to-white">
    {{-- Header --}}
    <header class="border-b border-zinc-200 bg-white/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="text-xl font-extrabold"><span class="text-indigo-600">Go</span>ERP</a>
            <a href="/admin" class="text-sm px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">Admin Panel</a>
        </div>
    </header>

    {{-- Content --}}
    <main class="max-w-4xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-extrabold tracking-tight mb-4">{{ $title }}</h1>
        <p class="text-lg text-zinc-600 mb-12">{{ $description }}</p>

        {{-- List --}}
        <div class="space-y-6 mb-16">
            @for ($i = 1; $i <= 10; $i++)
            <div class="flex gap-4 items-start p-6 rounded-xl border border-zinc-200 hover:border-indigo-300 hover:shadow-sm transition">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">{{ $i }}</div>
                <div>
                    <h3 class="font-semibold text-lg mb-1">Rekomendasi #{{ $i }} untuk {{ $title }}</h3>
                    <p class="text-zinc-600 text-sm">Solusi terbaik untuk kebutuhan bisnis Anda. Tersedia integrasi penuh dengan accounting, inventory, dan production management.</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Akuntansi</span>
                        <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">Inventory</span>
                        <span class="text-xs px-2 py-1 rounded bg-purple-100 text-purple-700">Produksi</span>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        {{-- CTA Banner --}}
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-3">Butuh Solusi ERP Lengkap?</h2>
            <p class="text-indigo-100 mb-6">GoERP — SaaS ERP dengan Accounting, Inventory, Production & Marketplace. Source code tersedia.</p>
            <a href="https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20source%20code%20GoERP" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-zinc-100 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp — Beli Source Code
            </a>
        </div>
    </main>

    <footer class="border-t border-zinc-200 py-8 text-center text-sm text-zinc-500">
        &copy; {{ date('Y') }} GoERP · SaaS ERP Indonesia · <a href="/docs" class="text-indigo-600 hover:underline">Dokumentasi</a> · <a href="/sitemap.xml" class="text-indigo-600 hover:underline">Sitemap</a>
    </footer>
</div>

</body>
</html>
