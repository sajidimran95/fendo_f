@extends('front.layouts.guest')
@section('title', 'Verify phone number')
@section('content')
<div class="green px-4 py-4 flex items-center text-white">
    <a href="{{ route('front.phone') }}" class="text-2xl mr-3">‹</a>
    <h1 class="font-semibold flex-1 text-center pr-6">Verify phone number</h1>
</div>
<form method="POST" action="{{ route('front.otp.verify') }}" class="p-6 text-center">
    @csrf
    <p class="text-slate-600 mb-6">Enter the 6-digit code we sent to <span class="text-blue-600">{{ $phone }}</span></p>
    @if(session('otp_hint'))
        <p class="text-xs text-amber-600 mb-3">Dev OTP: <strong>{{ session('otp_hint') }}</strong></p>
    @endif
    @if($errors->any())
        <p class="text-sm text-red-600 mb-3">{{ $errors->first() }}</p>
    @endif
    <input name="otp" maxlength="6" inputmode="numeric" required placeholder="------" class="tracking-[0.6em] text-2xl text-center border-b-2 border-slate-300 w-56 py-2 outline-none focus:border-[#6DB33F]">
    <button class="mt-10 w-full green text-white font-semibold py-3 pill">Next</button>
</form>
@endsection
