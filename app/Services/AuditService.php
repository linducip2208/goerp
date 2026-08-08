<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditService
{
    public static function log(string $action, string $module, string $documentType, $documentId, ?string $documentNo = null, ?array $oldValues = null, ?array $newValues = null): void
    {
        AuditLog::create([
            'tenant_id' => auth()->user()?->tenant_id,
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'document_type' => $documentType,
            'document_id' => $documentId,
            'document_no' => $documentNo,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
