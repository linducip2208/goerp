{{-- resources/views/emails/low-stock-alert.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc2626; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #fff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; }
        .detail-table td { padding: 4px 12px 4px 0; }
        .label { color: #64748b; }
        .warning { background: #fef2f2; border: 1px solid #fecaca; padding: 12px; border-radius: 6px; margin: 16px 0; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Peringatan Stok Rendah</h2>
        </div>
        <div class="content">
            <div class="warning">
                Stok produk berikut berada di bawah batas minimum dan perlu segera diisi ulang.
            </div>

            <table class="detail-table">
                <tr><td class="label">Produk</td><td>: {{ $variant->name }}</td></tr>
                <tr><td class="label">SKU</td><td>: {{ $variant->internal_sku ?? '-' }}</td></tr>
                <tr><td class="label">Gudang</td><td>: {{ $warehouseName }}</td></tr>
                <tr><td class="label">Stok Saat Ini</td><td>: {{ $onHand }}</td></tr>
                <tr><td class="label">Stok Minimum</td><td>: {{ $variant->min_stock }}</td></tr>
            </table>

            <p>Mohon segera buat Purchase Order untuk mengisi stok produk ini.</p>
            <p>Hormat kami,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
