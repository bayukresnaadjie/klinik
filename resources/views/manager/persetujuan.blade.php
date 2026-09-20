@extends('layouts.manager')

@section('title', 'Persetujuan')
@section('page_title', 'Persetujuan')
@section('page_subtitle', 'Kelola permintaan yang memerlukan persetujuan manajer')

@push('styles')
<style>
    /* ── Filter Bar ── */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .filter-tab {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid var(--color-border-strong);
        background: none;
        color: var(--color-text-muted);
        cursor: pointer;
        transition: all .15s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .filter-tab:hover { background: var(--color-content-bg); color: var(--color-text-main); }
    .filter-tab.active {
        background: var(--color-primary);
        color: #fff;
        border-color: var(--color-primary);
    }
    .filter-tab .count {
        font-size: 10px;
        background: rgba(255,255,255,.25);
        padding: 1px 6px;
        border-radius: 20px;
    }
    .filter-tab:not(.active) .count {
        background: var(--color-content-bg);
        color: var(--color-text-hint);
    }
    .filter-search {
        margin-left: auto;
        position: relative;
    }
    .filter-search i {
        position: absolute;
        left: 10px; top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: var(--color-text-hint);
        pointer-events: none;
    }
    .filter-search input {
        padding: 6px 12px 6px 32px;
        border: 1px solid var(--color-border-strong);
        border-radius: var(--radius-md);
        font-size: 12px;
        background: var(--color-card-bg);
        color: var(--color-text-main);
        width: 220px;
        outline: none;
    }
    .filter-search input:focus { border-color: var(--color-primary); }

    /* ── Approval Cards ── */
    .approval-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 24px;
    }
    .approval-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: border-color .15s, box-shadow .15s;
    }
    .approval-card:hover {
        border-color: var(--color-border-strong);
        box-shadow: var(--shadow-sm);
    }
    .appr-icon {
        width: 40px; height: 40px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .appr-icon.warn   { background: var(--color-warning-bg); color: var(--color-warning-text); }
    .appr-icon.info   { background: var(--color-info-bg);    color: var(--color-info-text);    }
    .appr-icon.danger { background: var(--color-danger-bg);  color: var(--color-danger-text);  }
    .appr-icon.ok     { background: var(--color-success-bg); color: var(--color-success-text); }

    .appr-body { flex: 1; min-width: 0; }
    .appr-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        flex-wrap: wrap;
    }
    .appr-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--color-text-main);
    }
    .appr-meta {
        font-size: 11px;
        color: var(--color-text-muted);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .appr-meta span { display: flex; align-items: center; gap: 4px; }
    .appr-meta i { font-size: 12px; }
    .appr-detail {
        background: var(--color-content-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 10px 12px;
        font-size: 11.5px;
        color: var(--color-text-muted);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 6px 16px;
    }
    .appr-detail-item .label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .3px;
        color: var(--color-text-hint);
        margin-bottom: 1px;
    }
    .appr-detail-item .value {
        font-size: 12px;
        font-weight: 600;
        color: var(--color-text-main);
    }

    .appr-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex-shrink: 0;
        align-items: flex-end;
    }
    .btn-approve, .btn-reject, .btn-detail {
        font-size: 11px;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: var(--radius-md);
        border: 1px solid;
        cursor: pointer;
        transition: opacity .15s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .btn-approve {
        background: var(--color-success-bg);
        color: var(--color-success-text);
        border-color: #5DCAA5;
    }
    .btn-reject {
        background: var(--color-danger-bg);
        color: var(--color-danger-text);
        border-color: #F09595;
    }
    .btn-detail {
        background: none;
        color: var(--color-text-muted);
        border-color: var(--color-border-strong);
        font-weight: 500;
    }
    .btn-approve:hover, .btn-reject:hover, .btn-detail:hover { opacity: .75; }
    .appr-time {
        font-size: 10px;
        color: var(--color-text-hint);
        margin-top: 4px;
        text-align: right;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: var(--color-text-hint);
    }
    .empty-state i {
        font-size: 40px;
        display: block;
        margin-bottom: 10px;
        color: #1D9E75;
    }
    .empty-state p { font-size: 13px; }

    /* ── History Table ── */
    .history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }
    .history-table thead th {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--color-text-hint);
        text-align: left;
        padding: 6px 10px;
        border-bottom: 1px solid var(--color-border);
    }
    .history-table tbody td {
        padding: 9px 10px;
        color: var(--color-text-muted);
        border-bottom: 1px solid var(--color-border);
        vertical-align: middle;
    }
    .history-table tbody tr:last-child td { border-bottom: none; }
    .history-table tbody tr:hover td { background: var(--color-content-bg); }
    .drug-name { font-weight: 600; color: var(--color-text-main); }

    /* Section label */
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

    @media (max-width: 768px) {
        .approval-card { flex-direction: column; }
        .appr-actions  { flex-direction: row; width: 100%; }
        .btn-approve, .btn-reject, .btn-detail { flex: 1; justify-content: center; }
    }
</style>
@endpush

@section('content')

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
       class="filter-tab {{ request('status','pending') === 'pending' ? 'active' : '' }}">
        <i class="ti ti-clock"></i> Pending
        <span class="count">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}"
       class="filter-tab {{ request('status') === 'approved' ? 'active' : '' }}">
        <i class="ti ti-circle-check"></i> Disetujui
        <span class="count">{{ $counts['approved'] }}</span>
    </a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
       class="filter-tab {{ request('status') === 'rejected' ? 'active' : '' }}">
        <i class="ti ti-circle-x"></i> Ditolak
        <span class="count">{{ $counts['rejected'] }}</span>
    </a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
       class="filter-tab {{ request('status') === 'all' ? 'active' : '' }}">
        Semua
        <span class="count">{{ $counts['all'] }}</span>
    </a>

    <div class="filter-search">
        <i class="ti ti-search"></i>
        <input type="text"
               id="searchInput"
               placeholder="Cari permintaan..."
               value="{{ request('q') }}">
    </div>
</div>

{{-- ── PENDING APPROVALS ── --}}
@if(request('status', 'pending') === 'pending')

    @if($requests->isEmpty())
        <div class="empty-state">
            <i class="ti ti-circle-check"></i>
            <p>Semua permintaan sudah ditangani</p>
        </div>
    @else
        <div class="section-label">Menunggu persetujuan</div>
        <div class="approval-grid" id="approvalGrid">
            @foreach($requests as $req)
                <div class="approval-card" data-search="{{ strtolower($req->judul . ' ' . $req->deskripsi) }}">

                    <div class="appr-icon {{ $req->icon_type }}">
                        <i class="ti ti-{{ $req->icon }}"></i>
                    </div>

                    <div class="appr-body">
                        <div class="appr-header">
                            <span class="appr-title">{{ $req->judul }}</span>
                            <span class="pill pill-warn">Pending</span>
                        </div>
                        <div class="appr-meta">
                            <span>
                                <i class="ti ti-user"></i>
                                {{ $req->requestedBy->name ?? '-' }}
                            </span>
                            <span>
                                <i class="ti ti-calendar"></i>
                                {{ $req->created_at->format('d M Y') }}
                            </span>
                            <span>
                                <i class="ti ti-tag"></i>
                                {{ ucfirst(str_replace('_', ' ', $req->tipe)) }}
                            </span>
                        </div>
                        <div class="appr-detail">
                            @foreach($req->detail ?? [] as $key => $val)
                                <div class="appr-detail-item">
                                    <div class="label">{{ $key }}</div>
                                    <div class="value">{{ $val }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="appr-actions">
                        <form method="POST"
                              action="{{ route('manager.persetujuan.approve', $req->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-approve">
                                <i class="ti ti-check"></i> Setuju
                            </button>
                        </form>
                        <form method="POST"
                              action="{{ route('manager.persetujuan.reject', $req->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-reject">
                                <i class="ti ti-x"></i> Tolak
                            </button>
                        </form>
                        <div class="appr-time">
                            {{ $req->created_at->diffForHumans() }}
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

@else
{{-- ── HISTORY TABLE (approved / rejected / all) ── --}}

    <div class="section-label">Riwayat persetujuan</div>
    <div class="card">
        @if($requests->isEmpty())
            <div class="empty-state" style="padding:32px">
                <i class="ti ti-inbox" style="color:var(--color-text-hint)"></i>
                <p>Tidak ada data</p>
            </div>
        @else
            <table class="history-table" id="historyTable">
                <thead>
                    <tr>
                        <th>Permintaan</th>
                        <th>Tipe</th>
                        <th>Diajukan Oleh</th>
                        <th>Tanggal</th>
                        <th>Ditindak</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                        <tr data-search="{{ strtolower($req->judul . ' ' . $req->deskripsi) }}">
                            <td>
                                <span class="drug-name">{{ $req->judul }}</span>
                                <div style="font-size:11px; color:var(--color-text-hint)">
                                    {{ $req->deskripsi }}
                                </div>
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $req->tipe)) }}</td>
                            <td>{{ $req->requestedBy->name ?? '-' }}</td>
                            <td style="font-size:11px">
                                {{ $req->created_at->format('d M Y') }}<br>
                                <span style="color:var(--color-text-hint)">
                                    {{ $req->created_at->format('H:i') }}
                                </span>
                            </td>
                            <td style="font-size:11px">
                                {{ $req->updated_at->format('d M Y') }}<br>
                                <span style="color:var(--color-text-hint)">
                                    {{ $req->updated_at->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                @if($req->status === 'approved')
                                    <span class="pill pill-ok">
                                        <i class="ti ti-check" style="font-size:10px"></i>
                                        Disetujui
                                    </span>
                                @elseif($req->status === 'rejected')
                                    <span class="pill pill-danger">
                                        <i class="ti ti-x" style="font-size:10px"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="pill pill-warn">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Pagination --}}
    @if($requests instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div style="margin-top:14px; display:flex; justify-content:flex-end">
            {{ $requests->withQueryString()->links() }}
        </div>
    @endif

@endif

@endsection

@push('scripts')
<script>
    // Live search filter
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            const rows = document.querySelectorAll('[data-search]');
            rows.forEach(row => {
                row.style.display = row.dataset.search.includes(q) ? '' : 'none';
            });
        });
    }
</script>
@endpush
