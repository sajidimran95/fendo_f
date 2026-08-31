@extends('admin.layouts.app')
@section('title', $user->displayName())
@section('page-title', $user->displayName())
@section('page-subtitle', $user->phone)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <a href="{{ route('admin.users') }}" class="text-sm text-gray-400 hover:text-white">← Back to users</a>
    @if($user->status === 'active')
        <form method="POST" action="{{ route('admin.users.suspend', $user) }}" onsubmit="return confirm('Suspend this user?')">
            @csrf
            <button class="bg-orange-500/20 text-orange-300 text-sm px-4 py-2 rounded-xl">Suspend</button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.users.restore', $user) }}">
            @csrf
            <button class="bg-emerald-500/20 text-emerald-300 text-sm px-4 py-2 rounded-xl">Restore</button>
        </form>
    @endif
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-5">
    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-4">
            @if($user->avatarUrl())
                <img src="{{ $user->avatarUrl() }}" alt="" class="w-14 h-14 rounded-2xl object-cover border border-white/10">
            @else
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/30 text-indigo-200 text-lg font-bold flex items-center justify-center">{{ $user->initials() }}</div>
            @endif
            <div>
                <p class="text-white font-medium">{{ $user->displayName() }}</p>
                <p class="text-xs text-gray-500">{{ $user->phone ?? '—' }}</p>
            </div>
        </div>
        <p class="text-xs text-gray-500 mb-1">Name</p>
        <p class="text-white font-medium">{{ $user->displayName() }}</p>
        <p class="text-xs text-gray-500 mt-3 mb-1">Phone</p>
        <p class="text-white">{{ $user->phone ?? '—' }}</p>
        <p class="text-xs text-gray-500 mt-3 mb-1">Gender</p>
        <p class="text-white">{{ $user->gender ?? '—' }}</p>
        <p class="text-xs text-gray-500 mt-3 mb-1">Status</p>
        <p class="text-white">{{ $user->status }} · {{ $user->profile_completed ? 'profile complete' : 'onboarding' }}</p>
    </div>
    <div class="lg:col-span-2 bg-gray-900 border border-white/5 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-white mb-4">Contacts</h3>
        <div class="space-y-2">
            @forelse($user->contacts as $contact)
            <div class="flex items-center justify-between text-sm">
                <div>
                    <p class="text-white">{{ $contact->name }}</p>
                    <p class="text-xs text-gray-500">{{ $contact->phone ?? 'no phone' }} {{ $contact->isEvenlyUser() ? '· evenly' : '' }}</p>
                </div>
                <span class="{{ (float)$contact->balance > 0 ? 'text-emerald-400' : ((float)$contact->balance < 0 ? 'text-orange-400' : 'text-gray-500') }}">${{ number_format($contact->balance, 2) }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No contacts.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
    <h3 class="text-sm font-semibold text-white mb-4">Recent transactions</h3>
    <table class="w-full text-sm">
        <thead><tr class="text-left text-xs text-gray-500 uppercase"><th class="pb-2">Type</th><th class="pb-2">Contact</th><th class="pb-2">Amount</th><th class="pb-2">When</th></tr></thead>
        <tbody class="divide-y divide-white/5">
            @forelse($transactions as $tx)
            <tr>
                <td class="py-2 text-indigo-300">{{ str_replace('_',' ',$tx->type) }}</td>
                <td class="py-2 text-white">{{ $tx->contact?->name }}</td>
                <td class="py-2 text-white">${{ number_format($tx->amount, 2) }}</td>
                <td class="py-2 text-gray-500">{{ $tx->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-4 text-gray-500">No transactions.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
