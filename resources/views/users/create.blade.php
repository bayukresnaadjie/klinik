{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah User Baru')
@section('page-title', 'Dashboard')

@push('styles')
    <style>
        /* ════════════════════════════════════════════════════
       TAMBAH USER — Full width, 2-col (form + panel)
       Mengikuti pola halaman Tambah Stok Obat
    ════════════════════════════════════════════════════ */

        /* ── Page header ──────────────────────────────── */
        .cu-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .cu-page-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--tx-base);
            margin: 0 0 3px;
            letter-spacing: -.3px;
        }

        .cu-page-sub {
            font-size: 12.5px;
            color: var(--tx-muted);
            margin: 0;
        }

        .cu-breadcrumb {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: var(--tx-sub);
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .cu-breadcrumb a {
            color: var(--tx-muted);
            text-decoration: none;
            transition: color .12s;
        }

        .cu-breadcrumb a:hover {
            color: var(--clr-blue);
        }

        .cu-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--tx-muted);
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 6px 14px;
            text-decoration: none;
            transition: all .15s;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: var(--shadow-card);
        }

        .cu-back-btn:hover {
            border-color: #C0C7D0;
            color: var(--tx-base);
            background: #F7F8FA;
        }

        /* ── Two-column shell ─────────────────────────── */
        .cu-shell {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ── Card ─────────────────────────────────────── */
        .cu-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .cu-card-header {
            padding: 11px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
        }

        /* ── Section ──────────────────────────────────── */
        .cu-section {
            padding: 18px;
        }

        .cu-section+.cu-section {
            border-top: 1px solid var(--border);
        }

        .cu-section-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: var(--sb-accent);
            margin-bottom: 14px;
        }

        .cu-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Form grid ────────────────────────────────── */
        .cu-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .cu-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 0;
        }

        .cu-field.full {
            grid-column: 1/-1;
        }

        .cu-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .2px;
        }

        .cu-label .req {
            color: var(--clr-red);
            margin-left: 2px;
        }

        .cu-input {
            width: 100%;
            padding: 8px 12px;
            font-size: 13px;
            color: var(--tx-base);
            background: #FAFAFA;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            outline: none;
            transition: border-color .15s, background .15s, box-shadow .15s;
            font-family: inherit;
            box-sizing: border-box;
        }

        .cu-input::placeholder {
            color: #C4CDD6;
        }

        .cu-input:hover {
            border-color: #C0C7D0;
            background: #fff;
        }

        .cu-input:focus {
            border-color: var(--sb-accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(245, 166, 35, .12);
        }

        .cu-input.is-invalid {
            border-color: var(--clr-red);
            background: #FFF5F5;
        }

        .cu-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        .cu-error {
            font-size: 11px;
            color: var(--clr-red);
            margin-top: 1px;
        }

        /* ── Password ─────────────────────────────────── */
        .cu-pw-wrap {
            position: relative;
        }

        .cu-pw-wrap .cu-input {
            padding-right: 36px;
        }

        .cu-pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #B0BBC8;
            padding: 0;
            font-size: 14px;
            line-height: 1;
            opacity: .5;
            transition: opacity .15s;
        }

        .cu-pw-toggle:hover {
            opacity: 1;
        }

        .cu-strength {
            display: flex;
            gap: 3px;
            margin-top: 5px;
        }

        .cu-strength span {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: var(--border);
            transition: background .25s;
        }

        /* ── Role cards ───────────────────────────────── */
        .cu-roles {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .cu-role-radio {
            display: none;
        }

        .cu-role-card {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 13px 10px;
            text-align: center;
            background: #FAFAFA;
            cursor: pointer;
            transition: all .15s;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }

        .cu-role-card:hover {
            border-color: #C0C7D0;
            background: #fff;
            transform: translateY(-1px);
            box-shadow: var(--shadow-hover);
        }

        .cu-role-icon {
            font-size: 20px;
            display: block;
            margin-bottom: 6px;
        }

        .cu-role-name {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--tx-base);
            margin-bottom: 2px;
        }

        .cu-role-desc {
            font-size: 10.5px;
            color: var(--tx-sub);
            line-height: 1.4;
        }

        .cu-role-badge {
            display: none;
            position: absolute;
            top: 7px;
            right: 7px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
        }

        .cu-role-badge svg {
            width: 8px;
            height: 8px;
        }

        .cu-role-card[data-active=true].cu-role--admin {
            border-color: #185FA5;
            background: #EBF4FD;
        }

        .cu-role-card[data-active=true].cu-role--admin .cu-role-name {
            color: #0C447C;
        }

        .cu-role-card[data-active=true].cu-role--admin .cu-role-badge {
            display: flex;
            background: #185FA5;
        }

        .cu-role-card[data-active=true].cu-role--apoteker {
            border-color: #0F6E56;
            background: #E4F5EF;
        }

        .cu-role-card[data-active=true].cu-role--apoteker .cu-role-name {
            color: #085041;
        }

        .cu-role-card[data-active=true].cu-role--apoteker .cu-role-badge {
            display: flex;
            background: #0F6E56;
        }

        .cu-role-card[data-active=true].cu-role--kasir {
            border-color: var(--sb-accent);
            background: #FDF6E3;
        }

        .cu-role-card[data-active=true].cu-role--kasir .cu-role-name {
            color: #7A5C1E;
        }

        .cu-role-card[data-active=true].cu-role--kasir .cu-role-badge {
            display: flex;
            background: var(--sb-accent);
        }

        /* ── Info box ─────────────────────────────────── */
        .cu-info {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            background: #FEF9EE;
            border: 1px solid rgba(245, 166, 35, .3);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            margin-top: 12px;
            font-size: 12px;
            color: #7A5C1E;
            line-height: 1.6;
            transition: all .2s;
        }

        .cu-info-icon {
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .cu-info.cu-info--admin {
            background: #EBF4FD;
            border-color: rgba(24, 95, 165, .2);
            color: #0C447C;
        }

        .cu-info.cu-info--apoteker {
            background: #E4F5EF;
            border-color: rgba(15, 110, 86, .2);
            color: #085041;
        }

        /* ── Actions ──────────────────────────────────── */
        .cu-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cu-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #D4A017, #C9A84C 50%, #B8921A);
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-family: inherit;
            transition: all .15s;
            box-shadow: 0 1px 4px rgba(201, 168, 76, .35);
        }

        .cu-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(201, 168, 76, .4);
        }

        .cu-btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            color: var(--tx-muted);
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            padding: 8px 4px;
            transition: color .15s;
        }

        .cu-btn-reset:hover {
            color: var(--tx-base);
        }

        .cu-btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 8px 4px;
            font-size: 12.5px;
            color: var(--clr-red);
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-weight: 500;
            text-decoration: none;
            margin-left: auto;
            transition: color .15s;
        }

        .cu-btn-cancel:hover {
            color: #B91C1C;
        }

        /* ── Right panel ──────────────────────────────── */
        .cu-panel {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .cu-panel-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .cu-panel-header {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .cu-panel-body {
            padding: 14px 16px;
        }

        .cu-info-placeholder {
            font-size: 12px;
            color: var(--tx-sub);
            font-style: italic;
            text-align: center;
            padding: 10px 0;
        }

        .cu-guide-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cu-guide-list li {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 12px;
            color: var(--tx-muted);
            line-height: 1.5;
        }

        .cu-guide-num {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--page-bg);
            border: 1px solid var(--border);
            font-size: 10px;
            font-weight: 700;
            color: var(--tx-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .cu-guide-tip {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 12px;
            background: #FEF9EE;
            border: 1px solid rgba(245, 166, 35, .25);
            border-radius: var(--radius-sm);
            font-size: 11.5px;
            color: #7A5C1E;
            line-height: 1.5;
            margin-top: 4px;
        }

        /* ── Responsive ───────────────────────────────── */
        @media (max-width: 960px) {
            .cu-shell {
                grid-template-columns: 1fr;
            }

            .cu-panel {
                display: none;
            }
        }

        @media (max-width: 560px) {
            .cu-grid-2 {
                grid-template-columns: 1fr;
            }

            .cu-roles {
                grid-template-columns: 1fr 1fr;
            }

            .cu-page-header {
                flex-direction: column;
            }
        }

        @media (max-width: 380px) {
            .cu-roles {
                grid-template-columns: 1fr;
            }

            .cu-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .cu-btn-cancel {
                margin-left: 0;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="cu-page-header">
        <div>
            <h1 class="cu-page-title">Tambah User Baru</h1>
            <p class="cu-page-sub">Tambah anggota tim klinik dengan akun baru</p>
        </div>
        <a href="{{ route('users.index') }}" class="cu-back-btn">← Kembali</a>
    </div>

    {{-- Breadcrumb --}}
    <div class="cu-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>›</span>
        <a href="{{ route('users.index') }}">Manajemen User</a>
        <span>›</span>
        <span style="color:var(--tx-base);font-weight:500">Tambah User</span>
    </div>

    {{-- Two-column shell --}}
    <div class="cu-shell">

        {{-- ── LEFT: Form columns ── --}}
        <div style="display:flex;flex-direction:column;gap:16px;min-width:0">
            <form action="{{ route('users.store') }}" method="POST" id="cu-form">
                @csrf

                {{-- Card 1: Informasi Akun --}}
                <div class="cu-card">
                    <div class="cu-card-header">Informasi Akun</div>
                    <div class="cu-section">
                        <div class="cu-section-label">Data Diri</div>
                        <div class="cu-grid-2">
                            <div class="cu-field">
                                <label class="cu-label">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" name="name" class="cu-input @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="cth: dr. Budi Santoso" autofocus>
                                @error('name')
                                    <div class="cu-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="cu-field">
                                <label class="cu-label">No. HP</label>
                                <input type="text" name="no_hp" class="cu-input @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx">
                                @error('no_hp')
                                    <div class="cu-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="cu-field full">
                                <label class="cu-label">Alamat Email <span class="req">*</span></label>
                                <input type="email" name="email" class="cu-input @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="email@klinik.com">
                                @error('email')
                                    <div class="cu-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Role --}}
                <div class="cu-card">
                    <div class="cu-card-header">Role / Jabatan</div>
                    <div class="cu-section">
                        <div class="cu-section-label">Pilih Akses</div>
                        <div class="cu-roles">
                            @foreach ([
            'admin' => ['icon' => '🔑', 'name' => 'Admin', 'desc' => 'Akses penuh semua fitur'],
            'apoteker' => ['icon' => '💊', 'name' => 'Apoteker', 'desc' => 'Kelola obat & stok'],
            'kasir' => ['icon' => '🧾', 'name' => 'Kasir', 'desc' => 'Transaksi penjualan'],
        ] as $role => $cfg)
                                <label style="cursor:pointer;display:block">
                                    <input type="radio" name="role" value="{{ $role }}"
                                        {{ old('role', 'kasir') === $role ? 'checked' : '' }} class="cu-role-radio"
                                        id="role-{{ $role }}">
                                    <div class="cu-role-card cu-role--{{ $role }}" data-role="{{ $role }}"
                                        data-active="{{ old('role', 'kasir') === $role ? 'true' : 'false' }}">
                                        <span class="cu-role-icon">{{ $cfg['icon'] }}</span>
                                        <div class="cu-role-name">{{ $cfg['name'] }}</div>
                                        <div class="cu-role-desc">{{ $cfg['desc'] }}</div>
                                        <div class="cu-role-badge">
                                            <svg viewBox="0 0 9 9" fill="none">
                                                <path d="M1.5 4.5L3.5 6.5L7.5 2.5" stroke="#fff" stroke-width="1.6"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('role')
                            <div class="cu-error" style="margin-top:6px">{{ $message }}</div>
                        @enderror
                        <div class="cu-info" id="cu-info-box">
                            <span class="cu-info-icon" id="cu-info-icon">🧾</span>
                            <span id="cu-info-text"></span>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Password --}}
                <div class="cu-card">
                    <div class="cu-card-header">Keamanan Akun</div>
                    <div class="cu-section">
                        <div class="cu-section-label">Password</div>
                        <div class="cu-grid-2">
                            <div class="cu-field">
                                <label class="cu-label">Password <span class="req">*</span></label>
                                <div class="cu-pw-wrap">
                                    <input type="password" name="password" id="cu-pw1"
                                        class="cu-input @error('password') is-invalid @enderror"
                                        placeholder="Min. 8 karakter" oninput="cuStrength(this.value)">
                                    <button type="button" class="cu-pw-toggle"
                                        onclick="cuTogglePw('cu-pw1',this)">👁</button>
                                </div>
                                <div class="cu-strength">
                                    <span id="cs1"></span><span id="cs2"></span>
                                    <span id="cs3"></span><span id="cs4"></span>
                                </div>
                                @error('password')
                                    <div class="cu-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="cu-field">
                                <label class="cu-label">Konfirmasi Password <span class="req">*</span></label>
                                <div class="cu-pw-wrap">
                                    <input type="password" name="password_confirmation" id="cu-pw2" class="cu-input"
                                        placeholder="Ulangi password">
                                    <button type="button" class="cu-pw-toggle"
                                        onclick="cuTogglePw('cu-pw2',this)">👁</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Actions --}}
                <div class="cu-card">
                    <div class="cu-section">
                        <div class="cu-actions">
                            <button type="submit" class="cu-btn-submit">✓ &nbsp;Simpan User</button>
                            <button type="button" class="cu-btn-reset"
                                onclick="document.getElementById('cu-form').reset();cuUpdateRole();">
                                ↺ Reset
                            </button>
                            <a href="{{ route('users.index') }}" class="cu-btn-cancel">Batal</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        {{-- ── RIGHT: Info Panel ── --}}
        <div class="cu-panel">

            <div class="cu-panel-card">
                <div class="cu-panel-header">Info Role Dipilih</div>
                <div class="cu-panel-body">
                    <div id="cu-panel-role">
                        <div class="cu-info-placeholder">Pilih role terlebih dahulu</div>
                    </div>
                </div>
            </div>

            <div class="cu-panel-card">
                <div class="cu-panel-header">Panduan Pengisian</div>
                <div class="cu-panel-body">
                    <ul class="cu-guide-list">
                        <li>
                            <div class="cu-guide-num">1</div>
                            <span>Isi nama lengkap sesuai identitas resmi.</span>
                        </li>
                        <li>
                            <div class="cu-guide-num">2</div>
                            <span>Email digunakan untuk login, pastikan aktif dan valid.</span>
                        </li>
                        <li>
                            <div class="cu-guide-num">3</div>
                            <span>Pilih role sesuai jabatan — hak akses mengikuti role yang dipilih.</span>
                        </li>
                        <li>
                            <div class="cu-guide-num">4</div>
                            <span>Password minimal 8 karakter, kombinasikan huruf besar, angka, dan simbol.</span>
                        </li>
                    </ul>
                    <div class="cu-guide-tip" style="margin-top:12px">
                        <span style="font-size:14px;flex-shrink:0">⚠️</span>
                        <span>Kasir hanya dapat akses halaman POS. Tidak bisa ubah data obat atau stok.</span>
                    </div>
                </div>
            </div>

        </div>

    </div>{{-- /.cu-shell --}}

    <script>
        const CU_ROLE_INFO = {
            admin: {
                cls: 'cu-info--admin',
                icon: '🔑',
                text: 'Admin dapat mengakses seluruh fitur: master data, stok, pemakaian, laporan, dan manajemen user.',
                panel: '<div style="text-align:center;padding:8px 0"><div style="font-size:28px;margin-bottom:6px">🔑</div><div style="font-size:13px;font-weight:700;color:#0C447C;margin-bottom:4px">Admin</div><div style="font-size:11.5px;color:#637080;line-height:1.5">Akses penuh semua fitur sistem termasuk manajemen user</div></div>'
            },
            apoteker: {
                cls: 'cu-info--apoteker',
                icon: '💊',
                text: 'Apoteker dapat mengelola master data obat, input stok batch, dan catat pemakaian. Tidak bisa kelola user.',
                panel: '<div style="text-align:center;padding:8px 0"><div style="font-size:28px;margin-bottom:6px">💊</div><div style="font-size:13px;font-weight:700;color:#085041;margin-bottom:4px">Apoteker</div><div style="font-size:11.5px;color:#637080;line-height:1.5">Kelola data obat, input stok batch, catat pemakaian</div></div>'
            },
            kasir: {
                cls: '',
                icon: '🧾',
                text: 'Kasir hanya bisa akses halaman kasir (POS) untuk transaksi penjualan. Tidak bisa ubah data obat atau stok.',
                panel: '<div style="text-align:center;padding:8px 0"><div style="font-size:28px;margin-bottom:6px">🧾</div><div style="font-size:13px;font-weight:700;color:#7A5C1E;margin-bottom:4px">Kasir</div><div style="font-size:11.5px;color:#637080;line-height:1.5">Akses halaman kasir (POS) untuk transaksi penjualan saja</div></div>'
            },
        };

        function cuUpdateRole() {
            const val = document.querySelector('.cu-role-radio:checked')?.value || 'kasir';
            const cfg = CU_ROLE_INFO[val];
            document.querySelectorAll('.cu-role-card').forEach(c => {
                c.dataset.active = c.dataset.role === val ? 'true' : 'false';
            });
            const box = document.getElementById('cu-info-box');
            box.className = 'cu-info' + (cfg.cls ? ' ' + cfg.cls : '');
            document.getElementById('cu-info-icon').textContent = cfg.icon;
            document.getElementById('cu-info-text').textContent = cfg.text;
            document.getElementById('cu-panel-role').innerHTML = cfg.panel;
        }

        document.querySelectorAll('.cu-role-card').forEach(card => {
            card.addEventListener('click', () => {
                const r = document.getElementById('role-' + card.dataset.role);
                if (r) {
                    r.checked = true;
                    cuUpdateRole();
                }
            });
        });
        cuUpdateRole();

        function cuTogglePw(id, btn) {
            const inp = document.getElementById(id);
            inp.type = inp.type === 'password' ? 'text' : 'password';
            btn.style.opacity = inp.type === 'text' ? '1' : '.5';
        }

        const CU_COLORS = ['#FC8181', '#F6AD55', '#68D391', '#38A169'];

        function cuStrength(val) {
            let s = 0;
            if (val.length >= 8) s++;
            if (/[A-Z]/.test(val)) s++;
            if (/[0-9]/.test(val)) s++;
            if (/[^A-Za-z0-9]/.test(val)) s++;
            [1, 2, 3, 4].forEach(i => {
                document.getElementById('cs' + i).style.background =
                    i <= s ? CU_COLORS[s - 1] : 'rgba(11,31,58,.1)';
            });
        }
    </script>
@endsection
