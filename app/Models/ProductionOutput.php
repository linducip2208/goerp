<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'work_order_id',
        'output_date',
        'output_type',
        'product_variant_id',
        'quantity',
        'unit_cost',
        'warehouse_id',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'output_date' => 'date',
            'quantity' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'posted_at' => 'datetime',
        ];
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
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
