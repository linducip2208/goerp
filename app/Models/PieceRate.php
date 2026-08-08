<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceRate extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'work_order_id',
        'operator_name',
        'operation',
        'quantity',
        'rate_per_unit',
        'total_amount',
        'payment_date',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'rate_per_unit' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'payment_date' => 'date',
            'posted_at' => 'datetime',
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

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
