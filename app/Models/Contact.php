<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'linked_user_id',
        'name',
        'phone',
        'note',
        'balance',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function linkedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'linked_user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function isEvenlyUser(): bool
    {
        return $this->linked_user_id !== null;
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', $this->name) ?: [];
        $letters = collect($parts)->filter()->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->take(2)->implode('');

        return $letters !== '' ? $letters : '+';
    }

    public function openLoanLabel(): string
    {
        $balance = (float) $this->balance;

        if ($balance == 0.0) {
            return 'no open loans';
        }

        if ($balance > 0) {
            return 'owes you '.$this->formatMoney($balance);
        }

        return 'you owe '.$this->formatMoney(abs($balance));
    }

    public function toApiArray(): array
    {
        $balance = (float) $this->balance;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'note' => $this->note,
            'initials' => $this->initials(),
            'is_evenly_user' => $this->isEvenlyUser(),
            'linked_user_id' => $this->linked_user_id,
            'balance' => $balance,
            'balance_label' => $this->openLoanLabel(),
            'direction' => $balance > 0 ? 'owes_you' : ($balance < 0 ? 'you_owe' : 'settled'),
            'has_open_loan' => $balance != 0.0,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }

    private function formatMoney(float $amount): string
    {
        return number_format($amount, 2);
    }
}
