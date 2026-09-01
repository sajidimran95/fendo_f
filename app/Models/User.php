<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'country_code',
        'gender',
        'avatar',
        'fcm_token',
        'notifications_enabled',
        'is_admin',
        'profile_completed',
        'status',
        'password',
        'phone_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'profile_completed' => 'boolean',
            'notifications_enabled' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return in_array($this->status, ['suspended', 'banned'], true);
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function displayName(): string
    {
        return $this->name ?: trim(($this->first_name ?? '').' '.($this->last_name ?? '')) ?: ($this->phone ?? 'User');
    }

    public function initials(): string
    {
        $name = $this->displayName();
        $parts = preg_split('/\s+/', $name) ?: [];
        $letters = collect($parts)->filter()->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->take(2)->implode('');

        return $letters !== '' ? $letters : 'U';
    }

    public function avatarUrl(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', (string) $this->avatar), '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return rtrim((string) config('app.url'), '/').'/media/'.$path;
    }

    public function isDemo(): bool
    {
        return $this->phone === '+8801712345678';
    }

    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->displayName(),
            'initials' => $this->initials(),
            'email' => $this->email,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'gender' => $this->gender,
            'avatar' => $this->avatarUrl(),
            'notifications_enabled' => $this->notifications_enabled,
            'profile_completed' => $this->profile_completed,
            'is_demo' => $this->isDemo(),
            'contacts_count' => $this->contacts()->count(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class);
    }
}
