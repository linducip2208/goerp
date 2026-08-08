<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'work_order_no',
        'stage',
        'team',
        'operator',
        'start_date',
        'end_date',
        'target_qty',
        'actual_qty',
        'reject_qty',
        'rework_qty',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'target_qty' => 'decimal:2',
            'actual_qty' => 'decimal:2',
            'reject_qty' => 'decimal:2',
            'rework_qty' => 'decimal:2',
        ];
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function pieceRates(): HasMany
    {
        return $this->hasMany(PieceRate::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ProductionOutput::class);
    }
}
