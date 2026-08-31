@extends('front.layouts.app')
@section('nonav')
@endsection
@section('title', $contact->name)
@section('header', '')
@section('back', route('front.summary'))
@section('right')
<a href="{{ route('front.history', ['contact_id' => $contact->id]) }}" class="opacity-90">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
</a>
@endsection
@section('content')
<div class="green text-white text-center pt-2 pb-10 -mt-0">
    <div class="w-24 h-24 mx-auto rounded-full bg-[#1f4d1a] text-4xl font-bold flex items-center justify-center">{{ $contact->initials() }}</div>
    <p class="mt-3 font-semibold px-4">{{ $contact->name }}</p>
</div>
<div class="bg-white -mt-4 rounded-t-3xl pt-8 pb-10 px-6 text-center">
    <p class="text-slate-500 mb-8">{{ $contact->openLoanLabel() }}</p>
    <div class="grid grid-cols-2 gap-8 mb-10">
        <a href="{{ route('front.loans.form', [$contact, 'lend']) }}" class="flex flex-col items-center gap-2">
            <span class="w-16 h-16 rounded-2xl bg-green-50 green-text flex items-center justify-center text-2xl">↑</span>
            <span class="font-medium">Lend</span>
        </a>
        <a href="{{ route('front.loans.form', [$contact, 'borrow']) }}" class="flex flex-col items-center gap-2">
            <span class="w-16 h-16 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center text-2xl">↓</span>
            <span class="font-medium">Borrow</span>
        </a>
    </div>
    <a href="{{ route('front.loans.form', [$contact, 'pay']) }}" class="block w-full bg-slate-100 text-slate-700 py-3 rounded-xl mb-3">Pay debt</a>
    <form method="POST" action="{{ route('front.loans.close', $contact) }}" onsubmit="return confirm('Close this debt?')">
        @csrf
        <button class="w-full bg-[#e8f6dc] green-text font-medium py-3 rounded-xl">Close debt</button>
    </form>
</div>
@endsection
