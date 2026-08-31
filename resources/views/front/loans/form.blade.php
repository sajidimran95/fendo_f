@extends('front.layouts.guest')
@section('title', ucfirst($type))
@section('content')
@php
    $color = $type === 'borrow' ? '#c45c4a' : '#6DB33F';
    $label = $type === 'pay' ? 'Pay' : ucfirst($type);
@endphp
<div style="background:{{ $color }}" class="min-h-[42vh] text-white px-4 pt-4 pb-8">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('front.contacts.show', $contact) }}" class="text-2xl">✕</a>
        <a href="{{ route('front.history') }}" class="opacity-80">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </a>
    </div>
    <div class="w-24 h-24 mx-auto rounded-full bg-black/20 text-4xl font-bold flex items-center justify-center">{{ $contact->initials() }}</div>
    <p class="text-center mt-3 font-semibold px-4">{{ $contact->name }}</p>
    <form method="POST" action="{{ route('front.loans.store', $contact) }}" class="mt-6 space-y-3" id="loanForm">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input name="amount" type="number" step="0.01" min="0.01" required placeholder="Amount" class="w-full rounded-xl bg-white/20 px-4 py-3 outline-none placeholder-white/70">
        <input name="description" placeholder="Description" class="w-full rounded-xl bg-white/20 px-4 py-3 outline-none placeholder-white/70">
        <button class="flex items-center justify-center gap-2 w-full font-semibold pt-2">✓ {{ $label }}</button>
    </form>
    @if($errors->any())
        <p class="text-center text-sm mt-3 bg-black/20 rounded-xl py-2">{{ $errors->first() }}</p>
    @endif
</div>
<div class="p-4 text-center text-slate-400 text-sm">Enter amount and description, then tap {{ $label }}.</div>
@endsection
