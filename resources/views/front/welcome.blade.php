@extends('front.layouts.guest')
@section('title', 'fendo')
@section('content')
<div class="green curve pt-12 pb-20 text-center">
    <p class="text-white text-4xl font-bold tracking-tight">fendo</p>
</div>
<div class="px-5 -mt-10">
    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-4">
        <h2 class="text-center font-semibold text-slate-700 mb-4">Loans</h2>
        <div class="space-y-3 text-sm text-slate-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-100"></div>
                <div class="flex-1"><div class="h-2 bg-slate-100 rounded w-24 mb-1"></div><div class="h-2 bg-slate-100 rounded w-16"></div></div>
                <span class="green-text font-semibold">300</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-orange-100"></div>
                <div class="flex-1"><div class="h-2 bg-slate-100 rounded w-20 mb-1"></div><div class="h-2 bg-slate-100 rounded w-12"></div></div>
                <span class="text-orange-500 font-semibold">40</span>
            </div>
        </div>
    </div>
    <p class="text-center text-slate-600 mt-8 mb-6 px-4">Handy and interactive way to track loans between friends</p>
    <a href="{{ route('front.phone') }}" class="block green text-white text-center font-semibold py-3.5 pill">
        Sign in with phone
    </a>
</div>
@endsection
