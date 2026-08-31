<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public const TYPE_LEND = 'lend';
    public const TYPE_BORROW = 'borrow';
    public const TYPE_PAY_DEBT = 'pay_debt';
    public const TYPE_CLOSE_DEBT = 'close_debt';

    protected $fillable = [
        'user_id',
        'contact_id',
        'type',
        'amount',
        'description',
        'balance_after',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'contact_name' => $this->contact?->name,
            'contact_initials' => $this->contact?->initials(),
            'type' => $this->type,
            'amount' => (float) $this->amount,
            'description' => $this->description,
            'balance_after' => (float) $this->balance_after,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
