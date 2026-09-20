@extends('layouts.manager')

@section('title', 'Peringatan')
@section('page_title', 'Peringatan & Notifikasi')
@section('page_subtitle', 'Pantau kondisi kritis yang memerlukan tindakan segera')

@push('styles')
    <style>
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .strip-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 13px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            text-decoration: none;
        }

        .strip-card:hover {
            border-color: var(--color-border-strong);
            box-shadow: var(--shadow-sm);
        }

        .strip-card.active-filter {
            border-color: var(--color-primary);
            background: var(--color-primary-light);
        }

        .strip-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .strip-val {
            font-size: 20px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
        }

        .strip-lbl {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 2px;
        }

        .alert-group {
            margin-bottom: 24px;
        }

        .alert-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 8px;
            transition: border-color .15s;
            position: relative;
            overflow: hidden;
        }

        .alert-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
        }

        .alert-card.level-kritis::before {
            background: #E24B4A;
        }

        .alert-card.level-tinggi::before {
            background: #BA7517;
        }

        .alert-card.level-sedang::before {
            background: #185FA5;
        }

        .alert-card:hover {
            border-color: var(--color-border-strong);
        }

        .alert-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .alert-icon.kritis {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .alert-icon.tinggi {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .alert-icon.sedang {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .alert-body {
            flex: 1;
            min-width: 0;
        }

        .alert-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-main);
            margin-bottom: 2px;
        }

        .alert-desc {
            font-size: 12px;
            color: var(--color-text-muted);
            margin-bottom: 6px;
            line-height: 1.5;
        }

        .alert-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .alert-meta span {
            font-size: 11px;
            color: var(--color-text-hint);
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .alert-meta i {
            font-size: 12px;
        }

        .alert-action {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .btn-action {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: var(--radius-md);
            border: 1px solid var(--color-border-strong);
            background: none;
            color: var(--color-text-muted);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: background .15s;
            white-space: nowrap;
        }

        .btn-action:hover {
            background: var(--color-content-bg);
        }

        .btn-action.primary {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
        }

        .btn-action.primary:hover {
            opacity: .85;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .pill-danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .pill-warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        .section-count {
            font-size: 10px;
            font-weight: 600;
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
            padding: 1px 7px;
            border-radius: 20px;
        }

        .section-count.warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .section-count.info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .empty-section {
            text-align: center;
            padding: 20px;
            color: var(--color-text-hint);
            font-size: 12px;
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .empty-section i {
            font-size: 16px;
            color: #1D9E75;
        }

        @media (max-width: 1024px) {
            .summary-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .summary-strip {
                grid-template-columns: 1fr 1fr;
            }

            .alert-card {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── SUMMARY STRIP ── --}}
    <div class="summary-strip">
        <a href="{{ request()->fullUrlWithQuery(['filter' => 'kritis']) }}"
            class="strip-card {{ request('filter') === 'kritis' ? 'active-filter' : '' }}">
            <div class="strip-icon" style="background:var(--color-danger-bg);color:var(--color-danger-text)"><i
                    class="ti ti-alert-circle"></i></div>
            <div>
                <div class="strip-val" style="{{ $counts['kritis'] > 0 ? 'color:#A32D2D' : '' }}">{{ $counts['kritis'] }}
                </div>
                <div class="strip-lbl">Stok Kritis/Habis</div>
            </div>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['filter' => 'exp']) }}"
            class="strip-card {{ request('filter') === 'exp' ? 'active-filter' : '' }}">
            <div class="strip-icon" style="background:var(--color-warning-bg);color:var(--color-warning-text)"><i
                    class="ti ti-calendar-x"></i></div>
            <div>
                <div class="strip-val" style="{{ $counts['exp'] > 0 ? 'color:#BA7517' : '' }}">{{ $counts['exp'] }}</div>
                <div class="strip-lbl">Mendekati Expired</div>
            </div>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['filter' => 'sudah_exp']) }}"
            class="strip-card {{ request('filter') === 'sudah_exp' ? 'active-filter' : '' }}">
            <div class="strip-icon" style="background:var(--color-danger-bg);color:var(--color-danger-text)"><i
                    class="ti ti-trash"></i></div>
            <div>
                <div class="strip-val" style="{{ $counts['sudah_exp'] > 0 ? 'color:#A32D2D' : '' }}">
                    {{ $counts['sudah_exp'] }}</div>
                <div class="strip-lbl">Sudah Expired</div>
            </div>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['filter' => 'anomali']) }}"
            class="strip-card {{ request('filter') === 'anomali' ? 'active-filter' : '' }}">
            <div class="strip-icon" style="background:var(--color-info-bg);color:var(--color-info-text)"><i
                    class="ti ti-activity"></i></div>
            <div>
                <div class="strip-val">{{ $counts['anomali'] }}</div>
                <div class="strip-lbl">Anomali Pemakaian</div>
            </div>
        </a>
    </div>

    {{-- ── STOK KRITIS & HABIS ── --}}
    @if (!request('filter') || request('filter') === 'kritis')
        <div class="alert-group">
            <div class="section-label">
                Stok kritis & habis
                @if ($stokKritis->count() > 0)
                    <span class="section-count">{{ $stokKritis->count() }}</span>
                @endif
            </div>
            @if ($stokKritis->isEmpty())
                <div class="empty-section"><i class="ti ti-circle-check"></i> Tidak ada stok kritis saat ini</div>
            @else
                @foreach ($stokKritis as $item)
                    @php
                        $isHabis = $item->jumlah <= 0;
                        $level = $isHabis ? 'kritis' : 'tinggi';
                        $namaLengkap = $item->nama_obat . ' ' . $item->nama_merek . ' ' . $item->dosis_mg . 'mg';
                    @endphp
                    <div class="alert-card level-{{ $level }}">
                        <div class="alert-icon {{ $level }}">
                            <i class="ti ti-{{ $isHabis ? 'alert-circle' : 'alert-triangle' }}"></i>
                        </div>
                        <div class="alert-body">
                            <div class="alert-title">{{ $namaLengkap }}</div>
                            <div class="alert-desc">
                                @if ($isHabis)
                                    Stok obat ini telah habis. Segera lakukan restock.
                                @else
                                    Stok tersisa <strong>{{ $item->jumlah }} unit</strong>,
                                    di bawah batas minimum {{ $item->stok_minimum }} unit.
                                @endif
                            </div>
                            <div class="alert-meta">
                                <span><i class="ti ti-pill"></i> {{ $item->jenis }}</span>
                                <span><i class="ti ti-stack"></i> Sisa: {{ $item->jumlah }} unit</span>
                                <span><i class="ti ti-alert-triangle"></i> Min: {{ $item->stok_minimum }} unit</span>
                            </div>
                        </div>
                        <div class="alert-action">
                            <span
                                class="pill {{ $isHabis ? 'pill-danger' : 'pill-warn' }}">{{ $isHabis ? 'Habis' : 'Kritis' }}</span>
                            <a href="{{ route('manager.persetujuan') }}" class="btn-action primary">
                                <i class="ti ti-truck-delivery"></i> Ajukan Restock
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    {{-- ── MENDEKATI EXPIRED ── --}}
    @if (!request('filter') || request('filter') === 'exp')
        <div class="alert-group">
            <div class="section-label">
                Batch mendekati expired (≤ 90 hari)
                @if ($mendekatiExp->count() > 0)
                    <span class="section-count warn">{{ $mendekatiExp->count() }}</span>
                @endif
            </div>
            @if ($mendekatiExp->isEmpty())
                <div class="empty-section"><i class="ti ti-circle-check"></i> Tidak ada batch mendekati expired</div>
            @else
                @foreach ($mendekatiExp as $item)
                    @php
                        $sisaHari = now()->diffInDays(\Carbon\Carbon::parse($item->tanggal_kadaluarsa), false);
                        $level = $sisaHari <= 30 ? 'kritis' : 'tinggi';
                        $namaLengkap = $item->nama_obat . ' ' . $item->nama_merek . ' ' . $item->dosis_mg . 'mg';
                    @endphp
                    <div class="alert-card level-{{ $level }}">
                        <div class="alert-icon {{ $level }}"><i class="ti ti-calendar-event"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">{{ $namaLengkap }}</div>
                            <div class="alert-desc">
                                Batch <strong>{{ $item->no_batch ?? '-' }}</strong>
                                akan expired pada
                                <strong>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->translatedFormat('d F Y') }}</strong>
                                ({{ $sisaHari }} hari lagi)
                                .
                            </div>
                            <div class="alert-meta">
                                <span><i class="ti ti-pill"></i> {{ $item->jenis }}</span>
                                <span><i class="ti ti-stack"></i> Stok: {{ $item->jumlah }} unit</span>
                                <span><i class="ti ti-calendar"></i> Exp:
                                    {{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="alert-action">
                            <span class="pill {{ $sisaHari <= 30 ? 'pill-danger' : 'pill-warn' }}">{{ $sisaHari }}
                                hari lagi</span>
                            <a href="{{ route('manager.persetujuan') }}" class="btn-action">
                                <i class="ti ti-trash"></i> Ajukan Hapus Batch
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    {{-- ── SUDAH EXPIRED ── --}}
    @if (!request('filter') || request('filter') === 'sudah_exp')
        <div class="alert-group">
            <div class="section-label">
                Batch sudah expired — perlu dimusnahkan
                @if ($sudahExp->count() > 0)
                    <span class="section-count">{{ $sudahExp->count() }}</span>
                @endif
            </div>
            @if ($sudahExp->isEmpty())
                <div class="empty-section"><i class="ti ti-circle-check"></i> Tidak ada batch yang sudah expired</div>
            @else
                @foreach ($sudahExp as $item)
                    @php $namaLengkap = $item->nama_obat . ' ' . $item->nama_merek . ' ' . $item->dosis_mg . 'mg'; @endphp
                    <div class="alert-card level-kritis">
                        <div class="alert-icon kritis"><i class="ti ti-calendar-x"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">{{ $namaLengkap }}</div>
                            <div class="alert-desc">
                                Batch <strong>{{ $item->no_batch ?? '-' }}</strong>
                                telah expired sejak
                                <strong>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->translatedFormat('d F Y') }}</strong>.
                                Stok harus segera dimusnahkan.
                            </div>
                            <div class="alert-meta">
                                <span><i class="ti ti-pill"></i> {{ $item->jenis }}</span>
                                <span><i class="ti ti-stack"></i> Stok: {{ $item->jumlah }} unit</span>
                            </div>
                        </div>
                        <div class="alert-action">
                            <span class="pill pill-danger"><i class="ti ti-alert-circle"></i> Expired</span>
                            <a href="{{ route('manager.persetujuan') }}" class="btn-action primary">
                                <i class="ti ti-trash"></i> Ajukan Pemusnahan
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    {{-- ── ANOMALI PEMAKAIAN ── --}}
    @if (!request('filter') || request('filter') === 'anomali')
        <div class="alert-group">
            <div class="section-label">
                Anomali pemakaian — lonjakan tidak wajar
                @if ($anomali->count() > 0)
                    <span class="section-count info">{{ $anomali->count() }}</span>
                @endif
            </div>
            @if ($anomali->isEmpty())
                <div class="empty-section"><i class="ti ti-circle-check"></i> Tidak ada anomali pemakaian terdeteksi</div>
            @else
                @foreach ($anomali as $item)
                    <div class="alert-card level-sedang">
                        <div class="alert-icon sedang"><i class="ti ti-activity"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">{{ $item->nama_obat }}</div>
                            <div class="alert-desc">
                                Pemakaian bulan ini <strong>{{ number_format($item->bulan_ini) }} unit</strong>,
                                lonjakan <strong>{{ $item->persen_naik }}%</strong>
                                dari rata-rata bulan sebelumnya ({{ number_format($item->rata_rata) }} unit).
                            </div>
                            <div class="alert-meta">
                                <span><i class="ti ti-pill"></i> {{ $item->jenis }}</span>
                                <span><i class="ti ti-trending-up"></i> +{{ $item->persen_naik }}% dari rata-rata</span>
                            </div>
                        </div>
                        <div class="alert-action">
                            <span class="pill pill-info"><i class="ti ti-activity"></i> Anomali</span>
                            <a href="{{ route('manager.tren', ['obat_id' => $item->obat_id]) }}" class="btn-action">
                                <i class="ti ti-chart-line"></i> Lihat Tren
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

@endsection
