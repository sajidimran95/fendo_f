@extends('front.layouts.app')
@section('title', 'Create Loan')
@section('header', 'Create Loan')
@section('back', route('front.summary'))
@section('back-icon', '✕')
@section('right')
<span></span>
@endsection
@section('content')
<form method="GET" class="px-4 py-3">
    <input name="q" value="{{ $q }}" placeholder="Find or create user" class="w-full bg-slate-100 rounded-xl px-4 py-2.5 text-sm outline-none">
</form>

<form method="POST" action="{{ route('front.contacts.store') }}" class="px-4 pb-3 flex gap-2">
    @csrf
    <input name="name" required placeholder="Name" class="flex-1 border rounded-xl px-3 py-2 text-sm">
    <input name="phone" placeholder="Phone" class="w-32 border rounded-xl px-3 py-2 text-sm">
    <button class="green text-white text-sm px-3 rounded-xl">Add</button>
</form>

<p class="px-4 text-xs text-slate-400 mb-1">All contacts</p>
<div class="divide-y">
    @forelse($contacts as $c)
        <a href="{{ route('front.contacts.show', $c) }}" class="flex items-center gap-3 px-4 py-3">
            <span class="w-10 h-10 rounded-full bg-slate-100 font-bold text-sm flex items-center justify-center">{{ $c->initials() }}</span>
            <div class="flex-1 min-w-0">
                <p class="font-medium truncate">{{ $c->name }}
                    @if($c->isEvenlyUser())<span class="ml-1 text-[10px] green text-white px-1.5 py-0.5 rounded">fendo</span>@endif
                </p>
                <p class="text-xs text-slate-400">{{ $c->phone ?? $c->openLoanLabel() }}</p>
            </div>
        </a>
    @empty
        <p class="px-4 py-8 text-slate-400 text-sm">No contacts yet. Add someone above.</p>
    @endforelse
</div>
@endsection
