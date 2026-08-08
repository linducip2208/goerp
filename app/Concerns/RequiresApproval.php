<?php

namespace App\Concerns;

use App\Models\Approval;

trait RequiresApproval
{
    public function approval(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    public function submitForApproval(): void
    {
        $this->approval()->create([
            'tenant_id' => $this->tenant_id,
            'company_id' => $this->company_id,
            'status' => 'submitted',
            'submitted_by' => auth()->id(),
            'submitted_at' => now(),
        ]);
    }

    public function approve(?string $notes = null): void
    {
        $this->approval()->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
    }

    public function reject(?string $reason = null): void
    {
        $this->approval()->update([
            'status' => 'rejected',
            'rejected_reason' => $reason,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
    }

    public function isApproved(): bool
    {
        return $this->approval?->status === 'approved';
    }

    public function needsApproval(): bool
    {
        return $this->approval && in_array($this->approval->status, ['submitted', 'waiting']);
    }
}
