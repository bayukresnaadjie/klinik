@extends('layouts.kasir')
@section('title', 'Stok Menipis')
@section('page-title', 'Stok Menipis')

@section('content')

    <div
        style="background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.3); border-radius:10px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:var(--accent-amber);">
        ⚠ Menampilkan obat dengan stok di bawah 50 unit.
    </div>

    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Obat</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Stok</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $stok)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px;">
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">
                                {{ $stok->varianObat->nama_merek ?? '-' }} {{ $stok->varianObat->dosis_mg ?? '' }}mg
                            </div>
                            <div style="font-size:11px; color:var(--text-muted);">
                                {{ $stok->varianObat->obat->nama_obat ?? '-' }}</div>
                        </td>
                        <td style="padding:12px 16px;">
                            <span
                                style="font-size:20px; font-weight:700; color:var(--accent-red);">{{ $stok->jumlah }}</span>
                            <span style="font-size:11px; color:var(--text-muted); margin-left:4px;">unit</span>
                        </td>
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-secondary); font-family:'IBM Plex Mono',monospace;">
                            {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"
                            style="padding:40px; text-align:center; color:var(--text-muted); font-size:13px;">
                            Semua stok dalam kondisi aman. ✓
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
