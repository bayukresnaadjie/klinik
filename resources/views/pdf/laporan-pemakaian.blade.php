<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1a202c; background: #fff; }

    .header { background: #0B1F3A; color: #fff; padding: 14px 20px; margin-bottom: 14px; }
    .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .header h1 { font-size: 16px; font-weight: bold; letter-spacing: .5px; margin-bottom: 2px; }
    .header .sub { font-size: 9px; color: rgba(255,255,255,0.55); }
    .gold-accent { display: inline-block; width: 32px; height: 3px; background: #C9A84C; margin-top: 6px; }
    .header-right { text-align: right; font-size: 8.5px; color: rgba(255,255,255,0.6); line-height: 1.6; }

    .meta-row { display: flex; gap: 16px; margin-bottom: 14px; padding: 0 0; }
    .meta-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;
                 padding: 8px 14px; flex: 1; }
    .meta-card .label { font-size: 8px; text-transform: uppercase; letter-spacing: .06em;
                        color: #94a3b8; margin-bottom: 3px; }
    .meta-card .value { font-size: 13px; font-weight: bold; color: #0B1F3A; }
    .meta-card.green .value { color: #065F46; }
    .meta-card.gold .value { color: #7A5C1E; }

    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead tr { background: #0B1F3A; }
    thead th { color: #fff; padding: 7px 8px; text-align: left; font-weight: bold;
               font-size: 8px; letter-spacing: .04em; text-transform: uppercase; }
    thead th.center { text-align: center; }
    thead th.right  { text-align: right; }

    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr:hover { background: #f0f9ff; }
    tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
    tbody td.center { text-align: center; }
    tbody td.right  { text-align: right; }

    .merek { font-weight: bold; color: #0B1F3A; }
    .obat  { color: #6b7280; font-size: 8px; }

    .badge { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 7.5px; font-weight: bold; }
    .b-tablet  { background: #dbeafe; color: #1e40af; }
    .b-sirup   { background: #dcfce7; color: #166534; }
    .b-injeksi { background: #fce7f3; color: #9d174d; }
    .b-other   { background: #f1f5f9; color: #475569; }

    tfoot tr { background: #C9A84C; }
    tfoot td { padding: 7px 8px; font-weight: bold; color: #fff; font-size: 9px; }

    .footer { margin-top: 14px; padding-top: 10px; border-top: 1px solid #e5e7eb;
              display: flex; justify-content: space-between; font-size: 8px; color: #94a3b8; }
    .ttd { text-align: right; }
    .ttd .name { margin-top: 40px; border-top: 1px solid #374151; padding-top: 4px;
                 font-size: 9px; color: #374151; min-width: 140px; display: inline-block; text-align: center; }
</style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div>
            <h1>LAPORAN PEMAKAIAN OBAT</h1>
            <div class="sub">Klinik Yos Benito — Sistem Pengelolaan Farmasi</div>
            <div class="gold-accent"></div>
        </div>
        <div class="header-right">
            <div>Dicetak oleh: Sistem</div>
            <div>Tanggal cetak: {{ now()->format('d F Y, H:i') }}</div>
            @if($periode['dari'] && $periode['sampai'])
            <div>Periode: {{ \Carbon\Carbon::parse($periode['dari'])->format('d/m/Y') }}
                 — {{ \Carbon\Carbon::parse($periode['sampai'])->format('d/m/Y') }}</div>
            @else
            <div>Periode: Semua data</div>
            @endif
        </div>
    </div>
</div>

<div class="meta-row">
    <div class="meta-card">
        <div class="label">Total Transaksi</div>
        <div class="value">{{ number_format($data->count()) }}</div>
    </div>
    <div class="meta-card">
        <div class="label">Total Unit Dipakai</div>
        <div class="value">{{ number_format($total) }}</div>
    </div>
    <div class="meta-card green">
        <div class="label">Total Nilai Pemakaian</div>
        <div class="value">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
    </div>
    <div class="meta-card gold">
        <div class="label">Jenis Obat</div>
        <div class="value">{{ $data->pluck('id_varian')->unique()->count() }} varian</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:28px">#</th>
            <th style="width:75px">Tanggal</th>
            <th>Nama Obat</th>
            <th style="width:55px" class="center">Jenis</th>
            <th style="width:45px" class="center">Dosis</th>
            <th style="width:70px">No. Batch</th>
            <th style="width:50px" class="center">Jumlah</th>
            <th style="width:75px" class="right">Harga Satuan</th>
            <th style="width:80px" class="right">Total Nilai</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td class="center" style="color:#94a3b8">{{ $i + 1 }}</td>
            <td>{{ $row->tanggal_pakai->format('d/m/Y') }}</td>
            <td>
                <div class="merek">{{ $row->varianObat->nama_merek ?? '-' }}</div>
                <div class="obat">{{ $row->varianObat->obat->nama_obat ?? '-' }}</div>
            </td>
            <td class="center">
                @php
                    $jenis = strtolower($row->varianObat->obat->jenisObat->nama_jenis ?? '');
                    $cls = str_contains($jenis,'tablet')?'b-tablet':(str_contains($jenis,'sirup')?'b-sirup':(str_contains($jenis,'injek')?'b-injeksi':'b-other'));
                @endphp
                <span class="badge {{ $cls }}">{{ $row->varianObat->obat->jenisObat->nama_jenis ?? '-' }}</span>
            </td>
            <td class="center">{{ $row->varianObat->dosis_mg ?? '-' }} mg</td>
            <td style="font-family:monospace">{{ $row->stokObat->no_batch ?? '-' }}</td>
            <td class="center" style="font-weight:bold">{{ number_format($row->jumlah_pakai) }}</td>
            <td class="right">Rp {{ number_format($row->varianObat->harga ?? 0, 0, ',', '.') }}</td>
            <td class="right" style="font-weight:bold">
                Rp {{ number_format(($row->varianObat->harga ?? 0) * $row->jumlah_pakai, 0, ',', '.') }}
            </td>
            <td style="color:#6b7280">{{ Str::limit($row->keterangan ?? '-', 35) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align:right">TOTAL</td>
            <td class="center">{{ number_format($total) }}</td>
            <td></td>
            <td class="right">Rp {{ number_format($nilai, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <div>
        <div>Dokumen ini digenerate otomatis oleh Sistem Pengelolaan Farmasi Klinik Yos Benito</div>
        <div style="margin-top:2px">Halaman 1 | {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <div class="ttd">
        <span class="name">Apoteker / Penanggung Jawab</span>
    </div>
</div>

</body>
</html>
