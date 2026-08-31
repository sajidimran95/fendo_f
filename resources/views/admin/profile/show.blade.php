@extends('admin.layouts.app')
@section('title','My Profile')
@section('page-title','My Profile')
@section('page-subtitle','Admin account settings')

@section('content')

<div class="grid lg:grid-cols-2 gap-5 max-w-4xl">

    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-white mb-4">Profile photo</h3>
        <div class="flex items-center space-x-4 mb-5">
            @if($admin->avatarUrl())
                <img src="{{ $admin->avatarUrl() }}" alt="Avatar" class="w-20 h-20 rounded-2xl object-cover border border-white/10">
            @else
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-2xl font-bold text-white">
                    {{ $admin->initials() }}
                </div>
            @endif
            <div>
                <h2 class="text-base font-bold text-white">{{ $admin->displayName() }}</h2>
                <p class="text-xs text-gray-400">{{ $admin->email }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs bg-purple-500/15 text-purple-400">Administrator</span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.profile.avatar') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <label class="block text-xs text-gray-400 mb-1.5">Upload image (JPG, PNG, WEBP · max 2MB)</label>
            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" required
                class="block w-full text-sm text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-500/20 file:text-indigo-300 hover:file:bg-indigo-500/30">
            <button type="submit" class="w-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 hover:bg-indigo-500/30 text-sm font-medium py-2.5 rounded-xl transition-colors">
                Save photo
            </button>
        </form>

        @if($admin->avatarUrl())
        <form method="POST" action="{{ route('admin.profile.avatar.delete') }}" class="mt-3" onsubmit="return confirm('Remove profile photo?')">
            @csrf
            <button type="submit" class="w-full text-sm text-red-400 hover:text-red-300 py-2">Remove photo</button>
        </form>
        @endif

        <div class="space-y-2 text-xs mt-6">
            @foreach([
                ['Member since',$admin->created_at->format('d M Y')],
                ['Last login',$admin->last_login_at?->format('d M Y H:i') ?? '—'],
            ] as [$k,$v])
            <div class="flex justify-between py-1.5 border-b border-white/5">
                <span class="text-gray-400">{{ $k }}</span>
                <span class="text-white font-medium">{{ $v }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-white mb-4">Change Password</h3>
        <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-gray-400 mb-1.5">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500/50">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1.5">New Password</label>
                <input type="password" name="password" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500/50">
                <p class="text-xs text-gray-500 mt-1">Min 8 characters</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500/50">
            </div>
            <button type="submit" class="w-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 hover:bg-indigo-500/30 text-sm font-medium py-2.5 rounded-xl transition-colors">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
