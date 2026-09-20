@extends('layouts.kasir')

@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')

    <div style="margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="font-size:18px; font-weight:700;">Daftar Pembayaran</h2>
        <a href="{{ route('kasir.pembayaran.create') }}"
            style="background:var(--accent-cyan); color:#0a1a1a; font-weight:700; padding:8px 20px; border-radius:8px; font-size:13px; text-decoration:none;">
            + Pembayaran Baru
        </a>
    </div>

    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        #</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Pasien</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Total</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Status</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Waktu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" style="padding:40px; text-align:center; color:var(--text-muted); font-size:13px;">
                        Belum ada data pembayaran.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
