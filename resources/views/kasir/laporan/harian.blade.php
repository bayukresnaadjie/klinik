@extends('layouts.kasir')
@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Harian')

@section('content')

    {{-- Filter Tanggal --}}
    <form method="GET" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <input type="date" name="tanggal" value="{{ $tanggal }}"
            style="background:var(--bg-card); border:1px solid var(--border); border-radius:7px; padding:9px 14px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
        <button type="submit"
            style="background:var(--accent-cyan); color:#0a1a1a; font-weight:700; padding:9px 20px; border-radius:7px; border:none; cursor:pointer; font-size:13px;">
            Tampilkan
        </button>
    </form>

    {{-- Stat Cards --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px;">
        @foreach ([['label' => 'Total Resep', 'value' => $totalResep, 'unit' => 'resep', 'color' => 'var(--accent-cyan)'], ['label' => 'Selesai', 'value' => $totalSelesai, 'unit' => 'dilayani', 'color' => 'var(--accent-green)'], ['label' => 'Menunggu', 'value' => $totalMenunggu, 'unit' => 'antrian', 'color' => 'var(--accent-amber)'], ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'), 'unit' => '', 'color' => 'var(--accent-blue)']] as $card)
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:18px 20px;">
                <div
                    style="font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted); margin-bottom:10px;">
                    {{ $card['label'] }}</div>
                <div style="font-size:26px; font-weight:700; color:{{ $card['color'] }}; line-height:1;">
                    {{ $card['value'] }}</div>
                @if ($card['unit'])
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">{{ $card['unit'] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tabel Resep --}}
    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
        <div style="padding:14px 18px; border-bottom:1px solid var(--border); font-size:13px; font-weight:600;">
            Daftar Transaksi — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </div>
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
                        Status</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Total</th>
                    <th
                        style="padding:12px 16px; text-align:left; font-size:10px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted);">
                        Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resep as $r)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px; font-size:12px; color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="padding:12px 16px; font-size:13px; font-weight:600; color:var(--text-primary);">
                            {{ $r->pasien ?? '-' }}
                        </td>
                        <td style="padding:12px 16px;">
                            @php $st = $r->status ?? 'menunggu'; @endphp
                            @if ($st === 'selesai')
                                <span
                                    style="background:rgba(34,197,94,.15); color:var(--accent-green); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">SELESAI</span>
                            @elseif($st === 'tunda')
                                <span
                                    style="background:rgba(239,68,68,.15); color:var(--accent-red); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">TUNDA</span>
                            @else
                                <span
                                    style="background:rgba(245,158,11,.15); color:var(--accent-amber); padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700;">MENUNGGU</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-primary);">
                            Rp {{ number_format($r->total_harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace;">
                            {{ \Carbon\Carbon::parse($r->created_at)->format('H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            style="padding:40px; text-align:center; color:var(--text-muted); font-size:13px;">
                            Tidak ada transaksi pada tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
