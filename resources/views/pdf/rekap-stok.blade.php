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
    .gold-bar { width: 32px; height: 3px; background: #C9A84C; margin-top: 6px; }
    .header-right { text-align: right; font-size: 8.5px; color: rgba(255,255,255,0.6); line-height: 1.6; }

    .meta-row { display: flex; gap: 14px; margin-bottom: 14px; }
    .meta-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;
                 padding: 8px 14px; flex: 1; }
    .meta-label { font-size: 8px; text-transform: uppercase; letter-spacing: .06em;
                  color: #94a3b8; margin-bottom: 3px; }
    .meta-val { font-size: 13px; font-weight: bold; color: #0B1F3A; }

    .legend { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
    .legend-item { display: flex; align-items: center; gap: 5px; font-size: 8px; color: #4b5563; }
    .legend-dot { width: 10px; height: 10px; border-radius: 2px; }

    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead tr { background: #0B1F3A; }
    thead th { color: #fff; padding: 7px 8px; text-align: left; font-weight: bold;
               font-size: 8px; letter-spacing: .04em; text-transform: uppercase; }
    thead th.right  { text-align: right; }
    thead th.center { text-align: center; }

    tbody td { padding: 5.5px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
    tbody td.right  { text-align: right; }
    tbody td.center { text-align: center; }

    .row-expired { background: #fef2f2 !important; }
    .row-kritis  { background: #fffbeb !important; }
    .row-aman    { }
    tbody tr:nth-child(even).row-aman { background: #f8fafc; }

    .merek { font-weight: bold; color: #0B1F3A; }
    .obat  { color: #6b7280; font-size: 8px; }

    .status-badge { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 7.5px; font-weight: bold; }
    .s-aman    { background: #d1fae5; color: #065f46; }
    .s-kritis  { background: #fef3c7; color: #92400e; }
    .s-warning { background: #dbeafe; color: #1e40af; }
    .s-expired { background: #fee2e2; color: #991b1b; }
    .s-habis   { background: #f1f5f9; color: #475569; }

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
            <h1>REKAP STOK OBAT</h1>
            <div class="sub">Klinik Yos Benito — Sistem Pengelolaan Farmasi</div>
            <div class="gold-bar"></div>
        </div>
        <div class="header-right">
            <div>Dicetak: {{ now()->format('d F Y, H:i') }}</div>
            <div>Total batch: {{ number_format($data->count()) }}</div>
        </div>
    </div>
</div>

<div class="meta-row">
    <div class="meta-card">
        <div class="meta-label">Total Batch</div>
        <div class="meta-val">{{ number_format($data->count()) }}</div>
    </div>
    <div class="meta-card">
        <div class="meta-label">Total Stok (Unit)</div>
        <div class="meta-val" style="color:#065F46">{{ number_format($totalStok) }}</div>
    </div>
    <div class="meta-card">
        <div class="meta-label">Nilai Inventori</div>
        <div class="meta-val" style="color:#0C447C">Rp {{ number_format($totalNilai, 0, ',', '.') }}</div>
    </div>
    <div class="meta-card">
        <div class="meta-label">Batch Kritis / Expired</div>
        <div class="meta-val" style="color:#991B1B">
            {{ $data->filter(fn($r) => in_array($r->status_kadaluarsa, ['kritis','expired']))->count() }}
        </div>
    </div>
</div>

<div class="legend">
    <span style="font-size:8px;color:#6b7280;font-weight:bold">Keterangan warna:</span>
    <div class="legend-item"><div class="legend-dot" style="background:#fee2e2"></div> Expired</div>
    <div class="legend-item"><div class="legend-dot" style="background:#fef3c7"></div> Kritis (≤30 hari)</div>
    <div class="legend-item"><div class="legend-dot" style="background:#fff"></div> Aman</div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:26px">#</th>
            <th>Nama Obat</th>
            <th style="width:50px" class="center">Jenis</th>
            <th style="width:42px" class="center">Dosis</th>
            <th style="width:70px">No. Batch</th>
            <th style="width:55px" class="center">Jumlah</th>
            <th style="width:70px" class="right">Harga Satuan</th>
            <th style="width:80px" class="right">Nilai Stok</th>
            <th style="width:70px" class="center">Tgl Masuk</th>
            <th style="width:72px" class="center">Kadaluarsa</th>
            <th style="width:44px" class="center">Sisa</th>
            <th style="width:52px" class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php
            $status   = $row->status_kadaluarsa;
            $rowClass = match($status) { 'expired'=>'row-expired', 'kritis'=>'row-kritis', default=>'' };
            $badgeCls = match($status) {
                'expired'=>'s-expired','kritis'=>'s-kritis','warning'=>'s-warning',
                'habis'=>'s-habis',default=>'s-aman'
            };
            $badgeLbl = match($status) {
                'expired'=>'Expired','kritis'=>'Kritis','warning'=>'Waspadai',
                'habis'=>'Habis',default=>'Aman'
            };
        @endphp
        <tr class="{{ $rowClass }}">
            <td class="center" style="color:#94a3b8">{{ $i + 1 }}</td>
            <td>
                <div class="merek">{{ $row->varianObat->nama_merek ?? '-' }}</div>
                <div class="obat">{{ $row->varianObat->obat->nama_obat ?? '-' }}</div>
            </td>
            <td class="center" style="font-size:8px;color:#4b5563">
                {{ $row->varianObat->obat->jenisObat->nama_jenis ?? '-' }}
            </td>
            <td class="center">{{ $row->varianObat->dosis_mg ?? '-' }} mg</td>
            <td style="font-family:monospace;font-size:8px">{{ $row->no_batch ?? '—' }}</td>
            <td class="center" style="font-weight:bold;
                color:{{ $row->jumlah==0?'#ef4444':'#0B1F3A' }}">
                {{ number_format($row->jumlah) }}
            </td>
            <td class="right">Rp {{ number_format($row->varianObat->harga ?? 0, 0, ',', '.') }}</td>
            <td class="right" style="font-weight:bold">
                Rp {{ number_format(($row->varianObat->harga ?? 0) * $row->jumlah, 0, ',', '.') }}
            </td>
            <td class="center">{{ $row->tanggal_masuk->format('d/m/Y') }}</td>
            <td class="center" style="font-weight:{{ in_array($status,['expired','kritis'])?'bold':'normal' }};
                color:{{ in_array($status,['expired','kritis'])?'#991b1b':'#374151' }}">
                {{ $row->tanggal_kadaluarsa->format('d/m/Y') }}
            </td>
            <td class="center" style="font-size:8px;color:#6b7280">{{ $row->sisa_hari }}h</td>
            <td class="center">
                <span class="status-badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right">TOTAL</td>
            <td class="center">{{ number_format($totalStok) }}</td>
            <td></td>
            <td class="right">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
            <td colspan="4"></td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <div>
        <div>Dokumen ini digenerate otomatis oleh Sistem Pengelolaan Farmasi Klinik Yos Benito</div>
        <div style="margin-top:2px">{{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <div class="ttd">
        <span class="name">Apoteker / Penanggung Jawab</span>
    </div>
</div>

</body>
</html>
