@extends('layouts.app')

@section('title', 'Approval Request')
@section('page-title', 'Approval Request')

@push('styles')
    <style>
        .ar-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .ar-title {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--tx-base);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ar-count {
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 600;
            background: var(--page-bg);
            border: 1px solid var(--border);
            color: var(--tx-muted);
            border-radius: 20px;
            padding: 2px 10px;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--sb-bg);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 14px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-new:hover {
            opacity: .85;
            color: #fff;
        }

        /* Filter bar */
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
        .filter-bar input[type="text"] {
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
        .filter-bar input[type="text"]:focus {
            border-color: var(--clr-blue);
        }

        .filter-bar input[type="text"] {
            flex: 1;
            min-width: 160px;
            max-width: 220px;
        }

        .filter-icon {
            color: var(--tx-muted);
            line-height: 0;
        }

        /* Card table */
        .ar-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 var(--radius) var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .ar-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .ar-table thead th {
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

        .ar-table tbody td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--tx-base);
        }

        .ar-table tbody tr:last-child td {
            border-bottom: none;
        }

        .ar-table tbody tr:hover {
            background: var(--page-bg);
        }

        /* Badges */
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
            background: #FEF3C7;
            color: #92400E;
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

        /* Avatar + name */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-blue), var(--clr-purple));
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Buttons */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            color: var(--clr-blue);
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: var(--radius-sm);
            padding: 4px 10px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
            font-weight: 500;
        }

        .btn-detail:hover {
            opacity: .8;
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
            opacity: .35;
        }

        /* Pagination */
        .ar-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            background: var(--card-bg);
            font-size: 12px;
            color: var(--tx-muted);
            border-radius: 0 0 var(--radius) var(--radius);
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
            background: var(--page-bg);
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        .no-result {
            color: var(--tx-sub);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .ar-topbar {
                flex-wrap: wrap;
                gap: 10px;
            }

            .ar-table thead th:nth-child(5),
            .ar-table tbody td:nth-child(5) {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    <div class="ar-topbar">
        <div class="ar-title">
            Daftar Approval Request
            <span class="ar-count">{{ $requests->total() }}</span>
        </div>

        @if (Auth::user()->role === 'admin')
            <a href="{{ route('approval-requests.create') }}" class="btn-new">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Buat Pengajuan
            </a>
        @endif
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('approval-requests.index') }}">
        <div class="filter-bar">
            <span class="filter-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                </svg>
            </span>

            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <select name="tipe" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="restock" {{ request('tipe') === 'restock' ? 'selected' : '' }}>Restock</option>
                <option value="supplier" {{ request('tipe') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                <option value="hapus_batch" {{ request('tipe') === 'hapus_batch' ? 'selected' : '' }}>Hapus Batch</option>
                <option value="tambah_obat" {{ request('tipe') === 'tambah_obat' ? 'selected' : '' }}>Tambah Obat</option>
            </select>

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                autocomplete="off">

            @if (request()->hasAny(['status', 'tipe', 'search']))
                <a href="{{ route('approval-requests.index') }}"
                    style="font-size:12px;color:var(--tx-muted);text-decoration:none;">
                    ✕ Reset
                </a>
            @endif
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
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $item)
                    <tr>
                        <td style="color:var(--tx-sub);font-size:11px">
                            {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                        </td>
                        <td style="font-weight:500;max-width:200px">{{ $item->judul }}</td>
                        <td>
                            <span class="badge badge-tipe">
                                {{ match ($item->tipe) {
                                    'restock' => 'Restock',
                                    'supplier' => 'Supplier',
                                    'hapus_batch' => 'Hapus Batch',
                                    'tambah_obat' => 'Tambah Obat',
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
                        <td style="color:var(--tx-muted);font-size:11.5px;white-space:nowrap">
                            {{ $item->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;align-items:center;">
                                <a href="{{ route('approval-requests.show', $item) }}" class="btn-detail">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Detail
                                </a>

                                {{-- Tombol Approve/Reject hanya untuk Manajer & status pending --}}
                                @if (Auth::user()->role === 'manajer' && $item->status === 'pending')
                                    <form action="{{ route('approval-requests.approve', $item) }}" method="POST"
                                        onsubmit="return confirm('Setujui pengajuan ini?')">
                                        @csrf
                                        <button type="submit"
                                            style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;
                    padding:4px 10px;border-radius:6px;border:1px solid #BBF7D0;
                    background:#DCFCE7;color:#166534;cursor:pointer;white-space:nowrap;">
                                            ✔ Approve
                                        </button>
                                    </form>

                                    <button
                                        onclick="openRejectModal({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                        style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;
                padding:4px 10px;border-radius:6px;border:1px solid #FECACA;
                background:#FEE2E2;color:#991B1B;cursor:pointer;white-space:nowrap;">
                                        ✕ Reject
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="9" y1="13" x2="15" y2="13" />
                                </svg>
                                <div>Belum ada pengajuan.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($requests->hasPages())
            <div class="ar-pagination">
                <span>Menampilkan {{ $requests->firstItem() }}–{{ $requests->lastItem() }} dari {{ $requests->total() }}
                    data</span>
                <div class="pag-links">
                    {{ $requests->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
    {{-- Modal Reject --}}
    <div id="rejectModal"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
    z-index:999;align-items:center;justify-content:center;">
        <div
            style="background:var(--card-bg);border:1px solid var(--border);border-radius:var(--radius);
        padding:24px;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.3);">
            <div style="font-size:14px;font-weight:700;color:var(--tx-base);margin-bottom:6px;">
                Tolak Pengajuan
            </div>
            <div id="rejectTitle" style="font-size:12px;color:var(--tx-muted);margin-bottom:16px;"></div>
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <label style="font-size:11.5px;font-weight:600;color:var(--tx-muted);display:block;margin-bottom:6px;">
                    Alasan Penolakan (opsional)
                </label>
                <textarea name="reason" rows="3"
                    style="width:100%;padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius-sm);
                background:var(--page-bg);color:var(--tx-base);font-family:'DM Sans',sans-serif;
                font-size:13px;outline:none;resize:vertical;box-sizing:border-box;"
                    placeholder="Isi alasan penolakan..."></textarea>
                <div style="display:flex;gap:8px;margin-top:14px;justify-content:flex-end;">
                    <button type="button" onclick="closeRejectModal()"
                        style="padding:7px 16px;border:1px solid var(--border);border-radius:6px;
                    background:none;color:var(--tx-muted);font-size:12.5px;cursor:pointer;">
                        Batal
                    </button>
                    <button type="submit"
                        style="padding:7px 16px;border:none;border-radius:6px;
                    background:#EF4444;color:#fff;font-size:12.5px;font-weight:600;cursor:pointer;">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openRejectModal(id, judul) {
                document.getElementById('rejectTitle').textContent = judul;
                document.getElementById('rejectForm').action = `/approval-requests/${id}/reject`;
                document.getElementById('rejectModal').style.display = 'flex';
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').style.display = 'none';
            }
            // Tutup modal klik di luar
            document.getElementById('rejectModal').addEventListener('click', function(e) {
                if (e.target === this) closeRejectModal();
            });
        </script>
    @endpush
@endsection
