<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_id',
        'step_order',
        'approver_id',
        'role_id',
        'min_amount',
        'status',
        'decided_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'step_order' => 'integer',
            'min_amount' => 'decimal:2',
            'status' => 'string',
            'decided_at' => 'datetime',
        ];
    }

    public function approval(): BelongsTo
    {
        return $this->belongsTo(Approval::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
