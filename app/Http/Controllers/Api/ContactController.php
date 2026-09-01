<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Support\Phone;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = $request->user()->contacts()->latest();

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $contacts = $query->get()->map->toApiArray();

        return $this->success($contacts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $phone = Phone::normalize($data['phone'] ?? null, $data['country_code'] ?? null);
        $user = $request->user();

        if ($phone) {
            $existing = $user->contacts()->where('phone', $phone)->first();
            if ($existing) {
                return $this->success($existing->toApiArray(), 'Contact already exists.');
            }
        }

        $linked = $phone ? User::where('phone', $phone)->where('id', '!=', $user->id)->first() : null;

        $contact = $user->contacts()->create([
            'name' => $data['name'],
            'phone' => $phone,
            'note' => $data['note'] ?? null,
            'linked_user_id' => $linked?->id,
        ]);

        return $this->created($contact->toApiArray(), 'Contact created.');
    }

    public function show(Request $request, Contact $contact)
    {
        $this->authorizeContact($request, $contact);

        return $this->success($contact->toApiArray());
    }

    public function sync(Request $request)
    {
        $data = $request->validate([
            'contacts' => ['required', 'array', 'max:1000'],
            'contacts.*.name' => ['required', 'string', 'max:120'],
            'contacts.*.phone' => ['nullable', 'string', 'max:20'],
            'contacts.*.country_code' => ['nullable', 'string', 'max:8'],
        ]);

        $user = $request->user();
        $synced = 0;

        foreach ($data['contacts'] as $row) {
            $phone = Phone::normalize($row['phone'] ?? null, $row['country_code'] ?? null);
            if (! $phone) {
                continue;
            }
            if (! $user->isDemo() && in_array($phone, ['+15551230001', '+15551230002', '+15551230003'], true)) {
                continue;
            }

            $linked = User::where('phone', $phone)->where('id', '!=', $user->id)->first();

            $user->contacts()->updateOrCreate(
                ['phone' => $phone],
                [
                    'name' => $row['name'],
                    'linked_user_id' => $linked?->id,
                ]
            );
            $synced++;
        }

        return $this->success(['synced' => $synced], 'Contacts synced.');
    }

    private function authorizeContact(Request $request, Contact $contact): void
    {
        abort_unless($contact->user_id === $request->user()->id, 404);
    }
}
