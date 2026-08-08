<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function index()
    {
        $demoAccounts = [
            ['role' => 'Super Admin', 'panel' => 'Platform Admin (/admin)', 'email' => 'admin@goerp.test', 'password' => 'password', 'scope' => 'Kelola tenant, subscription, billing, support, system'],
            ['role' => 'Platform Admin', 'panel' => 'Platform Admin (/admin)', 'email' => 'platform@goerp.test', 'password' => 'password', 'scope' => 'Kelola tenant & subscription'],
            ['role' => 'Pemilik Bisnis', 'panel' => 'Customer ERP (/app)', 'email' => 'owner@goerp.test', 'password' => 'password', 'scope' => 'Akses penuh semua modul ERP'],
            ['role' => 'Finance Manager', 'panel' => 'Customer ERP (/app)', 'email' => 'finance@goerp.test', 'password' => 'password', 'scope' => 'Finance, Kas & Bank, Laporan'],
            ['role' => 'Akuntan', 'panel' => 'Customer ERP (/app)', 'email' => 'accounting@goerp.test', 'password' => 'password', 'scope' => 'COA, Jurnal, General Ledger, Tutup Buku'],
            ['role' => 'Sales Admin', 'panel' => 'Customer ERP (/app)', 'email' => 'sales@goerp.test', 'password' => 'password', 'scope' => 'Penawaran, SO, Faktur, Marketplace'],
            ['role' => 'Purchasing Staff', 'panel' => 'Customer ERP (/app)', 'email' => 'purchasing@goerp.test', 'password' => 'password', 'scope' => 'Purchase Request, PO, Penerimaan'],
            ['role' => 'Warehouse Staff', 'panel' => 'Customer ERP (/app)', 'email' => 'warehouse@goerp.test', 'password' => 'password', 'scope' => 'Stok, Mutasi, Transfer, Stock Opname'],
            ['role' => 'Production Manager', 'panel' => 'Customer ERP (/app)', 'email' => 'production@goerp.test', 'password' => 'password', 'scope' => 'BOM, Production Order, QC, HPP'],
            ['role' => 'Kasir', 'panel' => 'Customer ERP (/app)', 'email' => 'cashier@goerp.test', 'password' => 'password', 'scope' => 'Penerimaan & pembayaran customer'],
            ['role' => 'Auditor', 'panel' => 'Customer ERP (/app)', 'email' => 'auditor@goerp.test', 'password' => 'password', 'scope' => 'View-only + audit trail'],
        ];

        $tutorialPhases = [
            ['title' => 'Fase 1: Setup Awal', 'steps' => [
                'Buat Tenant dan Company',
                'Setup Cabang dan Gudang',
                'Tambah User dan Role',
                'Konfigurasi Settings Perusahaan',
            ]],
            ['title' => 'Fase 2: Master Data', 'steps' => [
                'Input Chart of Accounts (COA)',
                'Input Kontak (Customer, Supplier)',
                'Input Produk dan Varian',
                'Input Rekening Bank & Kas',
            ]],
            ['title' => 'Fase 3: Transaksi Harian', 'steps' => [
                'Buat Faktur Penjualan + Item',
                'Catat Pembayaran Customer',
                'Buat Purchase Order ke Supplier',
                'Catat Faktur Pembelian',
                'Catat Biaya Operasional',
            ]],
            ['title' => 'Fase 4: Inventory', 'steps' => [
                'Monitor Stok per Gudang',
                'Transfer Antar Gudang',
                'Stock Opname',
                'Penyesuaian Stok',
            ]],
            ['title' => 'Fase 5: Produksi', 'steps' => [
                'Buat Bill of Materials',
                'Buat Production Order',
                'Catat Work Order per Tahap',
                'Catat Output (Good/Reject/Rework)',
                'Hitung HPP Aktual',
            ]],
            ['title' => 'Fase 6: Marketplace', 'steps' => [
                'Mapping SKU Marketplace ke Internal SKU',
                'Import Excel dari Shopee/TikTok/Lazada',
                'Preview & Validasi Sebelum Import',
                'Auto Update Stok',
            ]],
            ['title' => 'Fase 7: Accounting', 'steps' => [
                'Review Jurnal Otomatis',
                'General Ledger',
                'Tutup Buku Bulanan',
                'Lock Period',
            ]],
            ['title' => 'Fase 8: Laporan', 'steps' => [
                'Laba Rugi',
                'Neraca',
                'Arus Kas',
                'Laporan Penjualan & Inventory',
            ]],
        ];

        $features = [
            ['group' => 'Penjualan', 'items' => ['Penawaran', 'Sales Order', 'Pengiriman', 'Faktur Penjualan', 'Pembayaran', 'Retur']],
            ['group' => 'Pembelian', 'items' => ['Purchase Order', 'Penerimaan', 'Faktur Pembelian', 'Pembayaran', 'Retur']],
            ['group' => 'Inventory', 'items' => ['Multi Gudang', 'Transfer', 'Stock Opname', 'Penyesuaian', 'Mutasi Stok']],
            ['group' => 'Akuntansi', 'items' => ['COA', 'Jurnal Otomatis', 'General Ledger', 'Tutup Buku', 'Lock Period']],
            ['group' => 'Produksi', 'items' => ['BOM', 'Production Order', 'Work Order', 'QC', 'HPP Aktual', 'Borongan']],
            ['group' => 'Marketplace', 'items' => ['Import Excel', 'SKU Matching', 'Auto Stock Deduction']],
        ];

        return view('pseo.docs-index', compact('demoAccounts', 'tutorialPhases', 'features'));
    }
}
