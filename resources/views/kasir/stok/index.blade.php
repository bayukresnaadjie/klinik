@extends('layouts.kasir')
@section('title', 'Cek Stok Obat')
@section('page-title', 'Cek Stok Obat')

@section('content')

    <form method="GET" style="margin-bottom:16px;">
        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama obat..."
            style="background:var(--bg-card); border:1px solid var(--border); border-radius:7px; padding:9px 14px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none; width:280px;">
        <button type="submit"
            style="background:var(--accent-cyan); color:#0a1a1a; font-weight:700; padding:9px 20px; border-radius:7px; border:none; cursor:pointer; font-size:13px; margin-left:8px;">
            Cari
        </button>
    </form>

    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Obat</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        No Batch</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Stok</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Kadaluarsa</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $stok)
                    @php
                        $sisa = now()->diffInDays($stok->tanggal_kadaluarsa, false);
                        $status = $sisa < 0 ? 'expired' : ($sisa <= 30 ? 'kritis' : 'aman');
                    @endphp
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px;">
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">
                                {{ $stok->varianObat->nama_merek ?? '-' }} {{ $stok->varianObat->dosis_mg ?? '' }}mg
                            </div>
                            <div style="font-size:11px; color:var(--text-muted);">
                                {{ $stok->varianObat->obat->nama_obat ?? '-' }}
                            </div>
                        </td>
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-secondary); font-family:'IBM Plex Mono',monospace;">
                            {{ $stok->no_batch ?? '-' }}
                        </td>
                        <td style="padding:12px 16px; font-size:16px; font-weight:700; color:var(--text-primary);">
                            {{ $stok->jumlah }}
                        </td>
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-secondary); font-family:'IBM Plex Mono',monospace;">
                            {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y') }}
                        </td>
                        <td style="padding:12px 16px;">
                            @if ($status === 'expired')
                                <span
                                    style="background:rgba(239,68,68,.15); color:var(--accent-red); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">EXPIRED</span>
                            @elseif($status === 'kritis')
                                <span
                                    style="background:rgba(245,158,11,.15); color:var(--accent-amber); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">KRITIS</span>
                            @else
                                <span
                                    style="background:rgba(34,197,94,.15); color:var(--accent-green); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">AMAN</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            style="padding:40px; text-align:center; color:var(--text-muted); font-size:13px;">
                            Tidak ada data stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">{{ $data->links() }}</div>

@endsection
