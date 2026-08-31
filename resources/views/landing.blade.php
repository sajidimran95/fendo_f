<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fendo — Track loans between friends</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fendo: { DEFAULT: '#6DB33F', dark: '#5aa033', light: '#e8f6dc' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: Inter, system-ui, sans-serif; }</style>
</head>
<body class="bg-white text-slate-800">

    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-fendo text-white font-bold flex items-center justify-center">f</span>
                <span class="text-xl font-bold tracking-tight">fendo</span>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm text-slate-600">
                <a href="#benefits" class="hover:text-fendo">Benefits</a>
                <a href="#features" class="hover:text-fendo">Features</a>
                <a href="#how" class="hover:text-fendo">How it works</a>
            </nav>
            <a href="#get-app" class="bg-fendo hover:bg-fendo-dark text-white text-sm font-semibold px-4 py-2 rounded-full">Get the app</a>
        </div>
    </header>

    <section class="bg-fendo">
        <div class="max-w-6xl mx-auto px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <p class="text-white/80 text-sm font-medium mb-3">Loan tracker for friends &amp; business</p>
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-5">Handy way to track loans between friends</h1>
                <p class="text-white/90 text-lg mb-8 max-w-lg">Lend, borrow, pay back, and close debts in one place. See who owes you and who you owe — instantly.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#get-app" class="bg-white text-fendo-dark font-semibold px-6 py-3 rounded-full">Join on the mobile app</a>
                    <a href="#features" class="border border-white/40 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/10">See features</a>
                </div>
                <p class="mt-4 text-sm text-white/80">Register or log in with your phone inside the Fendo Flutter app.</p>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-2xl text-slate-800">
                <p class="font-semibold text-center mb-4">Summary</p>
                <div class="rounded-xl overflow-hidden mb-3">
                    <div class="bg-red-100 px-4 py-2 flex justify-between text-sm font-semibold"><span>I owe</span><span>40</span></div>
                    <div class="px-4 py-3 flex justify-between text-sm"><span>Sister</span><span class="text-orange-500 font-semibold">40</span></div>
                </div>
                <div class="rounded-xl overflow-hidden">
                    <div class="bg-fendo-light px-4 py-2 flex justify-between text-sm font-semibold"><span>People owe me</span><span>300</span></div>
                    <div class="px-4 py-3 flex justify-between text-sm"><span>Erlich</span><span class="text-fendo font-semibold">300</span></div>
                </div>
            </div>
        </div>
    </section>

    <section id="benefits" class="max-w-6xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold text-center mb-3">Why customers use Fendo</h2>
        <p class="text-center text-slate-500 mb-12">Simple money tracking — no banks, no confusion.</p>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['Never forget a loan', 'Every lend and borrow is saved with amount, person, and a short note.'],
                ['See your balance clearly', 'Green means they owe you. Orange means you owe them. One screen.'],
                ['Works with anyone', 'Track loans with friends and shops even if they are not on Fendo yet.'],
            ] as [$title, $text])
            <div class="rounded-2xl border border-slate-100 p-6 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-fendo-light text-fendo-dark font-bold flex items-center justify-center mb-4">✓</div>
                <h3 class="font-semibold text-lg mb-2">{{ $title }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $text }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section id="features" class="bg-slate-50 py-20">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-3">App features</h2>
            <p class="text-center text-slate-500 mb-12">Everything you will use in the Flutter app.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach([
                    ['Phone login', 'Sign in with your number. 6-digit OTP keeps your account safe.'],
                    ['Your profile', 'Name, photo, and gender — shown to people you share loans with.'],
                    ['Lend', 'Record money you gave someone, with amount and description.'],
                    ['Borrow', 'Record money you took, so both sides stay honest.'],
                    ['Pay debt', 'Partial payments update the open balance automatically.'],
                    ['Close debt', 'When you are even, close the loan in one tap.'],
                    ['Contacts', 'Add anyone from your book. Fendo users get a badge.'],
                    ['History', 'Full list of every lend, borrow, pay, and close.'],
                    ['Notifications', 'Know when a friend records a loan related to you.'],
                ] as [$title, $text])
                <div class="bg-white rounded-2xl p-5 border border-slate-100">
                    <h3 class="font-semibold mb-1">{{ $title }}</h3>
                    <p class="text-sm text-slate-500">{{ $text }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="how" class="max-w-6xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold text-center mb-12">How it works</h2>
        <div class="grid md:grid-cols-4 gap-6">
            @foreach([
                ['1', 'Install Fendo', 'Download the app on iOS or Android.'],
                ['2', 'Register with phone', 'Verify OTP and set your name.'],
                ['3', 'Add a person', 'Pick a contact or create a new one.'],
                ['4', 'Lend or borrow', 'Save the amount. Pay or close when done.'],
            ] as [$n, $title, $text])
            <div class="text-center">
                <div class="w-12 h-12 mx-auto rounded-full bg-fendo text-white font-bold text-lg flex items-center justify-center mb-3">{{ $n }}</div>
                <h3 class="font-semibold mb-1">{{ $title }}</h3>
                <p class="text-sm text-slate-500">{{ $text }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section id="get-app" class="bg-fendo">
        <div class="max-w-3xl mx-auto px-6 py-16 text-center text-white">
            <h2 class="text-3xl font-bold mb-3">Ready to join Fendo?</h2>
            <p class="text-white/90 mb-8">Customer register and login is inside the Flutter app. This website only shows the product. Use the app to create your account and start tracking loans.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <span class="bg-white text-fendo-dark font-semibold px-6 py-3 rounded-full">App Store — coming soon</span>
                <span class="bg-white/15 border border-white/40 font-semibold px-6 py-3 rounded-full">Google Play — coming soon</span>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
            <span class="font-semibold text-slate-700">fendo</span>
            <span>Track loans between friends.</span>
        </div>
    </footer>
</body>
</html>
