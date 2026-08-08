<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'key',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function get(string $key, $default = null)
    {
        $tenantId = auth()->user()?->tenant_id;
        $setting = static::where('tenant_id', $tenantId)->where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value): void
    {
        $tenantId = auth()->user()?->tenant_id;
        static::updateOrCreate(
            ['tenant_id' => $tenantId, 'key' => $key],
            ['value' => $value]
        );
    }
}
