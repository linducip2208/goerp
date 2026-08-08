<?php

namespace App\Console\Commands;

use App\Models\InventoryBalance;
use App\Models\ProductVariant;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class LowStockAlert extends Command
{
    protected $signature = 'app:low-stock-alert';
    protected $description = 'Alert on product variants with stock below minimum';

    public function handle(): int
    {
        $variants = ProductVariant::where('is_active', true)
            ->whereNotNull('min_stock')
            ->where('min_stock', '>', 0)
            ->get();

        $alertCount = 0;
        foreach ($variants as $variant) {
            $balances = InventoryBalance::where('product_variant_id', $variant->id)->get();

            foreach ($balances as $balance) {
                if ((float) $balance->on_hand <= (float) $variant->min_stock) {
                    $warehouseName = $balance->warehouse->name ?? 'Gudang';

                    NotificationService::sendLowStockAlert($variant, $warehouseName, (float) $balance->on_hand);

                    $adminUsers = \App\Models\User::whereNotNull('email')->take(5)->get();
                    foreach ($adminUsers as $user) {
                        NotificationService::createInternalNotification(
                            $user->id,
                            'low_stock',
                            'Stok Rendah: ' . $variant->name,
                            "Stok {$variant->name} ({$variant->internal_sku}) di {$warehouseName} tersisa {$balance->on_hand} (min: {$variant->min_stock})",
                            ['variant_id' => $variant->id, 'warehouse_id' => $balance->warehouse_id]
                        );
                    }

                    $this->line("Low stock: {$variant->name} @ {$warehouseName} ({$balance->on_hand})");
                    $alertCount++;
                }
            }
        }

        $this->info("Found {$alertCount} low stock alerts.");
        return self::SUCCESS;
    }
}
