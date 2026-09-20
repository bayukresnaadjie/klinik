<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password — Klinik Yos Benito</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .page {
            display: flex;
            min-height: 100vh;
        }

        /* ── LEFT PANEL ── */
        .left {
            flex: 0 0 45%;
            background: #0d1b2a;
            padding: 3.5rem 3rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left-circle1 {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            border: 1px solid rgba(200, 160, 60, 0.1);
            top: -100px;
            right: -150px;
            pointer-events: none;
        }

        .left-circle2 {
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(200, 160, 60, 0.07);
            bottom: 40px;
            right: -80px;
            pointer-events: none;
        }

        .left-glow {
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 160, 60, 0.07) 0%, transparent 70%);
            top: 35%;
            left: 45%;
            pointer-events: none;
        }

        .left-badge {
            display: inline-block;
            border: 1px solid rgba(200, 160, 60, 0.5);
            color: rgba(200, 160, 60, 0.85);
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 2px;
            padding: 5px 14px;
            border-radius: 3px;
            width: fit-content;
            margin-bottom: 2rem;
        }

        .left-headline {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 46px;
            font-weight: 600;
            color: #e8e0cc;
            line-height: 1.15;
            margin-bottom: 1.2rem;
            position: relative;
        }

        .left-headline em {
            font-style: italic;
            color: #c8a03c;
        }

        .left-desc {
            font-size: 14px;
            font-weight: 300;
            color: rgba(180, 170, 150, 0.65);
            line-height: 1.75;
            margin-bottom: 3rem;
            position: relative;
        }

        .left-stats {
            display: flex;
            gap: 2rem;
            position: relative;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 500;
            color: #c8a03c;
        }

        .stat-sub {
            font-size: 11px;
            font-weight: 300;
            color: rgba(180, 170, 150, 0.5);
            margin-top: 2px;
        }

        .left-footer {
            font-size: 11px;
            color: rgba(180, 170, 150, 0.3);
            position: relative;
        }

        /* ── RIGHT PANEL ── */
        .right {
            flex: 1;
            background: #161d10;
            padding: 3rem 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2.5rem;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: #c8a03c;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 500;
            color: #e8e0cc;
        }

        .brand-sub {
            font-size: 12px;
            font-weight: 300;
            color: rgba(180, 170, 150, 0.5);
        }

        .form-heading {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 34px;
            font-weight: 600;
            color: #e8e0cc;
            margin-bottom: 0.4rem;
        }

        .form-sub {
            font-size: 13.5px;
            font-weight: 300;
            color: rgba(180, 170, 150, 0.6);
            line-height: 1.65;
            margin-bottom: 2rem;
        }

        /* Session Status */
        .alert-success {
            background: rgba(200, 160, 60, 0.08);
            border: 1px solid rgba(200, 160, 60, 0.3);
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13px;
            color: rgba(200, 160, 60, 0.9);
            margin-bottom: 1.5rem;
        }

        /* Validation Error */
        .alert-error {
            background: rgba(200, 60, 60, 0.08);
            border: 1px solid rgba(200, 60, 60, 0.3);
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13px;
            color: rgba(220, 100, 80, 0.9);
            margin-bottom: 1.5rem;
        }

        .fp-label {
            display: block;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(180, 170, 150, 0.55);
            margin-bottom: 8px;
        }

        .inp-wrap {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .inp {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(200, 160, 60, 0.2);
            border-radius: 6px;
            padding: 13px 16px 13px 46px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #e8e0cc;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .inp::placeholder {
            color: rgba(180, 170, 150, 0.3);
        }

        .inp:focus {
            border-color: rgba(200, 160, 60, 0.55);
            background: rgba(200, 160, 60, 0.04);
        }

        .inp.is-invalid {
            border-color: rgba(200, 80, 60, 0.6);
        }

        .inp-ico {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .invalid-feedback {
            font-size: 12px;
            color: rgba(220, 100, 80, 0.85);
            margin-top: 5px;
        }

        .fp-btn {
            width: 100%;
            padding: 13px;
            border-radius: 6px;
            border: none;
            background: #c8a03c;
            color: #0d1b2a;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin-bottom: 1.4rem;
        }

        .fp-btn:hover {
            opacity: 0.88;
        }

        .fp-btn:active {
            transform: scale(0.99);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.2rem;
        }

        .dl {
            flex: 1;
            height: 1px;
            background: rgba(200, 160, 60, 0.1);
        }

        .dt {
            font-size: 11px;
            color: rgba(180, 170, 150, 0.35);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(200, 160, 60, 0.65);
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #c8a03c;
        }

        .back-link svg {
            flex-shrink: 0;
        }

        .right-footer {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 11px;
            font-weight: 300;
            color: rgba(180, 170, 150, 0.28);
            line-height: 1.75;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page {
                flex-direction: column;
            }

            .left {
                flex: none;
                padding: 2rem 1.5rem;
                min-height: auto;
            }

            .left-headline {
                font-size: 32px;
            }

            .right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="page">

        {{-- ── LEFT PANEL ── --}}
        <div class="left">
            <div class="left-circle1"></div>
            <div class="left-circle2"></div>
            <div class="left-glow"></div>

            <div>
                <div class="left-badge">SISTEM FARMASI TERPADU</div>
                <h1 class="left-headline">Kelola Obat<br>dengan <em>Presisi</em></h1>
                <p class="left-desc">
                    Platform pengelolaan farmasi modern untuk Klinik Yos Benito.
                    Stok real-time, FIFO otomatis, dan monitoring kadaluarsa.
                </p>
                <div class="left-stats">
                    <div>
                        <div class="stat-label">FIFO</div>
                        <div class="stat-sub">Sistem Otomatis</div>
                    </div>
                    <div>
                        <div class="stat-label">Real-time</div>
                        <div class="stat-sub">Monitoring Stok</div>
                    </div>
                    <div>
                        <div class="stat-label">API</div>
                        <div class="stat-sub">Integrasi Kasir</div>
                    </div>
                </div>
            </div>

            <div class="left-footer">Klinik Yos Benito &copy; {{ date('Y') }}</div>
        </div>

        {{-- ── RIGHT PANEL ── --}}
        <div class="right">

            {{-- Brand --}}
            <div class="brand-row">
                <div class="brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"
                            fill="#0d1b2a" />
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Klinik Yos Benito</div>
                    <div class="brand-sub">Sistem Pengelolaan Obat</div>
                </div>
            </div>

            <h2 class="form-heading">Lupa Password?</h2>
            <p class="form-sub">Masukkan email akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label class="fp-label" for="email">Alamat Email</label>
                <div class="inp-wrap">
                    <span class="inp-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"
                                fill="rgba(200,160,60,0.55)" />
                        </svg>
                    </span>
                    <input type="email" id="email" name="email" class="inp @error('email') is-invalid @enderror"
                        placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="fp-btn">KIRIM TAUTAN RESET</button>
            </form>

            <div class="divider">
                <div class="dl"></div>
                <span class="dt">atau</span>
                <div class="dl"></div>
            </div>

            <a href="{{ route('login') }}" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42-.39-.39-1.02-.39-1.41 0l-6.59 6.59c-.39.39-.39 1.02 0 1.41l6.59 6.59c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1z"
                        fill="currentColor" />
                </svg>
                Kembali ke halaman masuk
            </a>

            <div class="right-footer">
                Klinik Yos Benito &copy; {{ date('Y') }}<br>
                Sistem Farmasi v1.0 &mdash; Hak cipta dilindungi
            </div>

        </div>
    </div>
</body>

</html>
