<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketplaceImport extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'marketplace',
        'warehouse_id',
        'filename',
        'total_orders',
        'total_items',
        'matched_count',
        'unmatched_count',
        'duplicate_count',
        'imported_count',
        'status',
        'imported_by',
        'imported_at',
    ];

    protected function casts(): array
    {
        return [
            'total_orders' => 'integer',
            'total_items' => 'integer',
            'matched_count' => 'integer',
            'unmatched_count' => 'integer',
            'duplicate_count' => 'integer',
            'imported_count' => 'integer',
            'imported_at' => 'datetime',
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

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function importedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'imported_by');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(MarketplaceOrder::class, 'import_id');
    }
}
