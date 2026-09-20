@extends('layouts.kasir')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')

    <div style="max-width:100%;">

        <div style="margin-bottom:20px;">
            <div style="font-size:20px; font-weight:700; color:var(--text-primary);">Profil Saya</div>
            <div style="font-size:13px; color:var(--text-muted); margin-top:4px;">Kelola informasi akun dan keamanan Anda
            </div>
        </div>

        @if (session('success'))
            <div
                style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.3); color:var(--accent-green); padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:16px;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.3); color:var(--accent-red); padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:16px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start;">

            {{-- Kolom Kiri --}}
            <div style="display:flex; flex-direction:column; gap:16px;">

                {{-- Avatar & Info --}}
                <div
                    style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px; text-align:center;">
                    <div style="position:relative; display:inline-block; margin-bottom:16px;">
                        <div
                            style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,var(--accent-cyan),var(--accent-blue)); display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:700; color:#fff; margin:0 auto;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <div style="font-size:18px; font-weight:700; color:var(--text-primary);">{{ $user->name }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">{{ $user->email }}</div>
                    <div
                        style="display:inline-block; margin-top:8px; padding:3px 12px; border-radius:20px; background:rgba(0,200,200,.1); border:1px solid rgba(0,200,200,.2); font-size:11px; color:var(--accent-cyan); font-family:'IBM Plex Mono',monospace;">
                        ✦ {{ ucfirst($user->role ?? 'kasir') }}
                    </div>
                </div>

                {{-- Info Akun --}}
                <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <svg width="14" height="14" fill="none" stroke="var(--accent-cyan)" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span
                            style="font-size:11px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">Info
                            Akun</span>
                    </div>
                    <div style="font-size:12px; color:var(--text-secondary); margin-bottom:4px;">Detail akun Anda</div>

                    <div style="margin-top:16px; display:flex; flex-direction:column; gap:12px;">
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding-bottom:12px; border-bottom:1px solid var(--border);">
                            <span style="font-size:12px; color:var(--text-muted);">ID Akun</span>
                            <span
                                style="font-size:12px; font-family:'IBM Plex Mono',monospace; color:var(--text-primary);">#{{ $user->id }}</span>
                        </div>
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding-bottom:12px; border-bottom:1px solid var(--border);">
                            <span style="font-size:12px; color:var(--text-muted);">Role</span>
                            <span
                                style="font-size:12px; color:var(--accent-cyan); font-weight:600;">{{ ucfirst($user->role ?? 'kasir') }}</span>
                        </div>
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; padding-bottom:12px; border-bottom:1px solid var(--border);">
                            <span style="font-size:12px; color:var(--text-muted);">Bergabung</span>
                            <span
                                style="font-size:12px; color:var(--text-primary);">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; color:var(--text-muted);">Login Terakhir</span>
                            <span style="font-size:12px; color:var(--text-primary);">Sekarang</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan --}}
            <div style="display:flex; flex-direction:column; gap:16px;">

                {{-- Form Informasi Profil --}}
                <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        <svg width="14" height="14" fill="none" stroke="var(--accent-cyan)" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span style="font-size:13px; font-weight:600; color:var(--text-primary);">Informasi Profil</span>
                    </div>
                    <div style="font-size:12px; color:var(--text-muted); margin-bottom:20px;">Perbarui nama dan email Anda
                    </div>

                    <form method="POST" action="{{ route('kasir.profil') }}">
                        @csrf
                        @method('PUT')

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">
                                    Nama Lengkap <span style="color:var(--accent-red);">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Nama lengkap"
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            </div>
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Jabatan</label>
                                <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan ?? '') }}"
                                    placeholder="contoh: Kasir, Apoteker..."
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-secondary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;"
                                    readonly>
                                <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Email tidak dapat
                                    diubah</div>
                            </div>
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">No.
                                    Telepon</label>
                                <input type="text" name="no_telepon"
                                    value="{{ old('no_telepon', $user->no_telepon ?? '') }}"
                                    placeholder="contoh: 08123456789"
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            </div>
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:10px;">
                            <a href="{{ route('kasir.dashboard') }}"
                                style="padding:9px 20px; border-radius:7px; border:1px solid var(--border); color:var(--text-secondary); font-size:13px; text-decoration:none; font-weight:500;">
                                Batal
                            </a>
                            <button type="submit"
                                style="background:var(--accent-cyan); color:#0a1a1a; font-weight:700; padding:9px 24px; border-radius:7px; border:none; cursor:pointer; font-size:13px; font-family:'DM Sans',sans-serif; display:flex; align-items:center; gap:6px;">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Ganti Password --}}
                <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        <svg width="14" height="14" fill="none" stroke="var(--accent-amber)" stroke-width="2"
                            viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                        <span style="font-size:13px; font-weight:600; color:var(--text-primary);">Ganti Password</span>
                    </div>
                    <div style="font-size:12px; color:var(--text-muted); margin-bottom:16px;">Perbarui kata sandi akun Anda
                    </div>

                    <div
                        style="background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.2); border-radius:8px; padding:12px 14px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                        <span style="font-size:12px; color:var(--accent-amber);">⚠ Password baru minimal 8 karakter.
                            Pastikan Anda mengingat password baru setelah disimpan.</span>
                    </div>

                    <form method="POST" action="{{ route('kasir.profil') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="ganti_password" value="1">

                        <div style="margin-bottom:14px;">
                            <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">
                                Password Lama <span style="color:var(--accent-red);">*</span>
                            </label>
                            <input type="password" name="password_lama" placeholder="Masukkan password saat ini"
                                style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">
                                    Password Baru <span style="color:var(--accent-red);">*</span>
                                </label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter"
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            </div>
                            <div>
                                <label
                                    style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">
                                    Konfirmasi Password <span style="color:var(--accent-red);">*</span>
                                </label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            </div>
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:10px;">
                            <button type="submit"
                                style="background:rgba(239,68,68,.1); color:var(--accent-red); border:1px solid rgba(239,68,68,.3); font-weight:700; padding:9px 24px; border-radius:7px; cursor:pointer; font-size:13px; font-family:'DM Sans',sans-serif; display:flex; align-items:center; gap:6px;">
                                🔒 Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
