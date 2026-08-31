<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Services\AvatarService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppController extends Controller
{
    public function summary(Request $request)
    {
        $contacts = $request->user()->contacts()->get();
        $iOwe = $contacts->filter(fn ($c) => (float) $c->balance < 0);
        $oweMe = $contacts->filter(fn ($c) => (float) $c->balance > 0);
        $q = trim((string) $request->query('q', ''));

        if ($q !== '') {
            $contacts = $contacts->filter(fn ($c) => str_contains(mb_strtolower($c->name), mb_strtolower($q))
                || str_contains((string) $c->phone, $q));
        }

        return view('front.summary', [
            'iOweTotal' => round($iOwe->sum(fn ($c) => abs((float) $c->balance)), 2),
            'oweMeTotal' => round($oweMe->sum(fn ($c) => (float) $c->balance), 2),
            'iOwe' => $iOwe,
            'oweMe' => $oweMe,
            'q' => $q,
        ]);
    }

    public function history(Request $request)
    {
        $transactions = $request->user()
            ->transactions()
            ->with('contact')
            ->latest()
            ->paginate(20);

        return view('front.history', compact('transactions'));
    }

    public function settings(Request $request)
    {
        return view('front.settings', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request, AvatarService $avatars)
    {
        $user = $request->user();
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'notifications_enabled' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'name' => trim($data['first_name'].' '.($data['last_name'] ?? '')),
            'gender' => $data['gender'],
            'notifications_enabled' => $request->boolean('notifications_enabled'),
        ]);

        if ($request->hasFile('avatar')) {
            $avatars->store($user, $request->file('avatar'));
        }

        return back()->with('success', 'Profile updated.');
    }

    public function feedback(Request $request)
    {
        $request->validate(['message' => ['required', 'string', 'min:3', 'max:2000']]);

        Feedback::create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thanks for your feedback.');
    }
}
