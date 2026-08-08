<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportPdfService
{
    public static function generateInvoicePdf(\App\Models\SalesInvoice $invoice): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdf.sales-invoice', [
            'invoice' => $invoice->load('items.productVariant', 'customer'),
            'company' => \App\Models\Company::first(),
        ])->setPaper('a4');
    }

    public static function generatePurchaseOrderPdf(\App\Models\PurchaseOrder $order): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdf.purchase-order', [
            'order' => $order->load('items.productVariant', 'supplier'),
            'company' => \App\Models\Company::first(),
        ])->setPaper('a4');
    }

    public static function generateProfitLossPdf(array $reportData): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdf.profit-loss', $reportData)->setPaper('a4');
    }

    public static function terbilang(float $angka): string
    {
        $angka = abs($angka);
        $bilangan = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan',
            'Sepuluh', 'Sebelas'
        ];

        if ($angka < 12) {
            return $bilangan[(int) $angka];
        }
        if ($angka < 20) {
            return self::terbilang($angka - 10) . ' Belas';
        }
        if ($angka < 100) {
            return self::terbilang(floor($angka / 10)) . ' Puluh ' . self::terbilang($angka % 10);
        }
        if ($angka < 200) {
            return 'Seratus ' . self::terbilang($angka - 100);
        }
        if ($angka < 1000) {
            return self::terbilang(floor($angka / 100)) . ' Ratus ' . self::terbilang($angka % 100);
        }
        if ($angka < 2000) {
            return 'Seribu ' . self::terbilang($angka - 1000);
        }
        if ($angka < 1000000) {
            return self::terbilang(floor($angka / 1000)) . ' Ribu ' . self::terbilang($angka % 1000);
        }
        if ($angka < 1000000000) {
            return self::terbilang(floor($angka / 1000000)) . ' Juta ' . self::terbilang($angka % 1000000);
        }
        if ($angka < 1000000000000) {
            return self::terbilang(floor($angka / 1000000000)) . ' Miliar ' . self::terbilang($angka % 1000000000);
        }

        return self::terbilang(floor($angka / 1000000000000)) . ' Triliun ' . self::terbilang($angka % 1000000000000);
    }
}
