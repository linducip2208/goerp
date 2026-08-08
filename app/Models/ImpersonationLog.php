<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpersonationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform_admin_id',
        'target_user_id',
        'tenant_id',
        'start_time',
        'end_time',
        'reason',
        'activity_log',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'activity_log' => 'array',
        ];
    }

    public function platformAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'platform_admin_id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
