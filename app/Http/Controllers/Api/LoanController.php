<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\LoanService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LoanController extends Controller
{
    use ApiResponse;

    public function __construct(private LoanService $loans) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
            'type' => ['required', Rule::in(['lend', 'borrow'])],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:80'],
        ]);

        $contact = $this->ownedContact($request, $data['contact_id']);
        $amount = round((float) $data['amount'], 2);

        $tx = $data['type'] === 'lend'
            ? $this->loans->lend($request->user(), $contact, $amount, $data['description'] ?? null)
            : $this->loans->borrow($request->user(), $contact, $amount, $data['description'] ?? null);

        return $this->created([
            'transaction' => $tx->toApiArray(),
            'contact' => $contact->fresh()->toApiArray(),
        ], $data['type'] === 'lend' ? 'Loan recorded.' : 'Borrow recorded.');
    }

    public function pay(Request $request, Contact $contact)
    {
        $this->assertOwned($request, $contact);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:80'],
        ]);

        $tx = $this->loans->payDebt(
            $request->user(),
            $contact,
            round((float) $data['amount'], 2),
            $data['description'] ?? null
        );

        return $this->success([
            'transaction' => $tx->toApiArray(),
            'contact' => $contact->fresh()->toApiArray(),
        ], 'Payment recorded.');
    }

    public function close(Request $request, Contact $contact)
    {
        $this->assertOwned($request, $contact);

        $tx = $this->loans->closeDebt($request->user(), $contact);

        return $this->success([
            'transaction' => $tx->toApiArray(),
            'contact' => $contact->fresh()->toApiArray(),
        ], 'Debt closed.');
    }

    private function ownedContact(Request $request, int $id): Contact
    {
        $contact = Contact::findOrFail($id);
        $this->assertOwned($request, $contact);

        return $contact;
    }

    private function assertOwned(Request $request, Contact $contact): void
    {
        abort_unless($contact->user_id === $request->user()->id, 404);
    }
}
