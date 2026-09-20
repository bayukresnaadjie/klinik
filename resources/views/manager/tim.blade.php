@extends('layouts.manager')

@section('title', 'Tim Farmasi')
@section('page_title', 'Tim Farmasi')
@section('page_subtitle', 'Kelola dan pantau aktivitas staff farmasi klinik')

@push('styles')
    <style>
        /* ── Summary Strip ── */
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

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .filter-select {
            font-size: 12px;
            padding: 6px 10px;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            background: var(--color-card-bg);
            color: var(--color-text-main);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--color-primary);
        }

        .filter-search {
            position: relative;
            margin-left: auto;
        }

        .filter-search i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: var(--color-text-hint);
            pointer-events: none;
        }

        .filter-search input {
            padding: 6px 12px 6px 30px;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            font-size: 12px;
            background: var(--color-card-bg);
            color: var(--color-text-main);
            width: 210px;
            outline: none;
        }

        .filter-search input:focus {
            border-color: var(--color-primary);
        }

        /* ── Team Grid ── */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .team-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px;
            transition: border-color .15s, box-shadow .15s;
        }

        .team-card:hover {
            border-color: var(--color-border-strong);
            box-shadow: var(--shadow-sm);
        }

        .team-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .team-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .team-avatar.inactive {
            background: var(--color-border-strong);
            color: var(--color-text-hint);
        }

        .team-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .team-role {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .team-status-dot {
            margin-left: auto;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-aktif {
            background: #1D9E75;
        }

        .dot-nonaktif {
            background: #9ca3af;
        }

        .team-divider {
            height: 1px;
            background: var(--color-border);
            margin-bottom: 12px;
        }

        .team-stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 6px;
            margin-bottom: 12px;
        }

        .team-stat {
            text-align: center;
            padding: 7px 4px;
            background: var(--color-content-bg);
            border-radius: var(--radius-md);
        }

        .team-stat-val {
            font-size: 16px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
        }

        .team-stat-lbl {
            font-size: 9px;
            color: var(--color-text-hint);
            margin-top: 2px;
        }

        .team-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .team-meta-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--color-text-muted);
        }

        .team-meta-row i {
            font-size: 13px;
            color: var(--color-text-hint);
        }

        /* ── Pill ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .pill-warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .pill-danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .pill-muted {
            background: var(--color-content-bg);
            color: var(--color-text-hint);
            border: 1px solid var(--color-border);
        }

        /* ── Aktivitas Table ── */
        .aktivitas-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .aktivitas-table thead th {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            text-align: left;
            padding: 7px 14px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .aktivitas-table tbody td {
            padding: 9px 14px;
            color: var(--color-text-muted);
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
        }

        .aktivitas-table tbody tr:last-child td {
            border-bottom: none;
        }

        .aktivitas-table tbody tr:hover td {
            background: var(--color-content-bg);
        }

        .staff-chip {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .staff-chip-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .staff-chip-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .staff-chip-role {
            font-size: 10px;
            color: var(--color-text-hint);
        }

        /* ── Section Label ── */
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

        /* ── Empty ── */
        .empty-state {
            text-align: center;
            padding: 40px 24px;
            color: var(--color-text-hint);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 36px;
            display: block;
            margin-bottom: 8px;
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

            .team-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-search {
                margin-left: 0;
                width: 100%;
            }

            .filter-search input {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── SUMMARY STRIP ── --}}
    <div class="summary-strip">
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-success-bg);color:var(--color-success-text)">
                <i class="ti ti-users"></i>
            </div>
            <div>
                <div class="strip-val">{{ $totalStaff }}</div>
                <div class="strip-lbl">Total Staff</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-info-bg);color:var(--color-info-text)">
                <i class="ti ti-user-check"></i>
            </div>
            <div>
                <div class="strip-val">{{ $staffAktif }}</div>
                <div class="strip-lbl">Staff Aktif</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-warning-bg);color:var(--color-warning-text)">
                <i class="ti ti-receipt"></i>
            </div>
            <div>
                <div class="strip-val">{{ $transaksiHariIni }}</div>
                <div class="strip-lbl">Transaksi Hari Ini</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-primary-light);color:var(--color-primary-dark)">
                <i class="ti ti-chart-bar"></i>
            </div>
            <div>
                <div class="strip-val">{{ $totalTransaksiBulanIni }}</div>
                <div class="strip-lbl">Transaksi Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('manager.tim') }}">
        <div class="filter-bar">

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="nama" {{ request('sort', 'nama') == 'nama' ? 'selected' : '' }}>Urut: Nama</option>
                <option value="transaksi" {{ request('sort') == 'transaksi' ? 'selected' : '' }}>Urut: Transaksi ↓
                </option>
                <option value="bergabung" {{ request('sort') == 'bergabung' ? 'selected' : '' }}>Urut: Bergabung
                </option>
            </select>

            <div class="filter-search">
                <i class="ti ti-search"></i>
                <input type="text" name="q" placeholder="Cari nama staff..." value="{{ request('q') }}"
                    onkeydown="if(event.key==='Enter')this.form.submit()">
            </div>

        </div>
    </form>

    {{-- ── TEAM GRID ── --}}
    <div class="section-label">Daftar staff farmasi</div>

    @if ($staffList->isEmpty())
        <div class="empty-state">
            <i class="ti ti-users"></i>
            Tidak ada staff ditemukan
        </div>
    @else
        <div class="team-grid" id="teamGrid">
            @foreach ($staffList as $staff)
                @php
                    $isAktif = $staff->aktif;
                    $inisial = strtoupper(
                        collect(explode(' ', $staff->name))
                            ->take(2)
                            ->map(fn($w) => substr($w, 0, 1))
                            ->join(''),
                    );
                @endphp
                <div class="team-card" data-search="{{ strtolower($staff->name) }}">
                    <div class="team-card-head">
                        <div class="team-avatar {{ $isAktif ? '' : 'inactive' }}">
                            {{ $inisial }}
                        </div>
                        <div style="flex:1; min-width:0">
                            <div class="team-name">{{ $staff->name }}</div>
                            <div class="team-role">{{ ucfirst($staff->role ?? 'Staff Farmasi') }}</div>
                        </div>
                        <span class="pill {{ $isAktif ? 'pill-ok' : 'pill-muted' }}">
                            {{ $isAktif ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <div class="team-divider"></div>

                    <div class="team-stats">
                        <div class="team-stat">
                            <div class="team-stat-val">{{ $staff->transaksi_bulan_ini }}</div>
                            <div class="team-stat-lbl">Transaksi<br>Bulan Ini</div>
                        </div>
                        <div class="team-stat">
                            <div class="team-stat-val">{{ $staff->transaksi_hari_ini }}</div>
                            <div class="team-stat-lbl">Transaksi<br>Hari Ini</div>
                        </div>
                        <div class="team-stat">
                            <div class="team-stat-val">{{ $staff->total_transaksi }}</div>
                            <div class="team-stat-lbl">Total<br>Semua</div>
                        </div>
                    </div>

                    <div class="team-meta">
                        <div class="team-meta-row">
                            <i class="ti ti-mail"></i>
                            {{ $staff->email }}
                        </div>
                        <div class="team-meta-row">
                            <i class="ti ti-calendar"></i>
                            Bergabung {{ \Carbon\Carbon::parse($staff->created_at)->translatedFormat('d M Y') }}
                        </div>
                        @if ($staff->last_activity)
                            <div class="team-meta-row">
                                <i class="ti ti-clock"></i>
                                Aktif terakhir: {{ \Carbon\Carbon::parse($staff->last_activity)->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── AKTIVITAS TERBARU ── --}}
    <div class="section-label" style="margin-top:8px">Aktivitas staff terbaru</div>
    <div class="card" style="padding:0; overflow:hidden">

        @if ($aktivitasTerbaru->isEmpty())
            <div class="empty-state" style="padding:32px">
                <i class="ti ti-inbox"></i>
                Belum ada aktivitas hari ini
            </div>
        @else
            <table class="aktivitas-table">
                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Aksi</th>
                        <th>Obat</th>
                        <th style="text-align:center">QTY</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aktivitasTerbaru as $aktivitas)
                        <tr>
                            <td>
                                <div class="staff-chip">
                                    <div class="staff-chip-avatar">
                                        {{ strtoupper(substr($aktivitas->user_name ?? 'S', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="staff-chip-name">{{ $aktivitas->user_name ?? '-' }}</div>
                                        <div class="staff-chip-role">{{ $aktivitas->user_role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="pill {{ $aktivitas->tipe === 'pemakaian' ? 'pill-info' : 'pill-ok' }}">
                                    {{ ucfirst($aktivitas->tipe) }}
                                </span>
                            </td>
                            <td style="font-weight:600; color:var(--color-text-main)">
                                {{ $aktivitas->nama_obat }}
                            </td>
                            <td style="text-align:center; font-weight:600">
                                {{ $aktivitas->qty }}
                            </td>
                            <td style="font-size:11px">
                                {{ \Carbon\Carbon::parse($aktivitas->waktu)->format('H:i') }}
                                <div style="color:var(--color-text-hint); font-size:10px">
                                    {{ \Carbon\Carbon::parse($aktivitas->waktu)->format('d M') }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        // Live search pada kartu tim
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                document.querySelectorAll('#teamGrid .team-card').forEach(card => {
                    card.style.display = card.dataset.search.includes(q) ? '' : 'none';
                });
            });
        }
    </script>
@endpush
