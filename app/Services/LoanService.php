<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanService
{
    public function lend(User $user, Contact $contact, float $amount, ?string $description = null): Transaction
    {
        return $this->record($user, $contact, Transaction::TYPE_LEND, $amount, $description, $amount);
    }

    public function borrow(User $user, Contact $contact, float $amount, ?string $description = null): Transaction
    {
        return $this->record($user, $contact, Transaction::TYPE_BORROW, $amount, $description, -$amount);
    }

    public function payDebt(User $user, Contact $contact, float $amount, ?string $description = null): Transaction
    {
        $balance = (float) $contact->balance;

        if ($balance == 0.0) {
            throw ValidationException::withMessages([
                'amount' => ['There is no open loan to pay.'],
            ]);
        }

        if ($amount > abs($balance)) {
            throw ValidationException::withMessages([
                'amount' => ['Payment cannot be greater than the open balance of '.number_format(abs($balance), 2).'.'],
            ]);
        }

        // Move balance toward zero.
        $delta = $balance > 0 ? -$amount : $amount;

        return $this->record($user, $contact, Transaction::TYPE_PAY_DEBT, $amount, $description, $delta);
    }

    public function closeDebt(User $user, Contact $contact): Transaction
    {
        $balance = (float) $contact->balance;

        if ($balance == 0.0) {
            throw ValidationException::withMessages([
                'contact' => ['There is no open loan to close.'],
            ]);
        }

        return $this->record(
            $user,
            $contact,
            Transaction::TYPE_CLOSE_DEBT,
            abs($balance),
            'Closed debt',
            -$balance
        );
    }

    private function record(
        User $user,
        Contact $contact,
        string $type,
        float $amount,
        ?string $description,
        float $delta
    ): Transaction {
        return DB::transaction(function () use ($user, $contact, $type, $amount, $description, $delta) {
            $contact->refresh();
            $contact->balance = round((float) $contact->balance + $delta, 2);
            $contact->save();

            $tx = Transaction::create([
                'user_id' => $user->id,
                'contact_id' => $contact->id,
                'type' => $type,
                'amount' => $amount,
                'description' => $description,
                'balance_after' => $contact->balance,
            ]);

            $this->notifyLinkedUser($user, $contact, $type, $amount, $description);

            return $tx->load('contact');
        });
    }

    private function notifyLinkedUser(User $actor, Contact $contact, string $type, float $amount, ?string $description): void
    {
        if (! $contact->linked_user_id) {
            return;
        }

        $target = User::find($contact->linked_user_id);
        if (! $target || ! $target->notifications_enabled) {
            return;
        }

        $name = $actor->displayName();
        $money = number_format($amount, 2);
        $note = $description ? " for {$description}" : '';

        $title = match ($type) {
            Transaction::TYPE_LEND => "{$name} lent you {$money}",
            Transaction::TYPE_BORROW => "{$name} borrowed {$money}",
            Transaction::TYPE_PAY_DEBT => "{$name} recorded a payment of {$money}",
            Transaction::TYPE_CLOSE_DEBT => "{$name} closed your loan",
            default => "{$name} updated a loan",
        };

        AppNotification::create([
            'user_id' => $target->id,
            'title' => $title,
            'body' => trim($title.$note),
            'data' => [
                'type' => $type,
                'amount' => $amount,
                'from_user_id' => $actor->id,
            ],
        ]);
    }
}
