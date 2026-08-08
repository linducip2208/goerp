<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        {{-- Total Tenants --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-violet-100">
                    <x-heroicon-o-building-office class="h-6 w-6 text-violet-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Tenant</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalTenants) }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Active Tenants --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100">
                    <x-heroicon-o-check-circle class="h-6 w-6 text-emerald-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tenant Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($activeTenants) }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Trial Tenants --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-100">
                    <x-heroicon-o-clock class="h-6 w-6 text-amber-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tenant Trial</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($trialTenants) }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Monthly Recurring Revenue --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                    <x-heroicon-o-currency-dollar class="h-6 w-6 text-blue-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">MRR</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($mrr, 0, ',', '.') }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Active Subscriptions --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100">
                    <x-heroicon-o-calendar-days class="h-6 w-6 text-teal-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Langganan Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($activeSubscriptions) }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Trial Subscriptions --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100">
                    <x-heroicon-o-clock class="h-6 w-6 text-indigo-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Langganan Trial</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($trialSubscriptions) }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Outstanding Payments --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pembayaran Tertunggak</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($outstandingPayments, 0, ',', '.') }}</p>
                </div>
            </div>
        </x-filament::section>

        {{-- Total Subscriptions --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-sky-100">
                    <x-heroicon-o-chart-bar class="h-6 w-6 text-sky-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Langganan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSubscriptions) }}</p>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
