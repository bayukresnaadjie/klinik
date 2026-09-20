@extends('layouts.kasir')
@section('title', 'Detail Stok')
@section('page-title', 'Detail Stok')

@section('content')

    <div style="margin-bottom:16px;">
        <a href="{{ route('kasir.stok.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:13px;">←
            Kembali</a>
    </div>

    <div
        style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px; max-width:600px;">
        <div style="font-size:18px; font-weight:700; margin-bottom:16px;">
            {{ $stok->varianObat->nama_merek ?? '-' }} {{ $stok->varianObat->dosis_mg ?? '' }}mg
        </div>
        <table style="width:100%; border-collapse:collapse;">
            @foreach ([
            'Nama Obat' => $stok->varianObat->obat->nama_obat ?? '-',
            'No Batch' => $stok->no_batch ?? '-',
            'Jumlah Stok' => $stok->jumlah . ' unit',
            'Tgl Masuk' => \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d M Y'),
            'Tgl Kadaluarsa' => \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y'),
        ] as $label => $value)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 0; font-size:12px; color:var(--text-muted); width:140px;">{{ $label }}
                    </td>
                    <td style="padding:10px 0; font-size:13px; color:var(--text-primary); font-weight:500;">
                        {{ $value }}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
