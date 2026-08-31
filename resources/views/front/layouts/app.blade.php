<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'fendo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, sans-serif; background: #f7f8f5; }
        .phone { max-width: 430px; margin: 0 auto; min-height: 100vh; background: #fff; position: relative; box-shadow: 0 0 40px rgba(0,0,0,.06); padding-bottom: 88px; }
        .green { background: #6DB33F; }
        .green-text { color: #6DB33F; }
        .nav-item { color: #9ca3af; }
        .nav-item.active { color: #6DB33F; }
    </style>
</head>
<body>
<div class="phone">
    <header class="green text-white px-4 py-4 flex items-center justify-between">
        @hasSection('back')
            <a href="@yield('back')" class="w-8 h-8 flex items-center justify-center text-xl">@yield('back-icon', '‹')</a>
        @else
            <span class="w-8"></span>
        @endif
        <h1 class="font-semibold text-lg">@yield('header', 'fendo')</h1>
        @hasSection('right')
            <div>@yield('right')</div>
        @else
            <a href="{{ route('front.settings') }}" class="w-8 h-8 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </a>
        @endif
    </header>

    @if(session('success'))
        <div class="mx-4 mt-3 text-sm bg-green-50 text-green-700 rounded-xl px-3 py-2">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mx-4 mt-3 text-sm bg-red-50 text-red-600 rounded-xl px-3 py-2">{{ $errors->first() }}</div>
    @endif

    <main>@yield('content')</main>

    @hasSection('nonav')
    @else
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[430px] bg-white border-t border-slate-100 flex items-end justify-around px-8 pt-2 pb-4">
        <a href="{{ route('front.summary') }}" class="nav-item {{ request()->routeIs('front.summary') ? 'active' : '' }} flex flex-col items-center text-xs gap-1">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Summary
        </a>
        <a href="{{ route('front.loans.create') }}" class="relative -top-5 w-14 h-14 rounded-full green text-white flex items-center justify-center text-3xl shadow-lg shadow-green-200">+</a>
        <a href="{{ route('front.history') }}" class="nav-item {{ request()->routeIs('front.history') ? 'active' : '' }} flex flex-col items-center text-xs gap-1">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            History
        </a>
    </nav>
    @endif
</div>
</body>
</html>
