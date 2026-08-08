<?php

namespace App\Filament\Widgets;

use App\Models\SalesInvoice;
use App\Models\Contact;
use App\Models\ProductVariant;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app';
    }

    protected function getStats(): array
    {
        $totalPenjualan = SalesInvoice::where('status', '!=', 'draft')->sum('grand_total');
        $totalPiutang = SalesInvoice::whereIn('status', ['open', 'partial', 'overdue'])->sum('outstanding');
        $totalCustomer = Contact::where('type', 'customer')->count();
        $totalProduk = ProductVariant::count();
        $totalInvoiceBulan = SalesInvoice::whereMonth('invoice_date', now()->month)->count();
        $totalPembelianBulan = \App\Models\PurchaseInvoice::whereMonth('invoice_date', now()->month)->sum('grand_total');

        return [
            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($totalPenjualan, 0, ',', '.'))
                ->description('Total nilai faktur')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Piutang', 'Rp ' . number_format($totalPiutang, 0, ',', '.'))
                ->description('Outstanding')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            Stat::make('Customer', number_format($totalCustomer))
                ->description('Total kontak customer')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Produk', number_format($totalProduk))
                ->description('Total varian produk')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            Stat::make('Invoice Bulan Ini', number_format($totalInvoiceBulan))
                ->description('Jumlah faktur')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),
            Stat::make('Pembelian Bulan Ini', 'Rp ' . number_format($totalPembelianBulan, 0, ',', '.'))
                ->description('Total nilai pembelian')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
