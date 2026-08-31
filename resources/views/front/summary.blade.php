@extends('front.layouts.app')
@section('title', 'Summary')
@section('header', 'fendo')
@section('content')
<form method="GET" class="px-4 py-3">
    <input name="q" value="{{ $q }}" placeholder="Search" class="w-full bg-slate-100 rounded-full px-4 py-2.5 text-sm outline-none">
</form>

<div class="mx-4 rounded-xl overflow-hidden border border-red-100 mb-3">
    <div class="bg-[#fde8e8] px-4 py-2 flex justify-between text-sm font-semibold">
        <span>I owe</span>
        <span>{{ number_format($iOweTotal, 0) }}</span>
    </div>
    <div class="px-4 py-4">
        @forelse($iOwe as $c)
            <a href="{{ route('front.contacts.show', $c) }}" class="flex items-center justify-between py-2">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full bg-orange-100 text-orange-700 font-bold flex items-center justify-center text-sm">{{ $c->initials() }}</span>
                    <span class="font-medium">{{ $c->name }}</span>
                </div>
                <span class="text-orange-500 font-semibold">{{ number_format(abs($c->balance), 0) }}</span>
            </a>
        @empty
            <p class="text-slate-500 text-sm">Cool! You don't owe anyone!</p>
        @endforelse
    </div>
</div>

<div class="mx-4 rounded-xl overflow-hidden border border-green-100">
    <div class="bg-[#e8f6dc] px-4 py-2 flex justify-between text-sm font-semibold">
        <span>People owe me</span>
        <span>{{ number_format($oweMeTotal, 0) }}</span>
    </div>
    <div class="px-4 py-4">
        @forelse($oweMe as $c)
            <a href="{{ route('front.contacts.show', $c) }}" class="flex items-center justify-between py-2">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center text-sm">{{ $c->initials() }}</span>
                    <span class="font-medium">{{ $c->name }}</span>
                </div>
                <span class="green-text font-semibold">{{ number_format($c->balance, 0) }}</span>
            </a>
        @empty
            <p class="text-slate-500 text-sm">Uhh... No one owes you.</p>
        @endforelse
    </div>
</div>
@endsection
