@extends('front.layouts.app')
@section('title', 'Settings')
@section('header', 'Settings')
@section('back', route('front.summary'))
@section('right')<span></span>@endsection
@section('content')
<div class="px-4 py-6 text-center">
    @if($user->avatarUrl())
        <img src="{{ $user->avatarUrl() }}" class="w-20 h-20 rounded-full object-cover mx-auto">
    @else
        <div class="w-20 h-20 rounded-full bg-slate-200 mx-auto flex items-center justify-center text-xl font-bold">{{ $user->initials() }}</div>
    @endif
    <p class="mt-2 font-semibold">{{ $user->displayName() }}</p>
</div>

<form method="POST" action="{{ route('front.settings.profile') }}" enctype="multipart/form-data" class="px-4 space-y-3 border-t py-4">
    @csrf
    <p class="text-sm font-medium text-slate-500">Edit profile</p>
    <input name="first_name" value="{{ $user->first_name }}" required class="w-full border rounded-xl px-3 py-2 text-sm" placeholder="First name">
    <input name="last_name" value="{{ $user->last_name }}" class="w-full border rounded-xl px-3 py-2 text-sm" placeholder="Last name">
    <select name="gender" class="w-full border rounded-xl px-3 py-2 text-sm">
        @foreach(['male','female','other'] as $g)
            <option value="{{ $g }}" @selected($user->gender===$g)>{{ ucfirst($g) }}</option>
        @endforeach
    </select>
    <input type="file" name="avatar" accept="image/*" class="text-sm">
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="notifications_enabled" value="1" @checked($user->notifications_enabled)> Enable push notifications</label>
    <button class="green text-white w-full py-2.5 rounded-xl text-sm font-semibold">Save</button>
</form>

<form method="POST" action="{{ route('front.settings.feedback') }}" class="px-4 space-y-3 border-t py-4">
    @csrf
    <p class="text-sm font-medium text-slate-500">Feedback</p>
    <textarea name="message" required rows="3" class="w-full border rounded-xl px-3 py-2 text-sm" placeholder="Your message"></textarea>
    <button class="w-full border py-2.5 rounded-xl text-sm">Send feedback</button>
</form>

<p class="text-center text-xs text-slate-400 mt-4">Version: 1.0.0</p>
<form method="POST" action="{{ route('front.logout') }}" class="px-4 py-4">
    @csrf
    <button class="w-full green text-white py-3 rounded-full font-semibold">Log out</button>
</form>
@endsection
