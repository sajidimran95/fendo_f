<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Fendo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        body { margin: 0; min-height: 100vh; display: flex; background: #0a0a0f; }

        /* ── Left panel ── */
        .left-panel {
            background: linear-gradient(145deg, #1a1040 0%, #0f0c29 40%, #1e1060 100%);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
            top: -150px; left: -150px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,.2) 0%, transparent 70%);
            bottom: -100px; right: -100px;
        }

        /* ── Input styling ── */
        .form-input {
            width: 100%;
            background: #18181b;
            border: 1.5px solid #27272a;
            border-radius: 10px;
            color: #f4f4f5;
            font-size: 14px;
            padding: 11px 14px 11px 40px;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-input::placeholder { color: #52525b; }
        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }

        /* ── Button ── */
        .btn-sign-in {
            width: 100%;
            background: #6366f1;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            border: none;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            letter-spacing: .01em;
        }
        .btn-sign-in:hover {
            background: #4f46e5;
            box-shadow: 0 8px 24px rgba(99,102,241,.35);
            transform: translateY(-1px);
        }
        .btn-sign-in:active { transform: translateY(0); }

        /* ── Feature pill ── */
        .feature-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 12px;
            padding: 12px 16px;
        }
        .feature-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ── Custom checkbox ── */
        .check-box {
            width: 16px; height: 16px;
            background: #18181b;
            border: 1.5px solid #3f3f46;
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .15s, border-color .15s;
        }
        #remember:checked + label .check-box {
            background: #6366f1;
            border-color: #6366f1;
        }

        /* divider */
        .divider { height: 1px; background: #27272a; }

        @media (max-width: 1023px) {
            .left-panel { display: none; }
        }
    </style>
</head>
<body>

    <!-- ══════════════════════ LEFT BRANDING PANEL ══════════════════════ -->
    <div class="left-panel hidden lg:flex flex-col justify-between w-[520px] flex-shrink-0 p-10 relative z-10">

        <!-- Top: Logo -->
        <div class="flex items-center space-x-3">
            <div style="width:38px;height:38px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span style="color:#fff;font-weight:700;font-size:18px;letter-spacing:-.01em;">Fendo</span>
        </div>

        <!-- Middle: Hero text + features -->
        <div>
            <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(99,102,241,.12);border:1px solid rgba(99,102,241,.25);border-radius:100px;padding:5px 12px;margin-bottom:24px;">
                <span style="width:6px;height:6px;background:#6366f1;border-radius:50%;display:inline-block;"></span>
                <span style="color:#a5b4fc;font-size:12px;font-weight:500;">Shared Expense Management</span>
            </div>

            <h2 style="color:#fff;font-size:32px;font-weight:800;line-height:1.2;letter-spacing:-.02em;margin-bottom:12px;">
                Split bills.<br>Track expenses.<br>
                <span style="background:linear-gradient(135deg,#818cf8,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Stay friends.</span>
            </h2>
            <p style="color:#71717a;font-size:14px;line-height:1.7;margin-bottom:36px;max-width:340px;">
                The smartest way to manage shared expenses with groups, friends, family, and roommates.
            </p>

            <!-- Feature list -->
            <div style="display:flex;flex-direction:column;gap:10px;">
                <div class="feature-pill">
                    <div class="feature-icon" style="background:rgba(99,102,241,.15);">
                        <svg width="18" height="18" fill="none" stroke="#818cf8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 7h16a2 2 0 010 14H4a2 2 0 010-14z"/></svg>
                    </div>
                    <div>
                        <p style="color:#e4e4e7;font-size:13px;font-weight:600;margin:0 0 2px;">5 Split Methods</p>
                        <p style="color:#52525b;font-size:12px;margin:0;">Equal, percentage, itemized & more</p>
                    </div>
                </div>
                <div class="feature-pill">
                    <div class="feature-icon" style="background:rgba(16,185,129,.12);">
                        <svg width="18" height="18" fill="none" stroke="#34d399" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <p style="color:#e4e4e7;font-size:13px;font-weight:600;margin:0 0 2px;">Real-Time Sync</p>
                        <p style="color:#52525b;font-size:12px;margin:0;">Balances update instantly for everyone</p>
                    </div>
                </div>
                <div class="feature-pill">
                    <div class="feature-icon" style="background:rgba(245,158,11,.12);">
                        <svg width="18" height="18" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p style="color:#e4e4e7;font-size:13px;font-weight:600;margin:0 0 2px;">Receipt OCR</p>
                        <p style="color:#52525b;font-size:12px;margin:0;">Scan & auto-fill expense details</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom: Testimonial -->
        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:16px 18px;">
            <p style="color:#a1a1aa;font-size:13px;line-height:1.6;margin:0 0 12px;">"Fendo completely changed how our group handles shared expenses. No more awkward money conversations."</p>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#ef4444);flex-shrink:0;"></div>
                <div>
                    <p style="color:#e4e4e7;font-size:12px;font-weight:600;margin:0;">Sarah K.</p>
                    <p style="color:#52525b;font-size:11px;margin:0;">Student, NYC</p>
                </div>
                <div style="margin-left:auto;display:flex;gap:2px;">
                    @for ($i = 0; $i < 5; $i++)
                    <svg width="12" height="12" fill="#fbbf24" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════ RIGHT FORM PANEL ══════════════════════ -->
    <div class="flex-1 flex flex-col items-center justify-center p-6 sm:p-10" style="background:#0a0a0f;">

        <!-- Mobile logo (only on small screens) -->
        <div class="lg:hidden flex items-center space-x-2 mb-8">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span style="color:#fff;font-weight:700;font-size:18px;">Fendo</span>
        </div>

        <!-- Form card -->
        <div style="width:100%;max-width:380px;">

            <div style="margin-bottom:28px;">
                <h1 style="color:#f4f4f5;font-size:22px;font-weight:700;margin:0 0 6px;letter-spacing:-.02em;">Sign in to your account</h1>
                <p style="color:#71717a;font-size:14px;margin:0;">Enter your credentials to continue</p>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div style="display:flex;align-items:flex-start;gap:10px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:12px 14px;margin-bottom:20px;">
                    <svg width="16" height="16" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="color:#f87171;font-size:13px;">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('status'))
                <div style="display:flex;align-items:flex-start;gap:10px;background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);border-radius:10px;padding:12px 14px;margin-bottom:20px;">
                    <svg width="16" height="16" fill="none" stroke="#34d399" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span style="color:#34d399;font-size:13px;">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email field -->
                <div style="margin-bottom:16px;">
                    <label for="email" style="display:block;color:#a1a1aa;font-size:13px;font-weight:500;margin-bottom:6px;">Email address</label>
                    <div style="position:relative;">
                        <svg width="15" height="15" fill="none" stroke="#52525b" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);pointer-events:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="form-input"
                        >
                    </div>
                </div>

                <!-- Password field -->
                <div style="margin-bottom:20px;">
                    <label for="password" style="display:block;color:#a1a1aa;font-size:13px;font-weight:500;margin-bottom:6px;">Password</label>
                    <div style="position:relative;">
                        <svg width="15" height="15" fill="none" stroke="#52525b" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);pointer-events:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-input"
                            style="padding-right: 42px;"
                        >
                        <button type="button" id="togglePw" tabindex="-1" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:4px;color:#52525b;display:flex;align-items:center;" onmouseenter="this.style.color='#a1a1aa'" onmouseleave="this.style.color='#52525b'">
                            <svg id="eyeShow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eyeHide" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember me row -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} style="display:none;">
                        <label for="remember">
                            <div class="check-box" id="checkBox">
                                <svg id="checkMark" width="10" height="10" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24" style="{{ old('remember') ? '' : 'display:none;' }}"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </label>
                        <span style="color:#71717a;font-size:13px;user-select:none;">Remember me</span>
                    </label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn-sign-in">
                    Sign in
                </button>

                <!-- Divider -->
                <div style="display:flex;align-items:center;gap:12px;margin:20px 0;">
                    <div class="divider" style="flex:1;"></div>
                    <span style="color:#3f3f46;font-size:12px;">or</span>
                    <div class="divider" style="flex:1;"></div>
                </div>

                <!-- Back home -->
                <a href="{{ url('/') }}" style="display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:11px;background:transparent;border:1.5px solid #27272a;border-radius:10px;color:#71717a;font-size:13px;font-weight:500;text-decoration:none;transition:border-color .2s,color .2s;" onmouseenter="this.style.borderColor='#3f3f46';this.style.color='#a1a1aa'" onmouseleave="this.style.borderColor='#27272a';this.style.color='#71717a'">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Back to home
                </a>
            </form>

            <!-- Footer note -->
            <p style="color:#3f3f46;font-size:12px;text-align:center;margin-top:24px;line-height:1.6;">
                Don't have an account? Contact your administrator.
            </p>
        </div>

        <!-- Footer -->
        <p style="color:#27272a;font-size:11px;margin-top:40px;">© {{ date('Y') }} Fendo · JAPS Tech</p>
    </div>

    <script>
        // Password toggle
        const pw      = document.getElementById('password');
        const eyeShow = document.getElementById('eyeShow');
        const eyeHide = document.getElementById('eyeHide');

        document.getElementById('togglePw').addEventListener('click', () => {
            const isText = pw.type === 'text';
            pw.type = isText ? 'password' : 'text';
            eyeShow.style.display = isText ? 'block' : 'none';
            eyeHide.style.display = isText ? 'none'  : 'block';
        });

        // Custom checkbox
        const rememberInput = document.getElementById('remember');
        const checkBox      = document.getElementById('checkBox');
        const checkMark     = document.getElementById('checkMark');

        checkBox.addEventListener('click', () => {
            rememberInput.checked = !rememberInput.checked;
            checkBox.style.background    = rememberInput.checked ? '#6366f1' : '#18181b';
            checkBox.style.borderColor   = rememberInput.checked ? '#6366f1' : '#3f3f46';
            checkMark.style.display      = rememberInput.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>
