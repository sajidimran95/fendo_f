@extends('admin.layouts.app')
@section('title', 'Feedback')
@section('page-title', 'Feedback')
@section('page-subtitle', 'Messages sent from the app')

@section('content')
<div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-white/5 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="text-left px-4 py-3">When</th>
                <th class="text-left px-4 py-3">User</th>
                <th class="text-left px-4 py-3">Message</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($feedback as $item)
            <tr>
                <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                <td class="px-4 py-3 text-white">{{ $item->user?->displayName() ?? 'Deleted' }}<br><span class="text-xs text-gray-500">{{ $item->user?->phone }}</span></td>
                <td class="px-4 py-3 text-gray-200">{{ $item->message }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-4 py-8 text-gray-500">No feedback yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $feedback->links() }}</div>
@endsection
