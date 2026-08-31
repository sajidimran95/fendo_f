@extends('front.layouts.guest')
@section('title', 'First login')
@section('content')
<div class="green min-h-screen px-5 pt-4 pb-10 text-white">
    <div class="flex items-center mb-8">
        <form method="POST" action="{{ route('front.logout') }}">@csrf<button class="text-2xl">‹</button></form>
        <h1 class="flex-1 text-center font-semibold pr-6">First login</h1>
    </div>
    <form method="POST" action="{{ route('front.onboarding.save') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if($errors->any())
            <p class="text-sm bg-white/10 rounded-xl px-3 py-2">{{ $errors->first() }}</p>
        @endif
        <div>
            <label class="text-sm">First Name</label>
            <input name="first_name" required class="mt-1 w-full rounded-xl bg-white/15 border border-white/20 px-4 py-3 outline-none">
        </div>
        <div>
            <label class="text-sm">Last Name</label>
            <input name="last_name" placeholder="optional" class="mt-1 w-full rounded-xl bg-white/15 border border-white/20 px-4 py-3 outline-none placeholder-white/50">
        </div>
        <div>
            <label class="text-sm">Photo</label>
            <input type="file" name="avatar" accept="image/*" class="mt-1 block w-full text-sm">
        </div>
        <div>
            <label class="text-sm">Gender</label>
            <div class="mt-2 grid grid-cols-3 gap-2">
                @foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $val=>$label)
                    <label class="text-center py-2 rounded-xl bg-white/15 has-[:checked]:bg-white/30 cursor-pointer text-sm">
                        <input type="radio" name="gender" value="{{ $val }}" class="hidden" {{ $val==='male' ? 'checked' : '' }}> {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>
        <button class="pt-6 text-white font-semibold">Sign up ›</button>
    </form>
</div>
@endsection
