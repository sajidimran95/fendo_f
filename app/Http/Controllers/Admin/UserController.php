<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminAudit;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->where('is_admin', false)
            ->when($request->search, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->withCount(['contacts', 'transactions'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        abort_if($user->is_admin, 404);

        $user->load(['contacts' => fn ($q) => $q->latest()->limit(20)]);
        $transactions = $user->transactions()->with('contact')->latest()->limit(20)->get();

        return view('admin.users.show', compact('user', 'transactions'));
    }

    public function suspend(User $user)
    {
        abort_if($user->is_admin, 403);
        $user->update(['status' => 'suspended']);
        $user->tokens()->delete();

        AdminAudit::log('user.suspend', $user, "Suspended {$user->displayName()} ({$user->phone})");

        return back()->with('success', $user->displayName().' has been suspended.');
    }

    public function ban(User $user)
    {
        abort_if($user->is_admin, 403);
        $user->update(['status' => 'banned']);
        $user->tokens()->delete();

        AdminAudit::log('user.ban', $user, "Banned {$user->displayName()} ({$user->phone})");

        return back()->with('success', $user->displayName().' has been banned.');
    }

    public function restore(User $user)
    {
        abort_if($user->is_admin, 403);
        $user->update(['status' => 'active']);

        AdminAudit::log('user.restore', $user, "Restored {$user->displayName()} ({$user->phone})");

        return back()->with('success', $user->displayName().' has been restored.');
    }
}
