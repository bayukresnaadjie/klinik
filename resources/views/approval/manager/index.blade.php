@extends('layouts.manager')

@section('page_title', 'Approval Request')
@section('page_subtitle', 'Kelola pengajuan dari tim farmasi')

@push('styles')
    <style>
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .sum-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sum-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .sum-icon-pending {
            background: var(--color-warning-bg);
        }

        .sum-icon-approved {
            background: var(--color-success-bg);
        }

        .sum-icon-rejected {
            background: var(--color-danger-bg);
        }

        .sum-val {
            font-size: 22px;
            font-weight: 700;
            color: var(--color-text-main);
            line-height: 1;
        }

        .sum-label {
            font-size: 11.5px;
            color: var(--color-text-muted);
            margin-top: 3px;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            flex-wrap: wrap;
        }

        .filter-bar select,
        .filter-bar input[type="text"] {
            font-size: 12px;
            padding: 6px 10px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            background: var(--color-content-bg);
            color: var(--color-text-main);
            outline: none;
            font-family: inherit;
        }

        .filter-bar input[type="text"] {
            flex: 1;
            min-width: 160px;
            max-width: 220px;
        }

        .filter-tabs {
            display: flex;
            gap: 4px;
            margin-left: auto;
        }

        .filter-tab {
            font-size: 12px;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            background: var(--color-content-bg);
            color: var(--color-text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all .15s;
        }

        .filter-tab:hover {
            background: var(--color-card-bg);
            color: var(--color-text-main);
        }

        .filter-tab.active {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
        }

        .tab-count {
            font-size: 10px;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .25);
        }

        .filter-tab:not(.active) .tab-count {
            background: var(--color-border);
            color: var(--color-text-muted);
        }

        .ar-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-top: none;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            overflow: hidden;
        }

        .ar-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .ar-table thead th {
            background: var(--color-content-bg);
            color: var(--color-text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .ar-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
            color: var(--color-text-main);
        }

        .ar-table tbody tr:last-child td {
            border-bottom: none;
        }

        .ar-table tbody tr:hover {
            background: var(--color-content-bg);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-pending {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .badge-approved {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .badge-rejected {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .badge-tipe {
            background: var(--color-content-bg);
            color: var(--color-text-muted);
            border: 1px solid var(--color-border);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .days-badge {
            font-size: 10.5px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 10px;
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .days-badge.urgent {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .btn-review {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            background: var(--color-primary);
            border: none;
            border-radius: var(--radius-sm);
            padding: 6px 12px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-review:hover {
            opacity: .85;
            color: #fff;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--color-primary);
            background: var(--color-primary-light);
            border: 1px solid var(--color-primary-light);
            border-radius: var(--radius-sm);
            padding: 5px 11px;
            text-decoration: none;
            font-weight: 500;
            transition: opacity .15s;
        }

        .btn-detail:hover {
            opacity: .8;
        }

        .empty-state {
            padding: 56px 24px;
            text-align: center;
            color: var(--color-text-muted);
            font-size: 13px;
        }

        .empty-state i {
            font-size: 36px;
            opacity: .3;
            display: block;
            margin-bottom: 10px;
        }

        .ar-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--color-border);
            font-size: 12px;
            color: var(--color-text-muted);
        }
    </style>
@endpush

@section('content')

    {{-- Summary --}}
    <div class="summary-grid">
        <div class="sum-card">
            <div class="sum-icon sum-icon-pending">⏳</div>
            <div>
                <div class="sum-val">{{ $counts['pending'] }}</div>
                <div class="sum-label">Menunggu Review</div>
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-icon sum-icon-approved">✔</div>
            <div>
                <div class="sum-val">{{ $counts['approved'] }}</div>
                <div class="sum-label">Disetujui</div>
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-icon sum-icon-rejected">✕</div>
            <div>
                <div class="sum-val">{{ $counts['rejected'] }}</div>
                <div class="sum-label">Ditolak</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('approval-requests.index') }}">
        <div class="filter-bar">
            <i class="ti ti-filter" style="color:var(--color-text-muted)"></i>

            <select name="tipe" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="restock" {{ request('tipe') === 'restock' ? 'selected' : '' }}>Restock</option>
                <option value="supplier" {{ request('tipe') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                <option value="hapus_batch" {{ request('tipe') === 'hapus_batch' ? 'selected' : '' }}>Hapus Batch</option>
                <option value="tambah_obat" {{ request('tipe') === 'tambah_obat' ? 'selected' : '' }}>Tambah Obat</option>
            </select>

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                autocomplete="off">

            @if (request()->hasAny(['tipe', 'search']))
                <a href="{{ route('approval-requests.index') }}"
                    style="font-size:12px;color:var(--color-text-muted);text-decoration:none;">✕ Reset</a>
            @endif

            <div class="filter-tabs">
                <a href="{{ route('approval-requests.index') }}"
                    class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    Semua <span class="tab-count">{{ $counts['all'] }}</span>
                </a>
                <a href="{{ route('approval-requests.index', ['status' => 'pending']) }}"
                    class="filter-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                    Pending <span class="tab-count">{{ $counts['pending'] }}</span>
                </a>
                <a href="{{ route('approval-requests.index', ['status' => 'approved']) }}"
                    class="filter-tab {{ request('status') === 'approved' ? 'active' : '' }}">
                    Approved <span class="tab-count">{{ $counts['approved'] }}</span>
                </a>
                <a href="{{ route('approval-requests.index', ['status' => 'rejected']) }}"
                    class="filter-tab {{ request('status') === 'rejected' ? 'active' : '' }}">
                    Rejected <span class="tab-count">{{ $counts['rejected'] }}</span>
                </a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="ar-card">
        <table class="ar-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Diajukan Oleh</th>
                    <th>Menunggu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $item)
                    <tr>
                        <td style="color:var(--color-text-muted);font-size:11px">
                            {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                        </td>
                        <td style="font-weight:500;max-width:200px">{{ $item->judul }}</td>
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
                            @if ($item->status === 'pending')
                                <span class="badge badge-pending">⏳ Pending</span>
                            @elseif($item->status === 'approved')
                                <span class="badge badge-approved">✔ Approved</span>
                            @else
                                <span class="badge badge-rejected">✕ Rejected</span>
                            @endif
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($item->requester->name ?? 'U', 0, 2)) }}
                                </div>
                                {{ $item->requester->name ?? '-' }}
                            </div>
                        </td>
                        <td>
                            @if ($item->status === 'pending')
                                @php $days = (int) $item->created_at->diffInDays(now()); @endphp
                                <span class="days-badge {{ $days >= 2 ? 'urgent' : '' }}">
                                    {{ $days == 0 ? 'Hari ini' : $days . ' hari' }}
                                </span>
                            @else
                                <span style="color:var(--color-text-muted);font-size:12px">
                                    {{ $item->approved_at?->format('d/m/Y') ?? '-' }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status === 'pending')
                                <a href="{{ route('approval-requests.show', $item) }}" class="btn-review">
                                    <i class="ti ti-clipboard-check"></i> Review
                                </a>
                            @else
                                <a href="{{ route('approval-requests.show', $item) }}" class="btn-detail">
                                    <i class="ti ti-eye"></i> Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-file-off"></i>
                                <div>Tidak ada pengajuan ditemukan.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($requests->hasPages())
            <div class="ar-pagination">
                <span>Menampilkan {{ $requests->firstItem() }}–{{ $requests->lastItem() }} dari {{ $requests->total() }}
                    data</span>
                <div>{{ $requests->appends(request()->query())->links() }}</div>
            </div>
        @endif
    </div>

@endsection
