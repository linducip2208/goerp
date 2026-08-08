<?php

namespace App\Filament\Widgets;

use App\Models\SalesInvoice;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app';
    }

    protected function getData(): array
    {
        $data = SalesInvoice::selectRaw('MONTH(invoice_date) as month, SUM(grand_total) as total')
            ->whereYear('invoice_date', now()->year)
            ->where('status', '!=', 'draft')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $values = [];
        for ($i = 1; $i <= 12; $i++) {
            $values[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan ' . now()->year,
                    'data' => $values,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'borderColor' => 'rgb(99, 102, 241)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
