@extends('front.layouts.app')
@section('title', 'History')
@section('header', 'History')
@section('content')
@if($transactions->isEmpty())
    <div class="flex flex-col items-center justify-center pt-24 text-slate-400">
        <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <p>Transactions history is empty</p>
    </div>
@else
    <div class="divide-y">
        @foreach($transactions as $tx)
            <a href="{{ route('front.contacts.show', $tx->contact_id) }}" class="flex items-center gap-3 px-4 py-3">
                <span class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-sm font-bold">{{ $tx->contact?->initials() }}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-medium truncate">{{ $tx->contact?->name }}</p>
                    <p class="text-xs text-slate-400">{{ str_replace('_',' ', $tx->type) }} · {{ $tx->created_at->diffForHumans() }}</p>
                    @if($tx->description)<p class="text-xs text-slate-500">{{ $tx->description }}</p>@endif
                </div>
                <span class="font-semibold {{ $tx->type === 'borrow' ? 'text-orange-500' : 'green-text' }}">{{ number_format($tx->amount, 0) }}</span>
            </a>
        @endforeach
    </div>
    <div class="p-4">{{ $transactions->links() }}</div>
@endif
@endsection
