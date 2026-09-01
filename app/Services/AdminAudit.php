<?php

namespace App\Services;

use App\Models\AdminAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdminAudit
{
    public static function log(
        string $action,
        ?Model $subject = null,
        ?string $description = null,
        array $metadata = []
    ): void {
        $admin = Auth::user();
        if (! $admin) {
            return;
        }

        AdminAuditLog::create([
            'admin_id' => $admin->id,
            'action' => $action,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'metadata' => $metadata ?: null,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
            'created_at' => now(),
        ]);
    }
}
