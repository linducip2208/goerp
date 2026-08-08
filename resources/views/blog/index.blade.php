<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — GoERP</title>
    <meta name="description" content="Blog GoERP — tips bisnis, akuntansi, inventory, dan marketplace.">
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

<header class="bg-white border-b border-stone-200 sticky top-0 z-50 backdrop-blur-md bg-white/80">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2 text-indigo-700 font-extrabold text-xl">
                <span class="text-2xl">&#x2699;</span> GoERP
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="/docs" class="text-stone-600 hover:text-stone-900">Dokumentasi</a>
                <a href="/blog" class="text-indigo-600">Blog</a>
                <a href="/admin" class="text-stone-600 hover:text-stone-900">Admin Panel</a>
            </nav>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-stone-900 mb-4">Blog GoERP</h1>
        <p class="text-lg text-stone-500">Tips, tutorial, dan insight seputar ERP, akuntansi, inventory, dan marketplace.</p>
    </div>

    @if($posts->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <article class="bg-white rounded-xl border border-stone-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                @if($post->featured_image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center gap-2 text-xs text-stone-400 mb-2">
                        @if($post->category)
                        <a href="/blog/category/{{ $post->category->slug }}" class="text-indigo-600 font-medium hover:underline">{{ $post->category->name }}</a>
                        <span>&middot;</span>
                        @endif
                        <time>{{ $post->published_at?->format('d M Y') }}</time>
                    </div>
                    <h2 class="font-bold text-lg text-stone-900 mb-2 group-hover:text-indigo-600 transition-colors">
                        <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                    </h2>
                    @if($post->excerpt)
                    <p class="text-sm text-stone-500 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-20 text-stone-400">
            <p class="text-lg">Belum ada artikel. Segera hadir!</p>
        </div>
    @endif
</main>

<footer class="border-t border-stone-200 bg-white mt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-stone-400">
        &copy; {{ date('Y') }} GoERP. Dibangun dengan Laravel + Filament.
    </div>
</footer>

</body>
</html>
