{{-- resources/views/users/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div style="max-width:560px">

    <div class="page-header">
        <div><h4>Profil Saya</h4><p>Kelola data dan keamanan akun Anda</p></div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom:16px">{{ session('error') }}</div>
    @endif

    {{-- Info akun --}}
    <div style="background:#0B1F3A;border-radius:14px;padding:24px;margin-bottom:20px;
                display:flex;align-items:center;gap:16px">
        <div style="width:56px;height:56px;border-radius:50%;
                    background:rgba(201,168,76,0.2);border:2px solid rgba(201,168,76,0.4);
                    display:flex;align-items:center;justify-content:center;
                    font-family:'Playfair Display',serif;font-size:20px;font-weight:600;color:#E8C97A;
                    flex-shrink:0">
            {{ $user->inisial }}
        </div>
        <div>
            <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:#fff">
                {{ $user->name }}
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);margin-top:2px">{{ $user->email }}</div>
            <div style="margin-top:6px">
                @php
                    $roleCfg = match($user->role) {
                        'admin'    => ['bg'=>'rgba(201,168,76,0.15)','color'=>'#E8C97A','label'=>'Administrator'],
                        'apoteker' => ['bg'=>'rgba(29,158,117,0.15)','color'=>'#5DCAA5','label'=>'Apoteker'],
                        default    => ['bg'=>'rgba(55,138,221,0.15)','color'=>'#85B7EB','label'=>'Kasir'],
                    };
                @endphp
                <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;
                             font-weight:500;background:{{ $roleCfg['bg'] }};color:{{ $roleCfg['color'] }}">
                    {{ $roleCfg['label'] }}
                </span>
            </div>
        </div>
        <div style="margin-left:auto;text-align:right">
            <div style="font-size:11px;color:rgba(255,255,255,0.3)">Login terakhir</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-top:2px">
                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum tercatat' }}
            </div>
        </div>
    </div>

    {{-- Edit profil --}}
    <div class="card" style="margin-bottom:16px">
        <div class="card-header-gold"><h5>Ubah Data Profil</h5></div>
        <div style="padding:1.5rem">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom:16px">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}">
                        @error('email')<div class="invalid-feedback" style="display:block;font-size:12px;color:#EF4444;margin-top:4px">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control"
                               value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
                <button type="submit" class="btn-gold">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Ganti password --}}
    <div class="card">
        <div class="card-header-gold"><h5>Ganti Password</h5></div>
        <div style="padding:1.5rem">
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-bottom:16px">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="password_lama" class="form-control"
                           placeholder="Masukkan password lama">
                    @error('password_lama')<div style="font-size:12px;color:#EF4444;margin-top:4px">{{ $message }}</div>@enderror
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
                    <div>
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter">
                        @error('password')<div style="font-size:12px;color:#EF4444;margin-top:4px">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                </div>
                <button type="submit" class="btn-gold">Ganti Password</button>
            </form>
        </div>
    </div>

</div>
@endsection
