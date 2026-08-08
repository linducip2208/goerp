<?php

namespace App\Concerns;

use App\Models\Subscription;
use Illuminate\Support\Facades\Cache;

trait FeatureGate
{
    public static function hasFeature(string $feature): bool
    {
        if (!auth()->check() || !auth()->user()?->tenant_id) return false;

        $tenantId = auth()->user()->tenant_id;

        return Cache::remember("tenant:{$tenantId}:feature:{$feature}", 3600, function () use ($tenantId, $feature) {
            $subscription = Subscription::where('tenant_id', $tenantId)
                ->where('status', 'active')
                ->with('plan')
                ->first();

            if (!$subscription) return false;

            $features = $subscription->plan->features ?? [];
            return in_array($feature, (array)$features);
        });
    }

    public static function canView(): bool
    {
        return true;
    }
}
