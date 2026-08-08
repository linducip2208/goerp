<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'order_no',
        'product_variant_id',
        'bom_id',
        'target_qty',
        'start_date',
        'due_date',
        'raw_warehouse_id',
        'finished_warehouse_id',
        'status',
        'actual_output_qty',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
            'target_qty' => 'decimal:2',
            'actual_output_qty' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function bom(): BelongsTo
    {
        return $this->belongsTo(ProductionBom::class);
    }

    public function rawWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'raw_warehouse_id');
    }

    public function finishedWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'finished_warehouse_id');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function materialRequests(): HasMany
    {
        return $this->hasMany(MaterialRequest::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ProductionOutput::class);
    }
}
