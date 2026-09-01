<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdminAuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function actionLabel(): string
    {
        return match ($this->action) {
            'admin.login' => 'Admin login',
            'admin.logout' => 'Admin logout',
            'user.suspend' => 'User suspended',
            'user.ban' => 'User banned',
            'user.restore' => 'User restored',
            'admin.password_changed' => 'Password changed',
            'admin.avatar_updated' => 'Avatar updated',
            'admin.avatar_removed' => 'Avatar removed',
            default => str_replace(['.', '_'], ' ', ucfirst($this->action)),
        };
    }

    public function actionColor(): string
    {
        return match ($this->action) {
            'user.ban' => 'bg-red-500/15 text-red-400',
            'user.suspend' => 'bg-orange-500/15 text-orange-400',
            'user.restore' => 'bg-emerald-500/15 text-emerald-400',
            'admin.login' => 'bg-indigo-500/15 text-indigo-400',
            default => 'bg-gray-500/15 text-gray-400',
        };
    }
}
