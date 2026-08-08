<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionBom extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'product_variant_id',
        'bom_no',
        'version',
        'expected_output',
        'waste_percent',
        'standard_labor_cost',
        'standard_overhead',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'expected_output' => 'decimal:2',
            'waste_percent' => 'decimal:2',
            'standard_labor_cost' => 'decimal:2',
            'standard_overhead' => 'decimal:2',
            'is_active' => 'boolean',
            'version' => 'integer',
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

    public function items(): HasMany
    {
        return $this->hasMany(ProductionBomItem::class, 'bom_id');
    }
}
