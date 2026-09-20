@extends('layouts.kasir')
@section('title', 'Cetak Struk')
@section('page-title', 'Cetak Struk')

@push('styles')
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .filter-input {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border .15s;
        }

        .filter-input:focus {
            border-color: var(--accent-cyan);
        }

        .filter-input::placeholder {
            color: var(--text-muted);
        }

        .btn-reset-filter {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: none;
            color: var(--text-muted);
            font-size: 12px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all .15s;
        }

        .btn-reset-filter:hover {
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
        }

        /* ── TABLE ── */
        .resep-table {
            width: 100%;
            border-collapse: collapse;
        }

        .resep-table th {
            font-size: 10px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card-alt);
            white-space: nowrap;
        }

        .resep-table td {
            padding: 12px 16px;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .resep-table tr:last-child td {
            border-bottom: none;
        }

        .resep-table tr:hover td {
            background: var(--bg-hover);
        }

        .badge-selesai {
            background: rgba(34, 197, 94, .12);
            color: var(--accent-green);
            border: 1px solid rgba(34, 197, 94, .2);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-cetak {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            background: var(--accent-cyan);
            color: #0a1a1a;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
            white-space: nowrap;
        }

        .btn-cetak:hover {
            opacity: .85;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            background: rgba(59, 130, 246, .1);
            color: var(--accent-blue);
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(59, 130, 246, .2);
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }

        .empty-state {
            padding: 48px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* ── OBAT INFO DI TABEL ── */
        .obat-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .obat-item {
            padding: 8px 10px;
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 8px;
        }

        .obat-item-nama {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .obat-item-zat {
            font-size: 10.5px;
            color: var(--text-muted);
            font-style: italic;
            margin-bottom: 4px;
        }

        .obat-item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 4px;
        }

        .obat-tag {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .obat-tag-signa {
            background: rgba(0, 200, 200, .08);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 200, 200, .2);
        }

        .obat-tag-jadwal {
            background: rgba(251, 191, 36, .08);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, .2);
        }

        .obat-tag-ket {
            background: rgba(167, 139, 250, .08);
            color: #a78bfa;
            border: 1px solid rgba(167, 139, 250, .2);
        }

        .obat-tag-harga {
            background: rgba(74, 222, 128, .08);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, .2);
            margin-left: auto;
        }

        /* ── MODAL CETAK STRUK ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open {
            display: flex;
        }

        .struk-modal {
            background: #fff;
            border-radius: 12px;
            width: 380px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .struk-print {
            padding: 24px;
            font-family: 'Courier New', monospace;
            color: #000;
            background: #fff;
        }

        .struk-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .struk-header h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .struk-header p {
            font-size: 11px;
            color: #444;
            margin: 2px 0;
        }

        .struk-no {
            font-size: 11px;
            margin-bottom: 12px;
        }

        .struk-no div {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }

        .struk-items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        .struk-obat {
            padding: 6px 0;
            border-bottom: 1px dashed #ddd;
        }

        .struk-obat:last-child {
            border-bottom: none;
        }

        .struk-obat-row1 {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
        }

        .struk-obat-zat {
            font-size: 10px;
            color: #666;
            margin-top: 1px;
            font-style: italic;
        }

        .struk-obat-signa {
            font-size: 11px;
            color: #333;
            margin-top: 3px;
        }

        .struk-obat-jadwal {
            font-size: 11px;
            color: #333;
            margin-top: 2px;
        }

        .struk-obat-ket {
            font-size: 10.5px;
            color: #555;
            font-style: italic;
            margin-top: 2px;
        }

        .struk-total {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 700;
            padding: 4px 0;
            border-top: 2px dashed #000;
            margin-top: 6px;
        }

        .struk-footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-top: 12px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .struk-actions {
            padding: 16px 24px;
            display: flex;
            gap: 10px;
            border-top: 1px solid #eee;
        }

        .btn-print {
            flex: 1;
            padding: 10px;
            background: #0B1F3A;
            color: #E8C97A;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-close {
            padding: 10px 20px;
            background: none;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #struk-print-area,
            #struk-print-area * {
                visibility: visible;
            }

            #struk-print-area {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">Cetak Struk</h1>
            <p class="page-subtitle">Resep yang sudah selesai dibayar</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-bar">
        <input type="text" class="filter-input" id="search-input" placeholder="Cari nama pasien atau no. resep..."
            oninput="filterTable()" style="width:280px;">
        <input type="date" class="filter-input" id="filter-date" value="" onchange="filterTable()">
        <button class="btn-reset-filter" onclick="resetFilter()">
            ✕ Reset Filter
        </button>
    </div>

    {{-- Tabel --}}
    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
        <table class="resep-table" id="resep-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th width="160">No. Resep</th>
                    <th width="140">Nama Pasien</th>
                    <th width="120">Total</th>
                    <th>Obat &amp; Signa</th>
                    <th width="130">Waktu Selesai</th>
                    <th width="90">Status</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse($resepSelesai as $i => $resep)
                    @php
                        $sigmaMap = [
                            's1' => '1× sehari',
                            's2' => '2× sehari',
                            's3' => '3× sehari',
                            's4' => '4× sehari',
                            's6' => '6× sehari',
                            's_omn_noct' => 'tiap malam',
                            's_omn_mane' => 'tiap pagi',
                            's_prn' => 'jika perlu',
                        ];
                        $sigma2Map = [
                            'ac' => 'sebelum makan',
                            'pc' => 'sesudah makan',
                            'dc' => 'bersama makan',
                            'cum_aqua' => 'dengan air',
                            'ante_prand' => 'sebelum makan siang',
                            'hora_somni' => 'saat tidur',
                            'sublingual' => 'bawah lidah',
                            'prn' => 'bila perlu',
                            'oleskan' => 'oleskan tipis',
                            'teteskan' => 'teteskan',
                        ];
                        $ketMap = [
                            'diminum_sesudah_makan' => 'Sesudah makan',
                            'diminum_sebelum_makan' => 'Sebelum makan',
                            'diminum_bersama_makan' => 'Bersama makan',
                            'diminum_saat_tidur' => 'Saat tidur',
                            'diminum_dengan_air_putih' => 'Dengan air putih',
                            'jangan_dihancurkan' => 'Jangan dihancurkan',
                            'diteteskan_mata' => 'Tetes mata',
                            'diteteskan_telinga' => 'Tetes telinga',
                            'oleskan_tipis' => 'Oleskan tipis',
                            'digunakan_jika_perlu' => 'Jika perlu',
                            'habiskan' => 'Harap dihabiskan',
                            'kocok_dulu' => 'Kocok dahulu',
                            'simpan_dikulkas' => 'Simpan di kulkas',
                        ];
                    @endphp
                    <tr data-pasien="{{ strtolower($resep->pasien) }}" data-no="{{ strtolower($resep->no_resep) }}"
                        data-date="{{ \Carbon\Carbon::parse($resep->updated_at)->format('Y-m-d') }}">

                        <td style="color:var(--text-muted);font-family:'IBM Plex Mono',monospace;font-size:12px;">
                            {{ $i + 1 }}
                        </td>

                        <td style="font-family:'IBM Plex Mono',monospace;color:var(--accent-cyan);font-size:12px;">
                            {{ $resep->no_resep ?? 'RES-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <td style="font-weight:600;">{{ $resep->pasien ?? '-' }}</td>

                        <td
                            style="font-family:'IBM Plex Mono',monospace;color:var(--accent-cyan);font-weight:600;white-space:nowrap;">
                            Rp {{ number_format($resep->total_harga ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- ── Kolom Obat & Signa ── --}}
                        <td>
                            <div class="obat-list">
                                @foreach ($resep->items as $item)
                                    @php
                                        $namaObat = optional($item->varianObat)->nama_merek ?? '-';
                                        $dosis = optional($item->varianObat)->dosis_mg;
                                        $zatAktif = optional($item->varianObat->obat)->nama_obat ?? '';

                                        $s1Label = $item->sigma1 ? $sigmaMap[$item->sigma1] ?? $item->sigma1 : '';
                                        $s2Label = $item->sigma2 ? $sigma2Map[$item->sigma2] ?? $item->sigma2 : '';
                                        $ketLabel = $item->keterangan_pakai
                                            ? $ketMap[$item->keterangan_pakai] ?? $item->keterangan_pakai
                                            : '';

                                        $signa = collect([$s1Label, $s2Label])
                                            ->filter()
                                            ->join(', ');

                                        $jadwal = [];
                                        if ($item->pagi > 0) {
                                            $jadwal[] = '☀️ Pagi';
                                        }
                                        if ($item->siang > 0) {
                                            $jadwal[] = '🌤 Siang';
                                        }
                                        if ($item->sore > 0) {
                                            $jadwal[] = '🌇 Sore';
                                        }
                                        if ($item->malam > 0) {
                                            $jadwal[] = '🌙 Malam';
                                        }
                                    @endphp
                                    <div class="obat-item">
                                        <div class="obat-item-nama">
                                            {{ $namaObat }}{{ $dosis ? ' ' . $dosis . 'mg' : '' }}
                                            <span style="font-size:11px;font-weight:400;color:var(--text-muted);">
                                                × {{ $item->jumlah }} {{ $item->satuan }}
                                            </span>
                                        </div>
                                        @if ($zatAktif)
                                            <div class="obat-item-zat">{{ $zatAktif }}</div>
                                        @endif
                                        <div class="obat-item-tags">
                                            @if ($signa)
                                                <span class="obat-tag obat-tag-signa">
                                                    ⟳ {{ $signa }}
                                                </span>
                                            @endif
                                            @if (count($jadwal))
                                                <span class="obat-tag obat-tag-jadwal">
                                                    🕐 {{ implode(' · ', $jadwal) }}
                                                </span>
                                            @endif
                                            @if ($ketLabel)
                                                <span class="obat-tag obat-tag-ket">
                                                    ℹ {{ $ketLabel }}
                                                </span>
                                            @endif
                                            <span class="obat-tag obat-tag-harga">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <td
                            style="font-size:12px;color:var(--text-muted);font-family:'IBM Plex Mono',monospace;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($resep->updated_at)->format('d M Y H:i') }}
                        </td>

                        <td><span class="badge-selesai">✓ Selesai</span></td>

                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <button class="btn-cetak" onclick="bukaCetakStruk({{ $resep->id }})">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M17 3H7a2 2 0 00-2 2v16l3-2 2 2 2-2 2 2 2-2 3 2V5a2 2 0 00-2-2z" />
                                    </svg>
                                    Cetak
                                </button>
                                <a href="{{ route('kasir.resep.show', $resep->id) }}" class="btn-detail">Detail</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">Belum ada resep selesai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($resepSelesai->hasPages())
        <div
            style="display:flex;align-items:center;gap:6px;margin-top:16px;font-size:12px;font-family:'IBM Plex Mono',monospace;">
            @if ($resepSelesai->onFirstPage())
                <span
                    style="padding:5px 12px;border-radius:6px;background:var(--bg-card);border:1px solid var(--border);color:var(--text-muted);">←
                    Prev</span>
            @else
                <a href="{{ $resepSelesai->previousPageUrl() }}"
                    style="padding:5px 12px;border-radius:6px;background:var(--bg-card);border:1px solid var(--border);color:var(--text-secondary);text-decoration:none;">←
                    Prev</a>
            @endif
            @foreach ($resepSelesai->getUrlRange(1, $resepSelesai->lastPage()) as $page => $url)
                @if ($page == $resepSelesai->currentPage())
                    <span
                        style="padding:5px 12px;border-radius:6px;background:var(--accent-cyan);color:#0a1a1a;font-weight:700;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        style="padding:5px 12px;border-radius:6px;background:var(--bg-card);border:1px solid var(--border);color:var(--text-secondary);text-decoration:none;">{{ $page }}</a>
                @endif
            @endforeach
            @if ($resepSelesai->hasMorePages())
                <a href="{{ $resepSelesai->nextPageUrl() }}"
                    style="padding:5px 12px;border-radius:6px;background:var(--bg-card);border:1px solid var(--border);color:var(--text-secondary);text-decoration:none;">Next
                    →</a>
            @else
                <span
                    style="padding:5px 12px;border-radius:6px;background:var(--bg-card);border:1px solid var(--border);color:var(--text-muted);">Next
                    →</span>
            @endif
        </div>
    @endif

    {{-- MODAL CETAK STRUK --}}
    <div class="modal-overlay" id="modal-struk">
        <div class="struk-modal">
            <div class="struk-print" id="struk-print-area">
                <div class="struk-header">
                    <h2>KLINIK YOS BENITO</h2>
                    <p>Sistem Kasir &amp; Farmasi</p>
                    <p id="struk-date" style="font-size:11px;margin-top:4px;"></p>
                </div>
                <div class="struk-no">
                    <div><span>No. Resep</span><span id="s-no-resep">-</span></div>
                    <div><span>Pasien</span><span id="s-pasien">-</span></div>
                </div>
                <div class="struk-items" id="s-items"></div>
                <div class="struk-total">
                    <span>TOTAL</span>
                    <span id="s-total">Rp 0</span>
                </div>
                <div class="struk-footer">
                    <p>Terima kasih telah berkunjung</p>
                    <p>Klinik Yos Benito</p>
                </div>
            </div>
            <div class="struk-actions">
                <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
                <button class="btn-close" onclick="tutupModal()">Tutup</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const resepData = {!! json_encode($resepJson) !!};

        const sigmaMap = {
            's1': '1× sehari',
            's2': '2× sehari',
            's3': '3× sehari',
            's4': '4× sehari',
            's6': '6× sehari',
            's_omn_noct': 'tiap malam',
            's_omn_mane': 'tiap pagi',
            's_prn': 'jika perlu',
        };
        const sigma2Map = {
            'ac': 'sebelum makan',
            'pc': 'sesudah makan',
            'dc': 'bersama makan',
            'cum_aqua': 'dengan air',
            'ante_prand': 'sebelum makan siang',
            'hora_somni': 'saat tidur',
            'sublingual': 'bawah lidah',
            'prn': 'bila perlu',
            'oleskan': 'oleskan tipis',
            'teteskan': 'teteskan',
        };
        const ketMap = {
            'diminum_sesudah_makan': 'Sesudah makan',
            'diminum_sebelum_makan': 'Sebelum makan',
            'diminum_bersama_makan': 'Bersama makan',
            'diminum_saat_tidur': 'Saat tidur',
            'diminum_dengan_air_putih': 'Dengan air putih yang banyak',
            'jangan_dihancurkan': 'Jangan dihancurkan',
            'diteteskan_mata': 'Diteteskan ke mata',
            'diteteskan_telinga': 'Diteteskan ke telinga',
            'oleskan_tipis': 'Oleskan tipis',
            'digunakan_jika_perlu': 'Jika perlu',
            'habiskan': 'Harap dihabiskan',
            'kocok_dulu': 'Kocok dahulu',
            'simpan_dikulkas': 'Simpan di kulkas',
        };

        function bukaCetakStruk(id) {
            const resep = resepData.find(r => r.id === id);
            if (!resep) return;

            document.getElementById('s-no-resep').textContent = resep.no_resep;
            document.getElementById('s-pasien').textContent = resep.pasien ?? '-';
            document.getElementById('s-total').textContent = 'Rp ' + formatRp(resep.total);
            document.getElementById('struk-date').textContent = new Date(resep.updated_at).toLocaleString('id-ID');

            const itemsHtml = resep.items.map(i => {
                const jadwal = [];
                if (i.pagi > 0) jadwal.push('Pagi ' + i.pagi + 'x');
                if (i.siang > 0) jadwal.push('Siang ' + i.siang + 'x');
                if (i.sore > 0) jadwal.push('Sore ' + i.sore + 'x');
                if (i.malam > 0) jadwal.push('Malam ' + i.malam + 'x');

                const s1 = i.sigma1 ? (sigmaMap[i.sigma1] || i.sigma1) : '';
                const s2 = i.sigma2 ? (sigma2Map[i.sigma2] || i.sigma2) : '';
                const ket = i.keterangan_pakai ? (ketMap[i.keterangan_pakai] || i.keterangan_pakai) : '';

                let signaLine = [s1, s2].filter(Boolean).join(', ');
                const namaObat = i.nama + (i.satuan ? ' ' + i.jumlah + ' ' + i.satuan : ' x' + i.jumlah);

                return `
                <div class="struk-obat">
                    <div class="struk-obat-row1">
                        <span>${namaObat}</span>
                        <span>Rp ${formatRp(i.subtotal)}</span>
                    </div>
                    ${i.zat_aktif  ? `<div class="struk-obat-zat">${i.zat_aktif}</div>`          : ''}
                    ${signaLine    ? `<div class="struk-obat-signa">⟳ ${signaLine}</div>`        : ''}
                    ${jadwal.length? `<div class="struk-obat-jadwal">🕐 ${jadwal.join(' - ')}</div>` : ''}
                    ${ket          ? `<div class="struk-obat-ket">ℹ ${ket}</div>`                : ''}
                </div>`;
            }).join('');

            document.getElementById('s-items').innerHTML = itemsHtml;
            document.getElementById('modal-struk').classList.add('open');
        }

        function tutupModal() {
            document.getElementById('modal-struk').classList.remove('open');
        }

        function formatRp(n) {
            return Math.round(n).toLocaleString('id-ID');
        }

        function filterTable() {
            const q = (document.getElementById('search-input').value || '').toLowerCase();
            const date = document.getElementById('filter-date').value;
            document.querySelectorAll('#table-body tr[data-pasien]').forEach(row => {
                const matchText = !q || row.dataset.pasien.includes(q) || row.dataset.no.includes(q);
                const matchDate = !date || row.dataset.date === date;
                row.style.display = matchText && matchDate ? '' : 'none';
            });
        }

        function resetFilter() {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-date').value = '';
            filterTable();
        }

        document.getElementById('modal-struk').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    </script>
@endpush
