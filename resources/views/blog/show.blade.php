<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->meta_title ?? $post->title }} — GoERP Blog</title>
    <meta name="description" content="{{ $post->meta_description ?? $post->excerpt }}">
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

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article>
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-stone-400 mb-3">
                <a href="/blog" class="text-indigo-600 font-medium hover:underline">Blog</a>
                <span>/</span>
                @if($post->category)
                <a href="/blog/category/{{ $post->category->slug }}" class="text-indigo-600 font-medium hover:underline">{{ $post->category->name }}</a>
                <span>/</span>
                @endif
                <span>{{ $post->title }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-stone-900 mb-4">{{ $post->title }}</h1>
            <div class="flex items-center gap-3 text-sm text-stone-400">
                @if($post->author)
                <span>{{ $post->author->name }}</span>
                <span>&middot;</span>
                @endif
                <time>{{ $post->published_at?->format('d M Y') }}</time>
            </div>
        </div>

        @if($post->featured_image)
        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full rounded-xl mb-10 shadow-lg">
        @endif

        <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed">
            {!! $post->content !!}
        </div>
    </article>

    <div class="mt-12 pt-8 border-t border-stone-200">
        <a href="/blog" class="text-indigo-600 font-medium hover:underline">&larr; Kembali ke Blog</a>
    </div>
</main>

<footer class="border-t border-stone-200 bg-white mt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-stone-400">
        &copy; {{ date('Y') }} GoERP. Dibangun dengan Laravel + Filament.
    </div>
</footer>

</body>
</html>
