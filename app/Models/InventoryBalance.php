<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'product_variant_id',
        'warehouse_id',
        'on_hand',
        'reserved',
        'available',
        'average_cost',
        'last_purchase_cost',
    ];

    protected function casts(): array
    {
        return [
            'on_hand' => 'decimal:2',
            'reserved' => 'decimal:2',
            'available' => 'decimal:2',
            'average_cost' => 'decimal:2',
            'last_purchase_cost' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
