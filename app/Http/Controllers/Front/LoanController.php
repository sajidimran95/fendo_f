<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Services\LoanService;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function __construct(private LoanService $loans) {}

    public function create(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $contacts = $request->user()
            ->contacts()
            ->when($q !== '', fn ($query) => $query->where(function ($inner) use ($q) {
                $inner->where('name', 'like', "%{$q}%")->orWhere('phone', 'like', "%{$q}%");
            }))
            ->orderBy('name')
            ->get();

        return view('front.loans.create', compact('contacts', 'q'));
    }

    public function storeContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $phone = Phone::normalize($data['phone'] ?? null);
        $user = $request->user();

        if ($phone) {
            $existing = $user->contacts()->where('phone', $phone)->first();
            if ($existing) {
                return redirect()->route('front.contacts.show', $existing);
            }
        }

        $linked = $phone ? User::where('phone', $phone)->where('id', '!=', $user->id)->first() : null;

        $contact = $user->contacts()->create([
            'name' => $data['name'],
            'phone' => $phone,
            'linked_user_id' => $linked?->id,
        ]);

        return redirect()->route('front.contacts.show', $contact);
    }

    public function show(Request $request, Contact $contact)
    {
        abort_unless($contact->user_id === $request->user()->id, 404);

        return view('front.loans.show', compact('contact'));
    }

    public function form(Request $request, Contact $contact, string $type)
    {
        abort_unless($contact->user_id === $request->user()->id, 404);
        abort_unless(in_array($type, ['lend', 'borrow', 'pay'], true), 404);

        return view('front.loans.form', compact('contact', 'type'));
    }

    public function store(Request $request, Contact $contact)
    {
        abort_unless($contact->user_id === $request->user()->id, 404);

        $data = $request->validate([
            'type' => ['required', Rule::in(['lend', 'borrow', 'pay'])],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:80'],
        ]);

        try {
            $amount = round((float) $data['amount'], 2);
            $tx = match ($data['type']) {
                'lend' => $this->loans->lend($request->user(), $contact, $amount, $data['description'] ?? null),
                'borrow' => $this->loans->borrow($request->user(), $contact, $amount, $data['description'] ?? null),
                default => $this->loans->payDebt($request->user(), $contact, $amount, $data['description'] ?? null),
            };
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('front.contacts.show', $contact)->with('success', 'Saved.');
    }

    public function close(Request $request, Contact $contact)
    {
        abort_unless($contact->user_id === $request->user()->id, 404);

        try {
            $this->loans->closeDebt($request->user(), $contact);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return redirect()->route('front.contacts.show', $contact)->with('success', 'Debt closed.');
    }
}
