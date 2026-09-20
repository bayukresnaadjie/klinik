<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kadaluarsa Obat</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F1F5F9;
            color: #1E293B;
            font-size: 14px;
            line-height: 1.6;
        }

        .wrapper {
            max-width: 620px;
            margin: 32px auto;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .header {
            background: #0B1F3A;
            padding: 32px 36px 28px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            background: rgba(201, 168, 76, 0.2);
            border: 1px solid rgba(201, 168, 76, 0.4);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .brand-mark::before,
        .brand-mark::after {
            content: '';
            position: absolute;
            background: #C9A84C;
            border-radius: 2px;
        }

        .brand-mark::before {
            width: 3px;
            height: 14px;
        }

        .brand-mark::after {
            width: 14px;
            height: 3px;
        }

        .brand-name {
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 600;
        }

        .brand-sub {
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
        }

        .header-date {
            color: rgba(255, 255, 255, 0.45);
            font-size: 12px;
            text-align: right;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 4px;
        }

        .header-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
        }

        .gold-bar {
            width: 40px;
            height: 3px;
            background: #C9A84C;
            border-radius: 2px;
            margin-top: 14px;
        }

        /* Alert banner */
        .alert-banner {
            padding: 14px 36px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #991B1B;
            border-left: 4px solid #EF4444;
        }

        .alert-warning {
            background: #FFFBEB;
            color: #92400E;
            border-left: 4px solid #F59E0B;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        /* Body */
        .body {
            padding: 28px 36px;
        }

        /* Stat row */
        .stat-row {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
        }

        .stat-card {
            flex: 1;
            border-radius: 8px;
            padding: 14px 16px;
            text-align: center;
            border: 1px solid;
        }

        .stat-card.red {
            background: #FEF2F2;
            border-color: #FECACA;
        }

        .stat-card.amber {
            background: #FFFBEB;
            border-color: #FDE68A;
        }

        .stat-card.blue {
            background: #EFF6FF;
            border-color: #BFDBFE;
        }

        .stat-card.green {
            background: #ECFDF5;
            border-color: #A7F3D0;
        }

        .stat-num {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .stat-num.red {
            color: #991B1B;
        }

        .stat-num.amber {
            color: #92400E;
        }

        .stat-num.blue {
            color: #1E40AF;
        }

        .stat-num.green {
            color: #065F46;
        }

        .stat-lbl {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6B7280;
        }

        /* Section */
        .section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #E2E8F0;
        }

        .section-title.red {
            color: #991B1B;
            border-color: #FECACA;
        }

        .section-title.amber {
            color: #92400E;
            border-color: #FDE68A;
        }

        .section-title.blue {
            color: #1E40AF;
            border-color: #BFDBFE;
        }

        /* Tabel obat */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            background: #F8FAFC;
            color: #64748B;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
        }

        thead th.right {
            text-align: right;
        }

        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .obat-merek {
            font-weight: 600;
            color: #0B1F3A;
        }

        .obat-nama {
            font-size: 11px;
            color: #94A3B8;
            margin-top: 1px;
        }

        .stok-num {
            font-weight: 600;
            text-align: right;
        }

        .exp-date {
            text-align: right;
            font-family: monospace;
            font-size: 12px;
        }

        .badge-expired {
            display: inline-block;
            padding: 2px 8px;
            background: #FEE2E2;
            color: #991B1B;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-kritis {
            display: inline-block;
            padding: 2px 8px;
            background: #FEF3C7;
            color: #92400E;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-warning {
            display: inline-block;
            padding: 2px 8px;
            background: #DBEAFE;
            color: #1E40AF;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        /* CTA */
        .cta-wrap {
            text-align: center;
            margin: 28px 0 8px;
        }

        .cta-btn {
            display: inline-block;
            padding: 12px 32px;
            background: #0B1F3A;
            color: #E8C97A !important;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .03em;
        }

        /* Empty state */
        .empty-box {
            text-align: center;
            padding: 20px;
            background: #F8FAFC;
            border-radius: 8px;
            color: #94A3B8;
            font-size: 13px;
        }

        /* Footer */
        .footer {
            background: #F8FAFC;
            padding: 20px 36px;
            border-top: 1px solid #E2E8F0;
        }

        .footer p {
            font-size: 12px;
            color: #94A3B8;
            line-height: 1.6;
        }

        .footer a {
            color: #C9A84C;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="header-top">
                <div class="brand">
                    <div class="brand-mark"></div>
                    <div>
                        <div class="brand-name">Klinik Yos Benito</div>
                        <div class="brand-sub">Sistem Pengelolaan Farmasi</div>
                    </div>
                </div>
                <div class="header-date">
                    {{ $tanggalLaporan }}<br>
                    Laporan otomatis harian
                </div>
            </div>
            <div class="header-title">Laporan Kadaluarsa Obat</div>
            <div class="header-sub">
                Ringkasan kondisi stok obat yang perlu segera ditangani
            </div>
            <div class="gold-bar"></div>
        </div>

        {{-- Alert banner --}}
        @if ($stokExpired->count() > 0)
            <div class="alert-banner alert-danger">
                ⚠ Ada {{ $stokExpired->count() }} batch yang sudah EXPIRED namun masih tercatat ada stok.
                Segera lakukan penanganan atau pemusnahan.
            </div>
        @elseif($stokKritis->count() > 0)
            <div class="alert-banner alert-warning">
                ⏰ Ada {{ $stokKritis->count() }} batch yang akan kadaluarsa dalam 30 hari ke depan.
                Prioritaskan pemakaian batch tersebut.
            </div>
        @else
            <div class="alert-banner alert-success">
                ✓ Semua stok obat dalam kondisi aman. Tidak ada batch yang bermasalah.
            </div>
        @endif

        {{-- Body --}}
        <div class="body">

            {{-- Stat cards --}}
            <div class="stat-row">
                <div class="stat-card red">
                    <div class="stat-num red">{{ $stokExpired->count() }}</div>
                    <div class="stat-lbl">Sudah Expired</div>
                </div>
                <div class="stat-card amber">
                    <div class="stat-num amber">{{ $stokKritis->count() }}</div>
                    <div class="stat-lbl">Kritis ≤30 Hari</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-num blue">{{ $stokWarning->count() }}</div>
                    <div class="stat-lbl">Waspadai ≤90 Hari</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-num green">
                        {{ $stokExpired->count() + $stokKritis->count() + $stokWarning->count() === 0 ? '✓' : $stokExpired->count() + $stokKritis->count() }}
                    </div>
                    <div class="stat-lbl">
                        {{ $stokExpired->count() + $stokKritis->count() === 0 ? 'Semua Aman' : 'Perlu Tindakan' }}</div>
                </div>
            </div>

            {{-- Tabel: Expired --}}
            @if ($stokExpired->isNotEmpty())
                <div class="section">
                    <div class="section-title red">🚨 Batch Sudah Expired ({{ $stokExpired->count() }})</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>No. Batch</th>
                                <th class="right">Sisa Stok</th>
                                <th class="right">Tgl Expired</th>
                                <th class="right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokExpired as $s)
                                <tr>
                                    <td>
                                        <div class="obat-merek">{{ $s->varianObat->nama_merek ?? '-' }}
                                            {{ $s->varianObat->dosis_mg ?? '' }}mg</div>
                                        <div class="obat-nama">{{ $s->varianObat->obat->nama_obat ?? '-' }}</div>
                                    </td>
                                    <td style="font-family:monospace;font-size:12px;color:#64748B">
                                        {{ $s->no_batch ?? '—' }}</td>
                                    <td class="stok-num" style="color:#991B1B">{{ number_format($s->jumlah) }}</td>
                                    <td class="exp-date" style="color:#991B1B">
                                        {{ $s->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                    <td style="text-align:right"><span class="badge-expired">Expired
                                            {{ abs($s->sisa_hari) }}h lalu</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Tabel: Kritis --}}
            @if ($stokKritis->isNotEmpty())
                <div class="section">
                    <div class="section-title amber">⏰ Kritis — Exp ≤ 30 Hari ({{ $stokKritis->count() }})</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>No. Batch</th>
                                <th class="right">Stok</th>
                                <th class="right">Kadaluarsa</th>
                                <th class="right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokKritis as $s)
                                <tr>
                                    <td>
                                        <div class="obat-merek">{{ $s->varianObat->nama_merek ?? '-' }}
                                            {{ $s->varianObat->dosis_mg ?? '' }}mg</div>
                                        <div class="obat-nama">{{ $s->varianObat->obat->nama_obat ?? '-' }}</div>
                                    </td>
                                    <td style="font-family:monospace;font-size:12px;color:#64748B">
                                        {{ $s->no_batch ?? '—' }}</td>
                                    <td class="stok-num">{{ number_format($s->jumlah) }}</td>
                                    <td class="exp-date">{{ $s->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                    <td style="text-align:right"><span class="badge-kritis">{{ $s->sisa_hari }} hari
                                            lagi</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Tabel: Warning --}}
            @if ($stokWarning->isNotEmpty())
                <div class="section">
                    <div class="section-title blue">📋 Perlu Diwaspadai — Exp ≤ 90 Hari ({{ $stokWarning->count() }})
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>No. Batch</th>
                                <th class="right">Stok</th>
                                <th class="right">Kadaluarsa</th>
                                <th class="right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokWarning as $s)
                                <tr>
                                    <td>
                                        <div class="obat-merek">{{ $s->varianObat->nama_merek ?? '-' }}
                                            {{ $s->varianObat->dosis_mg ?? '' }}mg</div>
                                        <div class="obat-nama">{{ $s->varianObat->obat->nama_obat ?? '-' }}</div>
                                    </td>
                                    <td style="font-family:monospace;font-size:12px;color:#64748B">
                                        {{ $s->no_batch ?? '—' }}</td>
                                    <td class="stok-num">{{ number_format($s->jumlah) }}</td>
                                    <td class="exp-date">{{ $s->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                    <td style="text-align:right"><span class="badge-warning">{{ $s->sisa_hari }} hari
                                            lagi</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Tabel: Stok di bawah minimum --}}
            @if ($bawahMinimum->isNotEmpty())
                <div class="section">
                    <div class="section-title blue">📦 Stok di Bawah Minimum ({{ $bawahMinimum->count() }})</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th class="right">Stok Saat Ini</th>
                                <th class="right">Minimum</th>
                                <th class="right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bawahMinimum as $v)
                                <tr>
                                    <td>
                                        <div class="obat-merek">{{ $v->nama_merek ?? '-' }} {{ $v->dosis_mg ?? '' }}mg
                                        </div>
                                        <div class="obat-nama">{{ $v->obat->nama_obat ?? '-' }}</div>
                                    </td>
                                    <td class="stok-num" style="color:#991B1B">{{ number_format($v->stok_aktual) }}
                                    </td>
                                    <td class="stok-num">{{ number_format($v->stok_minimum) }}</td>
                                    <td style="text-align:right">
                                        <span class="badge-expired">Di bawah minimum</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Semua aman --}}
            @if ($stokExpired->isEmpty() && $stokKritis->isEmpty() && $stokWarning->isEmpty() && $bawahMinimum->isEmpty())
                <div class="empty-box">
                    Tidak ada batch yang bermasalah hari ini.<br>
                    Semua stok obat dalam kondisi baik.
                </div>
            @endif

            {{-- CTA --}}
            <div class="cta-wrap">
                <a href="{{ config('app.url') }}/dashboard" class="cta-btn">
                    Buka Dashboard Sistem Obat →
                </a>
            </div>

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                Email ini dikirim otomatis setiap hari pukul 07.00 oleh
                <strong>Sistem Pengelolaan Farmasi Klinik Yos Benito</strong>.<br>
                Laporan dibuat pada: <strong>{{ $tanggalLaporan }}</strong>.<br>
                Jika ada pertanyaan, hubungi administrator sistem.
            </p>
        </div>

    </div>
</body>

</html>
