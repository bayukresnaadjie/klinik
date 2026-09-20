{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Klinik Yos Benito</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --navy: #0B1F3A;
            --navy-mid: #132844;
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --gold-pale: #F5EDD6;
            --cream: #FAF8F4;
            --white: #FFFFFF;
            --text-dark: #0B1F3A;
            --text-mid: #4A5568;
            --text-muted: #8A97A8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Left panel — branding */
        .left-panel {
            width: 45%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(201, 168, 76, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 80%, rgba(201, 168, 76, 0.08) 0%, transparent 60%);
        }

        /* Decorative circles */
        .deco-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(201, 168, 76, 0.12);
        }

        .deco-ring-1 {
            width: 500px;
            height: 500px;
            top: -120px;
            right: -200px;
        }

        .deco-ring-2 {
            width: 300px;
            height: 300px;
            bottom: -80px;
            left: -100px;
        }

        .deco-ring-3 {
            width: 180px;
            height: 180px;
            top: 40%;
            right: -50px;
            border-color: rgba(201, 168, 76, 0.2);
        }

        /* Cross pattern (medical) */
        .deco-cross {
            position: absolute;
            opacity: .06;
        }

        .deco-cross::before,
        .deco-cross::after {
            content: '';
            position: absolute;
            background: var(--gold);
            border-radius: 3px;
        }

        .deco-cross::before {
            width: 4px;
            height: 40px;
            top: 0;
            left: 18px;
        }

        .deco-cross::after {
            width: 40px;
            height: 4px;
            top: 18px;
            left: 0;
        }

        .deco-cross-1 {
            top: 15%;
            right: 18%;
        }

        .deco-cross-2 {
            bottom: 25%;
            left: 12%;
            transform: scale(.6);
        }

        .deco-cross-3 {
            top: 55%;
            right: 8%;
            transform: scale(.4);
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--gold);
            border: 1px solid rgba(201, 168, 76, 0.35);
            border-radius: 20px;
            padding: 5px 14px;
            margin-bottom: 24px;
        }

        .left-heading {
            font-family: 'Playfair Display', serif;
            font-size: 44px;
            font-weight: 600;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 8px;
        }

        .left-heading em {
            font-style: italic;
            color: var(--gold-light);
        }

        .left-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.6;
            max-width: 320px;
            margin-bottom: 48px;
        }

        .stat-row {
            display: flex;
            gap: 32px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--gold-light);
        }

        .stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: .05em;
        }

        .stat-divider {
            width: 1px;
            background: rgba(201, 168, 76, 0.2);
            align-self: stretch;
        }

        /* Right panel — form */
        .right-panel {
            flex: 1;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(201, 168, 76, 0.4), transparent);
        }

        .login-box {
            width: 100%;
            max-width: 420px;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }

        .logo-mark {
            width: 44px;
            height: 44px;
            background: var(--navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-mark::before,
        .logo-mark::after {
            content: '';
            position: absolute;
            background: var(--gold);
            border-radius: 2px;
        }

        .logo-mark::before {
            width: 3px;
            height: 18px;
        }

        .logo-mark::after {
            width: 18px;
            height: 3px;
        }

        .logo-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: .03em;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .login-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-mid);
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: var(--white);
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
        }

        .form-input.error {
            border-color: #EF4444;
        }

        .error-msg {
            font-size: 12px;
            color: #EF4444;
            margin-top: 5px;
        }

        /* ── Inline validation ── */
        .form-input.success {
            border-color: #22C55E;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.10);
        }

        .form-input.error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.10);
        }

        .field-hint {
            display: none;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            margin-top: 5px;
            min-height: 18px;
            transition: opacity 0.2s;
        }

        .field-hint.error {
            color: #DC2626;
        }

        .field-hint.success {
            color: #16A34A;
        }

        .field-hint.error,
        .field-hint.success {
            display: flex;
            /* muncul hanya saat ada pesan */
        }

        .field-hint.hidden {
            opacity: 0;
            pointer-events: none;
            min-height: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }

        .field-hint svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-left: 3px solid #EF4444;
            border-radius: 8px;
            font-size: 13px;
            color: #991B1B;
            margin-bottom: 20px;
        }

        .alert-error svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            color: #EF4444;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        /* ── Custom checkbox "Ingat saya" ── */
        .remember-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: var(--text-mid);
            cursor: pointer;
            user-select: none;
        }

        .check-box {
            position: relative;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .check-box input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            margin: 0;
        }

        .check-visual {
            position: absolute;
            inset: 0;
            border-radius: 5px;
            border: 1.5px solid #CBD5E1;
            background: var(--white);
            transition: border-color .18s, background .18s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .check-visual svg {
            width: 11px;
            height: 11px;
            stroke: var(--gold);
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0;
            transform: scale(0.5);
            transition: opacity .15s, transform .15s;
            pointer-events: none;
        }

        .check-box input:checked+.check-visual {
            border-color: var(--gold);
            background: rgba(201, 168, 76, 0.08);
        }

        .check-box input:checked+.check-visual svg {
            opacity: 1;
            transform: scale(1);
        }

        .check-box input:focus-visible+.check-visual {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        .remember-label:hover .check-visual {
            border-color: var(--gold);
        }

        .forgot-link {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: #8B6914;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--navy);
            color: var(--gold-light);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            letter-spacing: .04em;
            transition: background .2s, transform .1s;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.12), transparent);
            transition: left .4s;
        }

        .btn-login:hover {
            background: var(--navy-mid);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: scale(.99);
        }

        /* ── Loading state ── */
        .btn-login:disabled {
            cursor: not-allowed;
            opacity: 0.75;
        }

        .btn-login .btn-text {
            display: inline;
        }

        .btn-login .btn-loader {
            display: none;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .btn-loader {
            display: inline-flex;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(232, 201, 122, 0.3);
            border-top-color: var(--gold-light);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 20px;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        .login-divider span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .login-footer {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        .alert-error {
            padding: 12px 16px;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 8px;
            font-size: 13px;
            color: #991B1B;
            margin-bottom: 20px;
        }

        /* ── Show / hide password ── */
        .pw-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .pw-wrapper .form-input {
            padding-right: 44px;
            /* beri ruang untuk tombol */
        }

        .pw-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            padding: 4px;
            border-radius: 4px;
            transition: color .18s;
            line-height: 1;
        }

        .pw-toggle:hover {
            color: var(--navy);
        }

        .pw-toggle:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        .pw-toggle svg {
            width: 18px;
            height: 18px;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>

    {{-- Left panel --}}
    <div class="left-panel">
        <div class="deco-ring deco-ring-1"></div>
        <div class="deco-ring deco-ring-2"></div>
        <div class="deco-ring deco-ring-3"></div>
        <div class="deco-cross deco-cross-1"></div>
        <div class="deco-cross deco-cross-2"></div>
        <div class="deco-cross deco-cross-3"></div>

        <div class="left-content">
            <div class="left-badge">Sistem Farmasi Terpadu</div>
            <h1 class="left-heading">
                Kelola Obat<br>dengan <em>Presisi</em>
            </h1>
            <p class="left-sub">
                Platform pengelolaan farmasi modern untuk Klinik Yos Benito.
                Stok real-time, FIFO otomatis, dan monitoring kadaluarsa.
            </p>

            <div class="stat-row">
                <div class="stat-item">
                    <span class="stat-num">FIFO</span>
                    <span class="stat-label">Sistem Otomatis</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-num">Real-time</span>
                    <span class="stat-label">Monitoring Stok</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-num">API</span>
                    <span class="stat-label">Integrasi Kasir</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right panel — form --}}
    <div class="right-panel">
        <div class="login-box">

            <div class="login-logo">
                <div class="logo-mark"></div>
                <div class="logo-text">
                    <h2>Klinik Yos Benito</h2>
                    <p>Sistem Pengelolaan Obat</p>
                </div>
            </div>

            <h2 class="login-title">Selamat datang</h2>
            <p class="login-sub">Masuk untuk melanjutkan ke dashboard</p>
            @if (session('timeout_message'))
                <div class="alert-timeout" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span>{{ session('timeout_message') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span>Email atau password tidak sesuai. Silakan periksa kembali dan coba lagi.</span>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}" value="{{ old('email') }}"
                        placeholder="Masukkan alamat email Anda" autocomplete="email" autofocus>
                    <div class="field-hint {{ $errors->has('email') ? 'error' : 'hidden' }}" id="email-hint">
                        @if ($errors->has('email'))
                            {{-- Ikon X --}}
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            {{ $errors->first('email') }}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="password" name="password"
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="••••••••"
                            autocomplete="current-password">

                        <button type="button" id="pw-toggle" class="pw-toggle" aria-label="Tampilkan password"
                            aria-pressed="false" aria-controls="password">
                            <svg id="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg id="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"
                                style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
                         a18.45 18.45 0 0 1 5.06-5.94" />
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8
                         a18.5 18.5 0 0 1-2.16 3.19" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>
                    <div class="field-hint {{ $errors->has('password') ? 'error' : 'hidden' }}" id="password-hint">
                        @if ($errors->has('password'))
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            {{ $errors->first('password') }}
                        @endif
                    </div>
                </div>

                <div class="form-footer">
                    <label class="remember-label">
                        <span class="check-box">
                            <input type="checkbox" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="check-visual" aria-hidden="true">
                                <svg viewBox="0 0 12 12">
                                    <polyline points="2,6 5,9 10,3" />
                                </svg>
                            </span>
                        </span>
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" id="btn-login" class="btn-login">
                    <span class="btn-text">Masuk ke Dashboard</span>
                    <span class="btn-loader" aria-hidden="true">
                        <span class="spinner"></span>
                        Memverifikasi...
                    </span>
                </button>
            </form>

            <div class="login-divider"><span>Klinik Yos Benito &copy; {{ date('Y') }}</span></div>

            <div class="login-footer">
                Sistem Farmasi v1.0 &mdash; Hak cipta dilindungi
            </div>
        </div>
    </div>

    <script>
        // ── Show / hide password ──
        (function() {
            const input = document.getElementById('password');
            const btn = document.getElementById('pw-toggle');
            const eyeOn = document.getElementById('icon-eye');
            const eyeOff = document.getElementById('icon-eye-off');

            btn.addEventListener('click', function() {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                eyeOn.style.display = isHidden ? 'none' : 'block';
                eyeOff.style.display = isHidden ? 'block' : 'none';
                btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            });
        })();

        // ── Client-side inline validation ──
        (function() {
            // SVG helper: centang hijau atau silang merah
            var SVG_OK =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>';
            var SVG_ERR =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';

            function setHint(hintEl, inputEl, type, msg) {
                // reset class input
                inputEl.classList.remove('error', 'success');
                hintEl.classList.remove('error', 'success', 'hidden');

                if (type === 'error') {
                    inputEl.classList.add('error');
                    hintEl.classList.add('error');
                    hintEl.innerHTML = SVG_ERR + ' ' + msg;
                } else if (type === 'success') {
                    inputEl.classList.add('success');
                    hintEl.classList.add('success');
                    hintEl.innerHTML = SVG_OK + ' ' + msg;
                } else {
                    hintEl.classList.add('hidden');
                    hintEl.innerHTML = '';
                }
            }

            // ── Validasi EMAIL ──
            var emailInput = document.getElementById('email');
            var emailHint = document.getElementById('email-hint');

            emailInput.addEventListener('blur', function() {
                var val = emailInput.value.trim();
                if (!val) {
                    setHint(emailHint, emailInput, 'error', 'Email tidak boleh kosong.');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                    setHint(emailHint, emailInput, 'error', 'Format email tidak valid.');
                } else {
                    setHint(emailHint, emailInput, 'success', 'Format email valid.');
                }
            });

            emailInput.addEventListener('input', function() {
                // reset hint saat user mulai mengetik ulang
                if (emailInput.classList.contains('error')) {
                    setHint(emailHint, emailInput, null, '');
                }
            });

            // ── Validasi PASSWORD ──
            var pwInput = document.getElementById('password');
            var pwHint = document.getElementById('password-hint');

            pwInput.addEventListener('blur', function() {
                var val = pwInput.value;
                if (!val) {
                    setHint(pwHint, pwInput, 'error', 'Password tidak boleh kosong.');
                } else if (val.length < 6) {
                    setHint(pwHint, pwInput, 'error', 'Password minimal 6 karakter.');
                } else {
                    setHint(pwHint, pwInput, 'success', 'Password terisi.');
                }
            });

            pwInput.addEventListener('input', function() {
                if (pwInput.classList.contains('error')) {
                    setHint(pwHint, pwInput, null, '');
                }
            });
        })();

        // ── Loading state on submit ──
        (function() {
            const form = document.querySelector('form');
            const btn = document.getElementById('btn-login');

            form.addEventListener('submit', function() {
                if (!form.checkValidity()) return;

                btn.classList.add('loading');
                btn.disabled = true;

                setTimeout(function() {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                }, 8000);
            });
        })();
    </script>
</body>

</html>
