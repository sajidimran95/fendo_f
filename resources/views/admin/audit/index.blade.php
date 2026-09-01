@extends('admin.layouts.app')
@section('title', 'Audit log')
@section('page-title', 'Audit log')
@section('page-subtitle', 'Admin actions and security events')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description or admin" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white placeholder-gray-500 w-64">
    <select name="action" class="bg-gray-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white">
        <option value="">All actions</option>
        @foreach($actions as $action)
            <option value="{{ $action }}" @selected(request('action') === $action)>{{ str_replace(['.', '_'], ' ', ucfirst($action)) }}</option>
        @endforeach
    </select>
    <button class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-xl">Filter</button>
</form>

<div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-white/5 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="text-left px-4 py-3">When</th>
                <th class="text-left px-4 py-3">Admin</th>
                <th class="text-left px-4 py-3">Action</th>
                <th class="text-left px-4 py-3">Details</th>
                <th class="text-left px-4 py-3">IP</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($logs as $log)
            <tr class="hover:bg-white/5">
                <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                <td class="px-4 py-3 text-white">
                    {{ $log->admin?->name ?? 'Deleted admin' }}
                    <span class="block text-xs text-gray-500">{{ $log->admin?->email }}</span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-xs px-2 py-1 rounded-lg {{ $log->actionColor() }}">{{ $log->actionLabel() }}</span>
                </td>
                <td class="px-4 py-3 text-gray-300">
                    {{ $log->description ?? '—' }}
                    @if($log->metadata)
                        <span class="block text-xs text-gray-500 mt-1">{{ json_encode($log->metadata) }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $log->ip_address ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-gray-500">No audit entries yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $logs->links() }}</div>
@endsection
