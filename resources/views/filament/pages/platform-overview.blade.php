<x-filament-panels::page>
    @php $stats = $this->getStats(); @endphp

    {{-- Row 1: Key metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <div class="text-sm font-medium text-stone-500 dark:text-stone-400">Total Tenant</div>
            <div class="text-3xl font-bold text-stone-900 dark:text-stone-100 mt-1">{{ number_format($stats['totalTenants']) }}</div>
            <div class="text-xs text-stone-400 mt-1">{{ $stats['activeTenants'] }} aktif, {{ $stats['trialTenants'] }} trial</div>
        </div>
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <div class="text-sm font-medium text-stone-500 dark:text-stone-400">Langganan Aktif</div>
            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($stats['activeSubscriptions']) }}</div>
            <div class="text-xs text-stone-400 mt-1">dari {{ number_format($stats['totalSubscriptions']) }} total</div>
        </div>
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <div class="text-sm font-medium text-stone-500 dark:text-stone-400">MRR Bulan Ini</div>
            <div class="text-3xl font-bold text-sky-600 dark:text-sky-400 mt-1">Rp {{ number_format($stats['mrr'], 0, ',', '.') }}</div>
            <div class="text-xs text-stone-400 mt-1">Monthly Recurring Revenue</div>
        </div>
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <div class="text-sm font-medium text-stone-500 dark:text-stone-400">Outstanding</div>
            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">Rp {{ number_format($stats['outstandingBilling'], 0, ',', '.') }}</div>
            <div class="text-xs text-stone-400 mt-1">Tagihan belum dibayar</div>
        </div>
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <div class="text-sm font-medium text-stone-500 dark:text-stone-400">Support Ticket</div>
            <div class="text-3xl font-bold {{ $stats['openTickets'] > 10 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }} mt-1">{{ number_format($stats['openTickets']) }}</div>
            <div class="text-xs text-stone-400 mt-1">Open tickets</div>
        </div>
    </div>

    {{-- Row 2: Tenant breakdown + Top tenants --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Tenant status breakdown --}}
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <h3 class="text-lg font-semibold text-stone-900 dark:text-stone-100 mb-4">Status Tenant</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-stone-600 dark:text-stone-300">Aktif</span>
                    </div>
                    <span class="text-sm font-semibold text-stone-900 dark:text-stone-100">{{ number_format($stats['activeTenants']) }}</span>
                </div>
                <div class="w-full bg-stone-100 dark:bg-stone-800 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $stats['totalTenants'] > 0 ? ($stats['activeTenants'] / $stats['totalTenants']) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                        <span class="text-sm text-stone-600 dark:text-stone-300">Trial</span>
                    </div>
                    <span class="text-sm font-semibold text-stone-900 dark:text-stone-100">{{ number_format($stats['trialTenants']) }}</span>
                </div>
                <div class="w-full bg-stone-100 dark:bg-stone-800 rounded-full h-1.5">
                    <div class="bg-sky-500 h-1.5 rounded-full" style="width: {{ $stats['totalTenants'] > 0 ? ($stats['trialTenants'] / $stats['totalTenants']) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-sm text-stone-600 dark:text-stone-300">Expired</span>
                    </div>
                    <span class="text-sm font-semibold text-stone-900 dark:text-stone-100">{{ number_format($stats['expiredTenants']) }}</span>
                </div>
                <div class="w-full bg-stone-100 dark:bg-stone-800 rounded-full h-1.5">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $stats['totalTenants'] > 0 ? ($stats['expiredTenants'] / $stats['totalTenants']) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="text-sm text-stone-600 dark:text-stone-300">Suspended</span>
                    </div>
                    <span class="text-sm font-semibold text-stone-900 dark:text-stone-100">{{ number_format($stats['suspendedTenants']) }}</span>
                </div>
            </div>
        </div>

        {{-- Top 5 tenants --}}
        <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
            <h3 class="text-lg font-semibold text-stone-900 dark:text-stone-100 mb-4">Top 5 Tenant (by Users)</h3>
            <div class="space-y-3">
                @forelse($stats['topTenants'] as $tenant)
                <div class="flex items-center justify-between py-2 border-b border-stone-100 dark:border-stone-800 last:border-0">
                    <div>
                        <div class="text-sm font-medium text-stone-900 dark:text-stone-100">{{ $tenant->name }}</div>
                        <div class="text-xs text-stone-400">{{ $tenant->domain }}</div>
                    </div>
                    <span class="text-sm font-semibold text-stone-600 dark:text-stone-300">{{ $tenant->users_count }} user</span>
                </div>
                @empty
                <p class="text-sm text-stone-400">Belum ada tenant.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Row 3: Recent support tickets --}}
    <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-700 p-6">
        <h3 class="text-lg font-semibold text-stone-900 dark:text-stone-100 mb-4">Support Ticket Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 dark:text-stone-400 border-b border-stone-200 dark:border-stone-700">
                        <th class="pb-2 font-medium">Subjek</th>
                        <th class="pb-2 font-medium">Tenant</th>
                        <th class="pb-2 font-medium">Prioritas</th>
                        <th class="pb-2 font-medium">Status</th>
                        <th class="pb-2 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recentTickets'] as $ticket)
                    <tr class="border-b border-stone-50 dark:border-stone-800 last:border-0">
                        <td class="py-2.5 text-stone-900 dark:text-stone-100">{{ $ticket->subject }}</td>
                        <td class="py-2.5 text-stone-600 dark:text-stone-300">{{ $ticket->tenant?->name }}</td>
                        <td class="py-2.5">
                            <span class="px-2 py-0.5 rounded text-xs font-medium
                                @if($ticket->priority === 'critical') bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400
                                @elseif($ticket->priority === 'high') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                @elseif($ticket->priority === 'medium') bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400
                                @else bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-400
                                @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td class="py-2.5">
                            <span class="px-2 py-0.5 rounded text-xs font-medium
                                @if($ticket->status === 'open') bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400
                                @elseif($ticket->status === 'in_progress') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                @elseif($ticket->status === 'closed') bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-400
                                @else bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-400
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                            </span>
                        </td>
                        <td class="py-2.5 text-stone-500 dark:text-stone-400">{{ $ticket->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-stone-400">Belum ada support ticket.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
