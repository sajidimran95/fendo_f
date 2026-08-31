<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fendo — Shared Expense & Bill Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0f4ff',
                            100: '#e0eaff',
                            200: '#c7d7fe',
                            300: '#a5b8fd',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }

        .gradient-hero {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-btn {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transition: all 0.3s ease;
        }
        .gradient-btn:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.4);
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(99, 102, 241, 0.15);
        }

        .floating-card {
            animation: float 4s ease-in-out infinite;
        }
        .floating-card:nth-child(2) { animation-delay: 0.5s; }
        .floating-card:nth-child(3) { animation-delay: 1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }

        .glow {
            box-shadow: 0 0 60px rgba(99, 102, 241, 0.35);
        }

        .stat-number {
            font-variant-numeric: tabular-nums;
        }

        /* Navbar scroll effect */
        .nav-scrolled {
            background: rgba(15, 12, 41, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }

        /* Step connector line */
        .step-line::after {
            content: '';
            position: absolute;
            top: 28px;
            left: calc(50% + 40px);
            width: calc(100% - 80px);
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .step-line::after { display: none; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-950 text-white">

    <!-- ========== NAVBAR ========== -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl gradient-btn flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Fendo</span>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">How It Works</a>
                    <a href="#splitting" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Splitting</a>
                    <a href="#pricing" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Pricing</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="#" class="gradient-btn text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg">Download App</a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-300 hover:text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 glass rounded-2xl p-4 space-y-3">
                <a href="#" class="block text-gray-300 hover:text-white text-sm font-medium py-2 transition-colors">Home</a>
                <a href="#features" class="block text-gray-300 hover:text-white text-sm font-medium py-2 transition-colors">Features</a>
                <a href="#how-it-works" class="block text-gray-300 hover:text-white text-sm font-medium py-2 transition-colors">How It Works</a>
                <a href="#splitting" class="block text-gray-300 hover:text-white text-sm font-medium py-2 transition-colors">Splitting</a>
                <a href="#pricing" class="block text-gray-300 hover:text-white text-sm font-medium py-2 transition-colors">Pricing</a>
                <div class="pt-2 border-t border-white/10">
                    <a href="#" class="gradient-btn text-white text-sm font-semibold px-5 py-2.5 rounded-xl text-center block">Download App</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== HERO ========== -->
    <section class="gradient-hero min-h-screen flex items-center pt-20 pb-16 relative overflow-hidden">
        <!-- Background orbs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-600 rounded-full opacity-10 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-600 rounded-full opacity-10 blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500 rounded-full opacity-5 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Text -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2 glass rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-sm text-gray-300 font-medium">Now available on iOS & Android</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Split Bills.<br>
                        <span class="gradient-text">Track Expenses.</span><br>
                        Stay Friends.
                    </h1>

                    <p class="text-gray-400 text-lg sm:text-xl mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Fendo makes splitting shared expenses effortless. Whether it's rent, a road trip, or dinner — track who owes what and settle up in seconds.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#" class="gradient-btn text-white font-bold px-8 py-4 rounded-2xl text-base shadow-xl flex items-center justify-center space-x-2">
                            <span>Download App</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                        <a href="#how-it-works" class="glass text-white font-semibold px-8 py-4 rounded-2xl text-base flex items-center justify-center space-x-2 hover:bg-white/10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>See How It Works</span>
                        </a>
                    </div>

                    <!-- Trust badges -->
                    <div class="mt-10 flex flex-wrap items-center gap-6 justify-center lg:justify-start">
                        <div class="flex items-center space-x-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-red-500 border-2 border-gray-900"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-gray-900"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 border-2 border-gray-900"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 border-2 border-gray-900"></div>
                            </div>
                            <span class="text-sm text-gray-400">Loved by <strong class="text-white">10,000+</strong> users</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm text-gray-400 ml-1">4.9/5 rating</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Dashboard Mockup Cards -->
                <div class="relative hidden lg:block">
                    <!-- Main dashboard card -->
                    <div class="glass rounded-3xl p-6 glow relative z-10">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Net Balance</p>
                                <p class="text-3xl font-bold text-green-400 stat-number mt-1">+$248.50</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-green-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-white/5 rounded-xl p-3">
                                <p class="text-xs text-gray-400 mb-1">Owed to you</p>
                                <p class="text-lg font-bold text-white stat-number">$312.00</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-3">
                                <p class="text-xs text-gray-400 mb-1">You owe</p>
                                <p class="text-lg font-bold text-red-400 stat-number">$63.50</p>
                            </div>
                        </div>
                        <!-- Activity list -->
                        <div class="space-y-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Recent Activity</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-red-500 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">Dinner at Joe's</p>
                                    <p class="text-xs text-gray-400">Alex paid • 2h ago</p>
                                </div>
                                <span class="text-sm font-semibold text-red-400">-$18.50</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">Uber to Airport</p>
                                    <p class="text-xs text-gray-400">Maria paid • 1d ago</p>
                                </div>
                                <span class="text-sm font-semibold text-red-400">-$12.00</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">Tom settled up</p>
                                    <p class="text-xs text-gray-400">via Venmo • 2d ago</p>
                                </div>
                                <span class="text-sm font-semibold text-green-400">+$45.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating mini cards -->
                    <div class="floating-card absolute -top-8 -right-6 glass rounded-2xl p-4 w-44">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-7 h-7 rounded-lg bg-brand-500/30 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-white">Hawaii Trip</span>
                        </div>
                        <p class="text-xl font-bold text-white stat-number">$1,240</p>
                        <p class="text-xs text-gray-400">5 members</p>
                    </div>

                    <div class="floating-card absolute -bottom-6 -left-8 glass rounded-2xl p-4 w-48">
                        <p class="text-xs text-gray-400 mb-1">Bill Due</p>
                        <p class="text-sm font-semibold text-white">Netflix • Jun 15</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-lg font-bold text-white stat-number">$17.99</span>
                            <span class="text-xs bg-orange-500/20 text-orange-400 px-2 py-0.5 rounded-full font-medium">Due Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== STATS BAR ========== -->
    <section class="bg-brand-900/50 border-y border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-white stat-number">$2.4M+</p>
                    <p class="text-sm text-gray-400 mt-1">Expenses tracked</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-white stat-number">10K+</p>
                    <p class="text-sm text-gray-400 mt-1">Active users</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-white stat-number">50K+</p>
                    <p class="text-sm text-gray-400 mt-1">Groups created</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-extrabold text-white stat-number">99.9%</p>
                    <p class="text-sm text-gray-400 mt-1">Uptime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FEATURES ========== -->
    <section id="features" class="py-24 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16">
                <span class="inline-block text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Everything you need</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4">Powerful features, <span class="gradient-text">zero complexity</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">From splitting a pizza to managing a year-long trip budget — Fendo handles it all beautifully.</p>
            </div>

            <!-- Feature Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Feature 1 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-brand-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-brand-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 7h16a2 2 0 010 14H4a2 2 0 010-14z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Smart Bill Splitting</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Split equally, by percentage, custom amounts, shares, or even itemize individual line items from the receipt.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-purple-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Receipt OCR Scanning</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Point your camera at a receipt. Fendo auto-extracts the merchant name, date, total, and line items instantly.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-green-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-green-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Spending Insights</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Beautiful charts showing your spending by category, group, and time period. Export as PDF, CSV, or JSON.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-orange-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-orange-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Bill Reminders</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Set recurring bills for rent, Netflix, utilities. Get reminders 1, 3, or 7 days before due. Never miss a payment.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-cyan-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Real-Time Sync</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Balances update instantly across all devices via WebSocket. Everyone in the group sees changes live.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-pink-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Multi-Currency</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Travel with friends worldwide. Log expenses in any currency with live exchange rates and automatic conversion.</p>
                </div>

                <!-- Feature 7 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-yellow-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-yellow-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728M15.536 8.464a5 5 0 010 7.072M6.343 6.343a9 9 0 000 12.728m2.829-2.829a5 5 0 000-7.07"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Offline Mode</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">No internet? No problem. Add expenses offline and they'll sync automatically when you reconnect.</p>
                </div>

                <!-- Feature 8 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-indigo-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Settle Up Fast</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">One tap to settle up via Venmo, PayPal, Cash App, or Zelle. Deep links open payment apps pre-filled.</p>
                </div>

                <!-- Feature 9 -->
                <div class="feature-card bg-gray-900 border border-white/5 rounded-2xl p-6 hover:border-teal-500/40">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Group Management</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Create groups for any occasion — apartment, vacation, family, events. Invite via link, QR code, or contacts.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ========== HOW IT WORKS ========== -->
    <section id="how-it-works" class="py-24 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Simple process</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4">Up and running in <span class="gradient-text">3 steps</span></h2>
                <p class="text-gray-400 text-lg max-w-xl mx-auto">No complicated setup. Just create a group, add expenses, and let Fendo handle the math.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Step 1 -->
                <div class="relative text-center step-line">
                    <div class="relative inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-btn shadow-xl mb-6 mx-auto">
                        <span class="text-2xl font-extrabold text-white">1</span>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-400 rounded-full border-2 border-gray-900"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Create a Group</h3>
                    <p class="text-gray-400 leading-relaxed">Set up a group for any occasion — apartment, trip, or dinner. Invite friends via link, QR code, or contacts.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center step-line">
                    <div class="relative inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-xl mb-6 mx-auto">
                        <span class="text-2xl font-extrabold text-white">2</span>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-400 rounded-full border-2 border-gray-900"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Add Expenses</h3>
                    <p class="text-gray-400 leading-relaxed">Log expenses manually or scan receipts with OCR. Choose how to split: equally, by percentage, or itemized.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center">
                    <div class="relative inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-teal-500 shadow-xl mb-6 mx-auto">
                        <span class="text-2xl font-extrabold text-white">3</span>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-400 rounded-full border-2 border-gray-900"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Settle Up</h3>
                    <p class="text-gray-400 leading-relaxed">See exactly who owes what. Settle with one tap via Venmo, PayPal, or cash. Balances update in real time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SPLITTING ENGINE ========== -->
    <section id="splitting" class="py-24 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left -->
                <div>
                    <span class="inline-block text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Splitting Engine</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-6">Split any way <span class="gradient-text">you want</span></h2>
                    <p class="text-gray-400 text-lg mb-8 leading-relaxed">Fendo's powerful splitting engine supports 5 methods so every situation is covered perfectly.</p>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-gray-900 rounded-2xl border border-white/5 hover:border-brand-500/30 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-brand-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Equal Split</h4>
                                <p class="text-sm text-gray-400 mt-0.5">Divide equally among selected participants. Remainder pennies handled automatically.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-gray-900 rounded-2xl border border-white/5 hover:border-purple-500/30 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-purple-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Percentage Split</h4>
                                <p class="text-sm text-gray-400 mt-0.5">Assign custom percentages that must sum to 100%. Perfect for unequal contributions.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-gray-900 rounded-2xl border border-white/5 hover:border-green-500/30 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Custom Amount</h4>
                                <p class="text-sm text-gray-400 mt-0.5">Enter the exact dollar amount each person owes. Live validation ensures amounts sum correctly.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-gray-900 rounded-2xl border border-white/5 hover:border-orange-500/30 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-orange-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Shares-Based</h4>
                                <p class="text-sm text-gray-400 mt-0.5">Assign shares to each person. Great for hotel rooms where someone gets a bigger room.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-gray-900 rounded-2xl border border-white/5 hover:border-pink-500/30 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-pink-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Itemized Split</h4>
                                <p class="text-sm text-gray-400 mt-0.5">Assign individual receipt line items to specific people. Alice gets the steak, Bob gets the salad.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Debt simplification illustration -->
                <div class="space-y-4">
                    <div class="glass rounded-3xl p-6 border border-white/10">
                        <p class="text-sm font-semibold text-brand-400 uppercase tracking-wider mb-4">Debt Simplification</p>
                        <p class="text-gray-400 text-sm mb-5">Fendo automatically simplifies complex debts so fewer payments are needed.</p>

                        <div class="space-y-4">
                            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                                <p class="text-xs text-red-400 font-medium mb-2 uppercase tracking-wider">Without Fendo</p>
                                <div class="space-y-2 text-sm text-gray-300">
                                    <div class="flex items-center justify-between">
                                        <span>Alex → Maria</span>
                                        <span class="text-red-400 font-semibold">$40</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Maria → Tom</span>
                                        <span class="text-red-400 font-semibold">$40</span>
                                    </div>
                                    <div class="flex items-center justify-between text-gray-500 text-xs">
                                        <span>= 2 transactions needed</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center">
                                <div class="flex items-center space-x-2">
                                    <div class="h-px w-8 bg-brand-500"></div>
                                    <span class="text-brand-400 text-xs font-bold uppercase tracking-wider">Simplified</span>
                                    <div class="h-px w-8 bg-brand-500"></div>
                                </div>
                            </div>

                            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4">
                                <p class="text-xs text-green-400 font-medium mb-2 uppercase tracking-wider">With Fendo</p>
                                <div class="space-y-2 text-sm text-gray-300">
                                    <div class="flex items-center justify-between">
                                        <span>Alex → Tom</span>
                                        <span class="text-green-400 font-semibold">$40</span>
                                    </div>
                                    <div class="flex items-center justify-between text-gray-500 text-xs">
                                        <span>= 1 transaction needed ✓</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Use case badges -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="glass rounded-xl p-4 text-center border border-white/10">
                            <div class="text-2xl mb-2">🏠</div>
                            <p class="text-sm font-semibold text-white">Apartment</p>
                            <p class="text-xs text-gray-400 mt-0.5">Rent & utilities</p>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-white/10">
                            <div class="text-2xl mb-2">✈️</div>
                            <p class="text-sm font-semibold text-white">Travel</p>
                            <p class="text-xs text-gray-400 mt-0.5">Trips & vacations</p>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-white/10">
                            <div class="text-2xl mb-2">🍕</div>
                            <p class="text-sm font-semibold text-white">Dining</p>
                            <p class="text-xs text-gray-400 mt-0.5">Restaurant bills</p>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-white/10">
                            <div class="text-2xl mb-2">👨‍👩‍👧‍👦</div>
                            <p class="text-sm font-semibold text-white">Family</p>
                            <p class="text-xs text-gray-400 mt-0.5">Household expenses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== TESTIMONIALS ========== -->
    <section class="py-24 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Testimonials</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Loved by thousands of <span class="gradient-text">real users</span></h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center space-x-1 mb-3">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">"Fendo completely changed how our apartment handles shared expenses. No more awkward money conversations — everyone can see what's owed in real time."</p>
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-400 to-red-500"></div>
                        <div>
                            <p class="text-sm font-semibold text-white">Sarah K.</p>
                            <p class="text-xs text-gray-400">College student, NYC</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center space-x-1 mb-3">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">"We used Fendo for our 2-week Europe trip with 8 people and 12 different currencies. The auto-conversion and itemized splitting saved us hours of spreadsheet work."</p>
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500"></div>
                        <div>
                            <p class="text-sm font-semibold text-white">Marcus T.</p>
                            <p class="text-xs text-gray-400">Travel blogger, London</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center space-x-1 mb-3">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">"The receipt scanner is incredibly accurate. I just point my phone and it fills everything in automatically. The bill reminder feature keeps our whole team accountable."</p>
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-teal-500"></div>
                        <div>
                            <p class="text-sm font-semibold text-white">Priya M.</p>
                            <p class="text-xs text-gray-400">Team lead, Singapore</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== PRICING ========== -->
    <section id="pricing" class="py-24 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Pricing</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Simple, <span class="gradient-text">transparent pricing</span></h2>
                <p class="text-gray-400 text-lg">Start free. Upgrade when you need more power.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Free -->
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-8">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Free</p>
                    <div class="flex items-end space-x-1 mb-1">
                        <span class="text-4xl font-extrabold text-white">$0</span>
                        <span class="text-gray-400 mb-1">/month</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-6">Perfect for getting started</p>
                    <a href="#" class="block text-center w-full border border-white/10 hover:border-brand-500/50 text-white font-semibold py-3 rounded-xl transition-colors mb-6">Download App</a>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Up to 3 groups</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Equal & custom splits</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Basic bill tracking</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Activity feed</span></li>
                    </ul>
                </div>

                <!-- Pro (Popular) -->
                <div class="relative bg-gray-900 border-2 border-brand-500 rounded-2xl p-8 shadow-2xl shadow-brand-500/20">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="gradient-btn text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">Most Popular</span>
                    </div>
                    <p class="text-sm font-semibold text-brand-400 uppercase tracking-wider mb-2">Pro</p>
                    <div class="flex items-end space-x-1 mb-1">
                        <span class="text-4xl font-extrabold text-white">$4</span>
                        <span class="text-gray-400 mb-1">/month</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-6">For active groups & travelers</p>
                    <a href="#" class="gradient-btn block text-center w-full text-white font-bold py-3 rounded-xl shadow-lg mb-6">Download App</a>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Unlimited groups</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>All 5 split methods</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Receipt OCR scanning</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Multi-currency support</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Spending insights & charts</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>PDF/CSV export</span></li>
                    </ul>
                </div>

                <!-- Business -->
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-8">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Business</p>
                    <div class="flex items-end space-x-1 mb-1">
                        <span class="text-4xl font-extrabold text-white">$12</span>
                        <span class="text-gray-400 mb-1">/month</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-6">For teams & organizations</p>
                    <a href="#" class="block text-center w-full border border-white/10 hover:border-brand-500/50 text-white font-semibold py-3 rounded-xl transition-colors mb-6">Contact Sales</a>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Everything in Pro</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Admin dashboard</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Audit logs</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Priority support</span></li>
                        <li class="flex items-center space-x-2"><svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Custom branding</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA ========== -->
    <section class="py-24 gradient-hero relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-brand-500 rounded-full opacity-10 blur-3xl pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-6">
                Ready to stop <span class="gradient-text">stressing</span> about shared expenses?
            </h2>
            <p class="text-gray-400 text-xl mb-10 max-w-2xl mx-auto">Join thousands of users who've made splitting bills effortless. Free to start, no credit card required.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="gradient-btn text-white font-bold px-10 py-4 rounded-2xl text-lg shadow-2xl flex items-center justify-center space-x-2">
                    <span>Download App</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </a>
                <!-- App Store Buttons -->
                <div class="flex gap-3 justify-center">
                    <a href="#" class="glass flex items-center space-x-2 px-5 py-4 rounded-2xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                        <div class="text-left">
                            <p class="text-xs text-gray-400 leading-none">Download on the</p>
                            <p class="text-sm font-semibold text-white leading-tight">App Store</p>
                        </div>
                    </a>
                    <a href="#" class="glass flex items-center space-x-2 px-5 py-4 rounded-2xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.27.15.58.19.88.14l12.11-12.11-2.76-2.76L3.18 23.76zm16.17-13.01L16.5 9l-3.35 1.93 3.35 3.35 2.85-1.64c.81-.47.81-1.65 0-2.09zM2.38.25C2.1.53 2 .93 2 1.36v21.28c0 .43.1.83.38 1.11l.06.06L14.56 12 2.44.19l-.06.06zm12.12 11.09L3.18.34C2.88.29 2.57.33 2.3.48l10.47 10.47 1.73-.61z"/></svg>
                        <div class="text-left">
                            <p class="text-xs text-gray-400 leading-none">Get it on</p>
                            <p class="text-sm font-semibold text-white leading-tight">Google Play</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-gray-950 border-t border-white/5 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-9 h-9 rounded-xl gradient-btn flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Fendo</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">The smartest way to track shared expenses, split bills, and settle up with friends, family, and roommates.</p>
                    <div class="flex space-x-3 mt-5">
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Product</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Changelog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Roadmap</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Company</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Legal</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">GDPR</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Fendo by JAPS Tech. All rights reserved.</p>
                <div class="flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                        <span>All systems operational</span>
                    </span>
                    <span>·</span>
                    <span>v1.0.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========== SCRIPTS ========== -->
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) {
                navbar.classList.add('nav-scrolled');
            } else {
                navbar.classList.remove('nav-scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    </script>

</body>
</html>
