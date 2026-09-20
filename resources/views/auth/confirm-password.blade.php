<x-guest-layout>
    <style>
        .cp-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1a1f2e;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .cp-container {
            width: 100%;
            max-width: 420px;
        }

        .cp-card {
            background-color: #1e2535;
            border-radius: 16px;
            border: 1px solid #2a3347;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .cp-accent-bar {
            height: 4px;
            width: 100%;
            background: linear-gradient(to right, #4f7ddb, #7c5cbf, #4f7ddb);
        }

        .cp-body {
            padding: 40px 32px 32px;
        }

        .cp-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }

        .cp-icon-wrap {
            position: relative;
            margin-bottom: 16px;
        }

        .cp-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: #263049;
            border: 1px solid #3a4a6b;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(79, 125, 219, 0.2);
        }

        .cp-icon-circle svg {
            width: 32px;
            height: 32px;
            color: #4f7ddb;
            stroke: #4f7ddb;
        }

        .cp-pulse {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px solid #4f7ddb;
            opacity: 0.3;
            animation: cp-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes cp-ping {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }

            75%,
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .cp-title {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 0.5px;
            margin: 0 0 8px;
        }

        .cp-subtitle {
            font-size: 13px;
            color: #8a9bbf;
            text-align: center;
            line-height: 1.6;
            margin: 0;
        }

        .cp-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #8a9bbf;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }

        .cp-input-wrap {
            position: relative;
        }

        .cp-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .cp-input-icon svg {
            width: 16px;
            height: 16px;
            stroke: #4a5a7a;
        }

        .cp-input {
            width: 100%;
            padding: 12px 44px 12px 44px;
            border-radius: 10px;
            background-color: #141929;
            color: #ffffff;
            border: 1px solid #2a3347;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .cp-input::placeholder {
            color: #4a5a7a;
        }

        .cp-input:hover {
            border-color: #3a4a6b;
        }

        .cp-input:focus {
            border-color: #4f7ddb;
            box-shadow: 0 0 0 3px rgba(79, 125, 219, 0.2);
        }

        .cp-toggle-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .cp-toggle-btn svg {
            width: 16px;
            height: 16px;
            stroke: #4a5a7a;
            transition: stroke 0.2s;
        }

        .cp-toggle-btn:hover svg {
            stroke: #4f7ddb;
        }

        .cp-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .cp-error svg {
            width: 14px;
            height: 14px;
            fill: #f87171;
            flex-shrink: 0;
        }

        .cp-error p {
            font-size: 12px;
            color: #f87171;
            margin: 0;
        }

        .cp-submit-btn {
            width: 100%;
            padding: 13px 24px;
            border-radius: 10px;
            background: linear-gradient(to right, #4f7ddb, #7c5cbf);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(79, 125, 219, 0.3);
        }

        .cp-submit-btn svg {
            width: 16px;
            height: 16px;
            stroke: #ffffff;
        }

        .cp-submit-btn:hover {
            opacity: 0.9;
            box-shadow: 0 6px 25px rgba(79, 125, 219, 0.45);
        }

        .cp-submit-btn:active {
            transform: scale(0.98);
        }

        .cp-footer {
            padding: 0 32px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cp-divider {
            flex: 1;
            height: 1px;
            background-color: #2a3347;
        }

        .cp-footer-text {
            font-size: 10px;
            color: #4a5a7a;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .cp-footer-text svg {
            width: 12px;
            height: 12px;
            stroke: #4a5a7a;
        }
    </style>

    <div class="cp-wrapper">
        <div class="cp-container">
            <div class="cp-card">

                <div class="cp-accent-bar"></div>

                <div class="cp-body">

                    {{-- Header --}}
                    <div class="cp-header">
                        <div class="cp-icon-wrap">
                            <div class="cp-icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <span class="cp-pulse"></span>
                        </div>
                        <h2 class="cp-title">Konfirmasi Kata Sandi</h2>
                        <p class="cp-subtitle">Ini adalah area aman. Harap konfirmasi kata sandi Anda sebelum
                            melanjutkan.</p>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div>
                            <label for="password" class="cp-label">Kata Sandi</label>

                            <div class="cp-input-wrap">
                                <span class="cp-input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </span>

                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password" placeholder="Masukkan kata sandi Anda"
                                    class="cp-input" />

                                <button type="button" onclick="togglePassword()" class="cp-toggle-btn" tabindex="-1">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            @if ($errors->get('password'))
                                <div class="cp-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @foreach ($errors->get('password') as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="cp-submit-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Konfirmasi & Lanjutkan
                        </button>
                    </form>

                </div>

                {{-- Footer --}}
                <div class="cp-footer">
                    <div class="cp-divider"></div>
                    <span class="cp-footer-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Sistem Farmasi · Klinik Yos Benito
                    </span>
                    <div class="cp-divider"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</x-guest-layout>
