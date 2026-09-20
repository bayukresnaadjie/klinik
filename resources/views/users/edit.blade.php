@extends('layouts.app')

@section('title', 'Edit User — ' . $user->name)
@section('page-title', 'Edit User')

@push('styles')
    <style>
        /* ── Page Header ── */
        .eu-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .eu-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .eu-back {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tx-muted);
            text-decoration: none;
            flex-shrink: 0;
            transition: border-color .15s, color .15s, box-shadow .15s;
        }

        .eu-back:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
        }

        .eu-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .eu-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .eu-role-badge {
            font-size: 11px;
            padding: 4px 11px;
            border-radius: 20px;
            background: rgba(245, 166, 35, .1);
            color: #92400E;
            font-weight: 600;
            border: 1px solid rgba(245, 166, 35, .25);
        }

        /* ── Grid ── */
        .eu-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start;
        }

        @media (max-width: 840px) {
            .eu-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Card ── */
        .eu-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .eu-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
        }

        .eu-card-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eu-card-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .eu-card-icon.yellow {
            background: #FEF3C7;
            color: #B45309;
        }

        .eu-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .eu-card-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .eu-card-body {
            padding: 18px;
        }

        /* ── Profile Preview ── */
        .eu-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
            margin-bottom: 18px;
        }

        .eu-avatar-lg {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--sb-accent, #F5A623), #f97316);
            color: #412402;
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eu-profile-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .eu-profile-email {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .eu-profile-role {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 5px;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            background: rgba(245, 166, 35, .1);
            color: #92400E;
            font-weight: 600;
            border: 1px solid rgba(245, 166, 35, .2);
        }

        /* ── Form fields ── */
        .eu-field {
            margin-bottom: 14px;
        }

        .eu-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            margin-bottom: 5px;
            letter-spacing: .02em;
        }

        .eu-req {
            color: var(--clr-red);
            font-size: 10px;
        }

        .eu-input {
            width: 100%;
            padding: 8px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            -webkit-appearance: none;
        }

        .eu-input:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        .eu-input::placeholder {
            color: var(--tx-sub);
        }

        .eu-input:disabled {
            background: var(--page-bg);
            opacity: .7;
            cursor: not-allowed;
        }

        .eu-input.is-invalid {
            border-color: var(--clr-red);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .08);
        }

        select.eu-input {
            cursor: pointer;
        }

        .eu-error {
            font-size: 11px;
            color: var(--clr-red);
            margin-top: 4px;
        }

        /* ── Disabled note ── */
        .eu-disabled-note {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 7px;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
        }

        /* ── Warning box ── */
        .eu-warn {
            display: flex;
            gap: 9px;
            padding: 11px 13px;
            border-radius: var(--radius-sm);
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            margin-bottom: 16px;
            font-size: 12px;
            color: #92400E;
            line-height: 1.6;
        }

        .eu-warn svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ── Buttons ── */
        .eu-btn {
            width: 100%;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: opacity .15s, box-shadow .15s, transform .1s;
            margin-top: 4px;
        }

        .eu-btn:active {
            transform: scale(0.985);
        }

        .eu-btn-primary {
            background: var(--clr-blue);
            color: #fff;
        }

        .eu-btn-primary:hover {
            opacity: .88;
            box-shadow: 0 4px 14px rgba(59, 130, 246, .3);
        }

        .eu-btn-danger {
            background: var(--clr-red);
            color: #fff;
        }

        .eu-btn-danger:hover {
            opacity: .88;
            box-shadow: 0 4px 14px rgba(239, 68, 68, .3);
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="eu-header">
        <div class="eu-header-left">
            <a href="{{ route('users.index') }}" class="eu-back" title="Kembali">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </a>
            <div>
                <div class="eu-title">Edit User</div>
                <div class="eu-sub">Ubah data akun {{ $user->name }}</div>
            </div>
        </div>
        <span class="eu-role-badge">{{ ucfirst($user->role) }}</span>
    </div>

    {{-- Cards Grid --}}
    <div class="eu-grid">

        {{-- ── Card 1: Data Akun ── --}}
        <div class="eu-card">
            <div class="eu-card-header">
                <div class="eu-card-icon blue">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div>
                    <div class="eu-card-title">Data Akun</div>
                    <div class="eu-card-sub">Informasi profil pengguna</div>
                </div>
            </div>
            <div class="eu-card-body">

                {{-- Profile preview --}}
                <div class="eu-profile">
                    <div class="eu-avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <div class="eu-profile-name">{{ $user->name }}</div>
                        <div class="eu-profile-email">{{ $user->email }}</div>
                        <div class="eu-profile-role">✦ {{ ucfirst($user->role) }}</div>
                    </div>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="eu-field">
                        <label class="eu-label" for="name">
                            Nama Lengkap <span class="eu-req">*</span>
                        </label>
                        <input id="name" name="name" type="text"
                            class="eu-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="eu-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="eu-field">
                        <label class="eu-label" for="email">
                            Email <span class="eu-req">*</span>
                        </label>
                        <input id="email" name="email" type="email"
                            class="eu-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="eu-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="eu-field">
                        <label class="eu-label" for="phone">No. HP</label>
                        <input id="phone" name="phone" type="text"
                            class="eu-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            value="{{ old('phone', $user->phone ?? '') }}" placeholder="08xx-xxxx-xxxx">
                        @error('phone')
                            <div class="eu-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="eu-field">
                        <label class="eu-label" for="role">
                            Role <span class="eu-req">*</span>
                        </label>
                        @if ($user->id === auth()->id())
                            <input type="text" class="eu-input" value="{{ ucfirst($user->role) }}" disabled>
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <div class="eu-disabled-note">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Tidak bisa mengubah role akun sendiri.
                            </div>
                        @else
                            <select id="role" name="role"
                                class="eu-input {{ $errors->has('role') ? 'is-invalid' : '' }}">
                                <option value="administrator"
                                    {{ old('role', $user->role) === 'administrator' ? 'selected' : '' }}>Administrator
                                </option>
                                <option value="apoteker"
                                    {{ old('role', $user->role) === 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                                <option value="kasir"
                                    {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <div class="eu-error">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <button type="submit" class="eu-btn eu-btn-primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>

            </div>
        </div>

        {{-- ── Card 2: Reset Password ── --}}
        <div class="eu-card">
            <div class="eu-card-header">
                <div class="eu-card-icon yellow">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <div>
                    <div class="eu-card-title">Reset Password</div>
                    <div class="eu-card-sub">Kosongkan jika tidak ingin mengubah</div>
                </div>
            </div>
            <div class="eu-card-body">

                <div class="eu-warn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg>
                    <span>
                        Password baru minimal <strong>8 karakter</strong>.
                        Pastikan untuk mengingat password yang baru setelah diubah.
                    </span>
                </div>

                {{-- PATCH sesuai web.php --}}
                <form action="{{ route('users.reset-password', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="eu-field">
                        <label class="eu-label" for="password">Password Baru</label>
                        <input id="password" name="password" type="password"
                            class="eu-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Min. 8 karakter" autocomplete="new-password">
                        @error('password')
                            <div class="eu-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="eu-field">
                        <label class="eu-label" for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="eu-input"
                            placeholder="Ulangi password baru" autocomplete="new-password">
                    </div>

                    <button type="submit" class="eu-btn eu-btn-danger">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Reset Password
                    </button>
                </form>

            </div>
        </div>

    </div>{{-- /eu-grid --}}

@endsection
