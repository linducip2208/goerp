<?php

namespace App\Filament\App\Pages;

use App\Models\SalesInvoice;
use Carbon\Carbon;
use Filament\Pages\Page;

class ArAgingReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 76;
    protected static ?string $title = 'AR Aging';

    protected static string $view = 'filament.pages.reports.ar-aging';

    public array $agingData = [];
    public float $totalOutstanding = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $now = Carbon::now();
        $invoices = SalesInvoice::with('customer')
            ->whereIn('status', ['open', 'partial', 'overdue'])
            ->where('outstanding', '>', 0)
            ->get();

        $this->totalOutstanding = $invoices->sum('outstanding');
        $this->agingData = [
            'current' => ['label' => 'Belum Jatuh Tempo', 'total' => 0, 'count' => 0, 'color' => '#10b981'],
            '1_30' => ['label' => '1-30 Hari', 'total' => 0, 'count' => 0, 'color' => '#f59e0b'],
            '31_60' => ['label' => '31-60 Hari', 'total' => 0, 'count' => 0, 'color' => '#f97316'],
            '61_90' => ['label' => '61-90 Hari', 'total' => 0, 'count' => 0, 'color' => '#ef4444'],
            '90_plus' => ['label' => '90+ Hari', 'total' => 0, 'count' => 0, 'color' => '#7c3aed'],
        ];

        foreach ($invoices as $inv) {
            $due = Carbon::parse($inv->due_date);
            $days = (int) $now->diffInDays($due, false);

            if ($days >= 0) {
                $this->agingData['current']['total'] += $inv->outstanding;
                $this->agingData['current']['count']++;
            } elseif ($days >= -30) {
                $this->agingData['1_30']['total'] += $inv->outstanding;
                $this->agingData['1_30']['count']++;
            } elseif ($days >= -60) {
                $this->agingData['31_60']['total'] += $inv->outstanding;
                $this->agingData['31_60']['count']++;
            } elseif ($days >= -90) {
                $this->agingData['61_90']['total'] += $inv->outstanding;
                $this->agingData['61_90']['count']++;
            } else {
                $this->agingData['90_plus']['total'] += $inv->outstanding;
                $this->agingData['90_plus']['count']++;
            }
        }
    }
}
