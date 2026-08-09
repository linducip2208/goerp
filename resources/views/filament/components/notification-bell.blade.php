<div class="flex items-center gap-2 px-2">
    <a href="{{ url('/app') }}" class="flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 relative">
        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @php try { $count = \App\Models\Notification::whereNull('read_at')->count(); } catch (\Exception $e) { $count = 0; } @endphp
        @if($count > 0)
        <span class="absolute -top-0.5 -right-0.5 flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-danger-500 text-white text-[10px] font-bold leading-none">{{ $count }}</span>
        @endif
    </a>
</div>
