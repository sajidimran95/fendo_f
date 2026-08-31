@extends('admin.layouts.app')
@section('title', 'Loans')
@section('page-title', 'Loans')
@section('page-subtitle', 'All lend / borrow / pay / close records')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user or contact" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white placeholder-gray-500 w-64">
    <select name="type" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white">
        <option value="">All types</option>
        @foreach(['lend','borrow','pay_debt','close_debt'] as $type)
            <option value="{{ $type }}" @selected(request('type')===$type)>{{ str_replace('_',' ', $type) }}</option>
        @endforeach
    </select>
    <button class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-xl">Filter</button>
</form>

<div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-white/5 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="text-left px-4 py-3">When</th>
                <th class="text-left px-4 py-3">User</th>
                <th class="text-left px-4 py-3">Contact</th>
                <th class="text-left px-4 py-3">Type</th>
                <th class="text-left px-4 py-3">Amount</th>
                <th class="text-left px-4 py-3">Note</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($transactions as $tx)
            <tr>
                <td class="px-4 py-3 text-gray-400">{{ $tx->created_at->format('d M Y H:i') }}</td>
                <td class="px-4 py-3 text-white">{{ $tx->user?->displayName() }}</td>
                <td class="px-4 py-3 text-gray-300">{{ $tx->contact?->name }}</td>
                <td class="px-4 py-3 text-indigo-300">{{ str_replace('_',' ', $tx->type) }}</td>
                <td class="px-4 py-3 text-white font-medium">${{ number_format($tx->amount, 2) }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $tx->description ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-gray-500">No loans yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $transactions->links() }}</div>
@endsection
