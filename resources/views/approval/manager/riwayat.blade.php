@extends('layouts.manager')

@section('title', 'Riwayat Keputusan')
@section('page-title', 'Riwayat Keputusan Saya')

@push('styles')
    <style>
        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            box-shadow: var(--shadow-card);
        }

        .stat-val {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1;
        }

        .stat-label {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 4px;
        }

        .stat-change {
            font-size: 11px;
            font-weight: 600;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .stat-up {
            color: var(--clr-green);
        }

        .stat-down {
            color: var(--clr-red);
        }

        /* ── Filter bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius) var(--radius) 0 0;
            flex-wrap: wrap;
        }

        .filter-bar select,
        .filter-bar input[type="date"] {
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            padding: 6px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            color: var(--tx-base);
            outline: none;
            transition: border-color .15s;
        }

        .filter-bar select:focus,
        .filter-bar input:focus {
            border-color: var(--clr-blue);
        }

        .filter-label {
            font-size: 11.5px;
            color: var(--tx-muted);
            white-space: nowrap;
        }

        /* ── Timeline list ── */
        .riwayat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 var(--radius) var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .riwayat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .riwayat-table thead th {
            background: var(--page-bg);
            color: var(--tx-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .riwayat-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .riwayat-table tbody tr:last-child td {
            border-bottom: none;
        }

        .riwayat-table tbody tr:hover {
            background: var(--page-bg);
        }

        /* Decision badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-approved {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-tipe {
            background: var(--page-bg);
            color: var(--tx-muted);
            border: 1px solid var(--border);
            font-weight: 500;
        }

        /* Decision indicator bar */
        .decision-bar {
            width: 3px;
            height: 36px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .decision-bar-approved {
            background: var(--clr-green);
        }

        .decision-bar-rejected {
            background: var(--clr-red);
        }

        .row-with-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* User chip */
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 3px 9px 3px 3px;
        }

        .user-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-blue), var(--clr-purple));
            color: #fff;
            font-size: 8px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-chip-name {
            font-size: 11.5px;
            font-weight: 500;
        }

        /* Detail link */
        .btn-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--clr-blue);
            text-decoration: none;
            font-weight: 500;
            transition: opacity .15s;
        }

        .btn-link:hover {
            opacity: .7;
            color: var(--clr-blue);
        }

        /* Empty state */
        .empty-state {
            padding: 56px 24px;
            text-align: center;
            color: var(--tx-muted);
            font-size: 13px;
        }

        .empty-state svg {
            margin-bottom: 10px;
            opacity: .3;
        }

        /* Pagination */
        .ar-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--tx-muted);
        }

        .ar-pagination .pag-links a,
        .ar-pagination .pag-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 12px;
            color: var(--tx-muted);
            text-decoration: none;
            margin: 0 1px;
            transition: all .15s;
        }

        .ar-pagination .pag-links span[aria-current="page"] {
            background: var(--sb-bg);
            color: #fff;
            border-color: var(--sb-bg);
        }

        .ar-pagination .pag-links a:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        /* Response time badge */
        .resp-time {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 10px;
            background: var(--page-bg);
            color: var(--tx-muted);
            border: 1px solid var(--border);
        }

        .resp-time.fast {
            background: #DCFCE7;
            color: #166534;
            border-color: #BBF7D0;
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .riwayat-table thead th:nth-child(4),
            .riwayat-table tbody td:nth-child(4) {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-val">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Keputusan</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:var(--clr-green)">{{ $stats['total_approved'] }}</div>
            <div class="stat-label">Disetujui</div>
            <div class="stat-change stat-up">
                ↑ {{ $totalKeputusan > 0 ? round(($totalApproved / $totalKeputusan) * 100) : 0 }}% approval rate
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:var(--clr-red)">{{ $stats['total_rejected'] }}</div>
            <div class="stat-label">Ditolak</div>
            <div class="stat-change stat-down">
                ↓ {{ $totalKeputusan > 0 ? round(($totalRejected / $totalKeputusan) * 100) : 0 }}% rejection rate
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-val">{{ $stats['avg_response'] ?? '-' }}</div>
            <div class="stat-label">Rata-rata Respons</div>
            <div class="stat-change" style="color:var(--tx-muted)">hari sejak pengajuan</div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('approval-requests.riwayat') }}">
        <div class="filter-bar">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--tx-muted)" stroke-width="2">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            </svg>

            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Keputusan</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <select name="tipe" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="restock" {{ request('tipe') === 'restock' ? 'selected' : '' }}>Restock</option>
                <option value="supplier" {{ request('tipe') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                <option value="hapus_batch" {{ request('tipe') === 'hapus_batch' ? 'selected' : '' }}>Hapus Batch</option>
                <option value="tambah_obat" {{ request('tipe') === 'tambah_obat' ? 'selected' : '' }}>Tambah Obat</option>
            </select>

            <span class="filter-label">Dari</span>
            <input type="date" name="dari" value="{{ request('dari') }}">
            <span class="filter-label">Sampai</span>
            <input type="date" name="sampai" value="{{ request('sampai') }}">

            <button type="submit"
                style="font-size:12px;padding:6px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--page-bg);color:var(--tx-base);cursor:pointer;">
                Cari
            </button>

            @if (request()->hasAny(['status', 'tipe', 'dari', 'sampai']))
                <a href="{{ route('approval-requests.riwayat') }}"
                    style="font-size:12px;color:var(--tx-muted);text-decoration:none;">✕ Reset</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="riwayat-card">
        <table class="riwayat-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengajuan</th>
                    <th>Tipe</th>
                    <th>Diajukan Oleh</th>
                    <th>Keputusan</th>
                    <th>Alasan</th>
                    <th>Waktu Respons</th>
                    <th>Tanggal Diproses</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <td style="font-size:12px;color:var(--clr-red);max-width:150px">
                    {{ $item->reject_reason ?? '-' }}
                </td>
                @forelse($riwayat as $item)
                    <tr>
                        <td style="color:var(--tx-sub);font-size:11px">
                            {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
                        </td>
                        <td style="max-width:200px">
                            <div class="row-with-bar">
                                <div class="decision-bar decision-bar-{{ $item->status }}"></div>
                                <div>
                                    <div style="font-weight:500;font-size:12.5px">{{ $item->judul }}</div>
                                    <div style="font-size:11px;color:var(--tx-muted)">ID #{{ $item->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-tipe">
                                {{ match ($item->tipe) {
                                    'restock' => '📦 Restock',
                                    'supplier' => '🏭 Supplier',
                                    'hapus_batch' => '🗑️ Hapus Batch',
                                    'tambah_obat' => '💊 Tambah Obat',
                                    default => $item->tipe,
                                } }}
                            </span>
                        </td>
                        <td>
                            @if ($item->requester)
                                <div class="user-chip">
                                    <div class="user-avatar">{{ strtoupper(substr($item->requester->name, 0, 2)) }}</div>
                                    <span class="user-chip-name">{{ $item->requester->name }}</span>
                                </div>
                            @else
                                <span style="color:var(--tx-sub)">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status === 'approved')
                                <span class="badge badge-approved">✔ Disetujui</span>
                            @else
                                <span class="badge badge-rejected">✕ Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $diffDays = $item->created_at->diffInDays($item->approved_at);
                            @endphp
                            <span class="resp-time {{ $diffDays == 0 ? 'fast' : '' }}">
                                {{ $diffDays == 0 ? 'Hari ini' : $diffDays . ' hari' }}
                            </span>
                        </td>
                        <td style="font-size:12px;color:var(--tx-muted);white-space:nowrap">
                            {{ $item->approved_at?->format('d M Y, H:i') ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('approval-requests.show', $item) }}" class="btn-link">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M9 11l3 3L22 4" />
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                </svg>
                                <div>Belum ada riwayat keputusan.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($riwayat->hasPages())
            <div class="ar-pagination">
                <span>Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }}
                    data</span>
                <div class="pag-links">
                    {{ $riwayat->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
