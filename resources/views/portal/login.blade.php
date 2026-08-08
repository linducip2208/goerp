<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — GoERP Portal</title>
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
</head>
<body class="h-full bg-stone-50 antialiased font-sans">
<div class="min-h-screen flex">
    {{-- Left: Brand Panel --}}
    <div class="hidden lg:flex relative bg-gradient-to-br from-indigo-700 via-indigo-800 to-stone-900 w-[440px] p-12 flex-col justify-between overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,.15) 0%, transparent 50%), radial-gradient(circle at 80% 70%, rgba(255,255,255,.1) 0%, transparent 50%)"></div>
        <div class="absolute -bottom-20 -right-20 text-[20rem] opacity-[0.06] select-none">📊</div>
        <div class="relative">
            <a href="/" class="flex items-center gap-3 text-white">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-xl flex items-center justify-center font-bold text-white">E</div>
                <span class="font-bold text-2xl tracking-tight">GoERP</span>
            </a>
        </div>
        <div class="relative text-white">
            <h2 class="text-4xl font-bold leading-tight mb-4">Portal Customer GoERP</h2>
            <p class="text-indigo-200 text-lg leading-relaxed mb-10 max-w-sm">Lihat faktur, lacak pembayaran, dan pantau status pesanan Anda secara real-time.</p>
            <div class="grid grid-cols-2 gap-4 max-w-sm">
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div class="text-2xl mb-1">📄</div>
                    <div class="text-sm text-white/80">Faktur Online</div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div class="text-2xl mb-1">💳</div>
                    <div class="text-sm text-white/80">Riwayat Bayar</div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div class="text-2xl mb-1">📊</div>
                    <div class="text-sm text-white/80">Ringkasan</div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div class="text-2xl mb-1">🔔</div>
                    <div class="text-sm text-white/80">Status Real-time</div>
                </div>
            </div>
        </div>
        <div class="relative text-indigo-300/60 text-xs">&copy; {{ date('Y') }} GoERP · Powered by Laravel</div>
    </div>

    {{-- Right: Login Form --}}
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="lg:hidden mb-8 text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center font-bold text-white">E</div>
                    <span class="font-bold text-2xl tracking-tight text-stone-900">GoERP</span>
                </div>
                <p class="text-stone-500 text-sm">Portal Customer</p>
            </div>

            <h1 class="text-3xl font-bold text-stone-900 mb-2">Masuk</h1>
            <p class="text-stone-500 mb-8">Masuk ke portal customer Anda</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('portal.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="customer@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="Masukkan password">
                </div>
                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-0.5 transition-all text-sm">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
