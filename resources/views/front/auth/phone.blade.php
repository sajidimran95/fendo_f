@extends('front.layouts.guest')
@section('title', 'Enter phone number')
@section('content')
<div class="green px-4 py-4 flex items-center justify-between text-white">
    <a href="{{ route('front.welcome') }}" class="text-sm">Cancel</a>
    <h1 class="font-semibold">Enter phone number</h1>
    <span class="w-12"></span>
</div>
<form method="POST" action="{{ route('front.phone.send') }}" class="p-4" id="phoneForm">
    @csrf
    @if($errors->any())
        <div class="text-sm text-red-600 mb-3">{{ $errors->first() }}</div>
    @endif
    <div class="flex items-center justify-between py-3 border-b">
        <span class="text-slate-600">Country</span>
        <select name="country_code" class="text-right outline-none bg-transparent">
            <option value="+1">🇺🇸 +1 United States</option>
            <option value="+880" selected>🇧🇩 +880 Bangladesh</option>
            <option value="+44">🇬🇧 +44 United Kingdom</option>
            <option value="+91">🇮🇳 +91 India</option>
        </select>
    </div>
    <div class="flex items-center justify-between py-3 border-b">
        <span class="text-slate-600">Number</span>
        <input type="tel" name="phone" required placeholder="Phone number" class="text-right outline-none flex-1 ml-4" autofocus>
    </div>
    <button class="mt-8 w-full green text-white font-semibold py-3 pill">Verify</button>
</form>
@endsection
