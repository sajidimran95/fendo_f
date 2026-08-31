@extends('admin.layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Registered app users')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or phone" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white placeholder-gray-500 w-64">
    <select name="status" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white">
        <option value="">All statuses</option>
        <option value="active" @selected(request('status')==='active')>Active</option>
        <option value="suspended" @selected(request('status')==='suspended')>Suspended</option>
    </select>
    <button class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-xl">Filter</button>
</form>

<div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-white/5 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="text-left px-4 py-3">User</th>
                <th class="text-left px-4 py-3">Phone</th>
                <th class="text-left px-4 py-3">Contacts</th>
                <th class="text-left px-4 py-3">Loans</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="text-left px-4 py-3">Joined</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($users as $user)
            <tr class="hover:bg-white/5">
                <td class="px-4 py-3">
                    <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3 text-white font-medium hover:text-indigo-300">
                        @if($user->avatarUrl())
                            <img src="{{ $user->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <span class="w-8 h-8 rounded-full bg-indigo-500/30 text-indigo-200 text-xs font-bold flex items-center justify-center">{{ $user->initials() }}</span>
                        @endif
                        <span>
                            {{ $user->displayName() }}
                            <span class="block text-xs text-gray-500 font-normal">{{ $user->gender ?? '—' }}</span>
                        </span>
                    </a>
                </td>
                <td class="px-4 py-3 text-gray-300">{{ $user->phone ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-300">{{ $user->contacts_count }}</td>
                <td class="px-4 py-3 text-gray-300">{{ $user->transactions_count }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs px-2 py-1 rounded-lg {{ $user->status === 'active' ? 'bg-emerald-500/15 text-emerald-400' : 'bg-orange-500/15 text-orange-400' }}">{{ $user->status }}</span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-gray-500">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
