<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowRule extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'module',
        'trigger_event',
        'condition_field',
        'condition_operator',
        'condition_value',
        'action_type',
        'action_params',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'action_params' => 'json',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
