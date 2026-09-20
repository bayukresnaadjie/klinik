@extends(Auth::user()->role === 'manajer' ? 'layouts.manager' : 'layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Approval Request')

@push('styles')
    <style>
        .ar-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--tx-muted);
            text-decoration: none;
            margin-bottom: 20px;
            transition: color .15s;
        }

        .ar-back:hover {
            color: var(--tx-base);
        }

        .ar-wrap {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 280px;
            gap: 16px;
            align-items: start;
        }

        @media (max-width: 768px) {
            .ar-wrap {
                grid-template-columns: 1fr;
            }
        }

        /* ── Card ── */
        .ar-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .ar-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
        }

        .ar-card-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .ar-badges {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .ar-judul {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1.3;
            margin: 0 0 5px;
        }

        .ar-meta {
            font-size: 12px;
            color: var(--tx-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-pending {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .badge-approved {
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #BBF7D0;
        }

        .badge-rejected {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .badge-tipe {
            background: var(--page-bg);
            color: var(--tx-muted);
            border: 1px solid var(--border);
            font-weight: 500;
        }

        /* Info rows */
        .ar-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ar-info-table td {
            padding: 13px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
            font-size: 13px;
        }

        .ar-info-table tr:last-child td {
            border-bottom: none;
        }

        .ar-info-key {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-muted);
            width: 150px;
            padding-top: 14px !important;
            white-space: nowrap;
        }

        .ar-info-val {
            color: var(--tx-base);
        }

        /* User chip */
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 10px 4px 4px;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: var(--page-bg);
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

        .user-chip-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--tx-base);
        }

        /* JSON detail */
        .ar-json {
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            font-family: monospace;
            font-size: 12px;
            color: var(--tx-muted);
            white-space: pre-wrap;
            word-break: break-all;
        }

        /* Proses lanjutan banner */
        .ar-proses-banner {
            background: #DCFCE7;
            border: 1px solid #BBF7D0;
            border-radius: var(--radius);
            padding: 16px 20px;
        }

        .ar-proses-title {
            font-size: 12px;
            font-weight: 600;
            color: #166534;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ar-proses-desc {
            font-size: 12px;
            color: #166534;
            opacity: .85;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .ar-proses-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            background: var(--card-bg);
            border: 1px solid #BBF7D0;
            font-size: 12.5px;
            font-weight: 600;
            color: #16a34a;
            text-decoration: none;
            transition: all .15s;
        }

        .ar-proses-btn:hover {
            background: #f0fdf4;
            color: #16a34a;
        }

        /* ── Sidebar ── */
        .ar-side-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 12px;
        }

        .ar-side-card:last-child {
            margin-bottom: 0;
        }

        .ar-side-header {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            text-transform: uppercase;
            letter-spacing: .07em;
            background: #FAFAFA;
        }

        .ar-side-body {
            padding: 16px;
        }

        /* Timeline */
        .ar-timeline {
            display: flex;
            flex-direction: column;
        }

        .ar-tl-item {
            display: flex;
            gap: 12px;
            padding-bottom: 16px;
        }

        .ar-tl-item:last-child {
            padding-bottom: 0;
        }

        .ar-tl-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
        }

        .ar-tl-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
            z-index: 1;
        }

        .ar-tl-dot-done {
            background: #DCFCE7;
            color: #166534;
        }

        .ar-tl-dot-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .ar-tl-dot-wait {
            background: var(--page-bg);
            color: var(--tx-sub);
            border: 1px solid var(--border);
        }

        .ar-tl-dot-reject {
            background: #FEE2E2;
            color: #991B1B;
        }

        .ar-tl-line {
            width: 1.5px;
            flex: 1;
            background: var(--border);
            margin-top: 4px;
            min-height: 12px;
        }

        .ar-tl-info {
            flex: 1;
            padding-top: 4px;
        }

        .ar-tl-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--tx-base);
            margin-bottom: 2px;
        }

        .ar-tl-sub {
            font-size: 11px;
            color: var(--tx-muted);
            line-height: 1.5;
        }

        /* Ringkasan rows */
        .ar-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .ar-summary-row:last-child {
            border-bottom: none;
        }

        .ar-summary-key {
            color: var(--tx-muted);
        }

        .ar-summary-val {
            font-weight: 600;
            color: var(--tx-base);
        }

        /* Action card (manager) */
        .ar-action-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-top: 12px;
        }

        .ar-action-header {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            text-transform: uppercase;
            letter-spacing: .07em;
            background: #FAFAFA;
        }

        .ar-action-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-approve {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: #16A34A;
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-approve:hover {
            opacity: .88;
        }

        .btn-reject {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: transparent;
            color: #991B1B;
            border: 1px solid #FECACA;
            border-radius: var(--radius-sm);
            padding: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-reject:hover {
            background: #FEE2E2;
        }

        .ar-action-note {
            font-size: 11px;
            color: var(--tx-sub);
            text-align: center;
        }

        .ar-reject-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            display: block;
            margin-bottom: 5px;
        }

        .ar-reject-textarea {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            color: var(--tx-base);
            outline: none;
            resize: vertical;
            transition: border-color .15s;
            box-sizing: border-box;
        }

        .ar-reject-textarea:focus {
            border-color: var(--clr-blue);
        }
    </style>
@endpush

@section('content')

    <a href="{{ route('approval-requests.index') }}" class="ar-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6" />
        </svg>
        Kembali ke daftar
    </a>

    <div class="ar-wrap">

        {{-- ── KIRI: Detail utama ── --}}
        <div style="display:flex;flex-direction:column;gap:12px;">

            {{-- Card utama --}}
            <div class="ar-card">
                <div class="ar-card-header">
                    <div class="ar-card-header-top">
                        <div style="flex:1;min-width:0;">
                            <div class="ar-badges">
                                <span class="badge badge-tipe">
                                    {{ match ($approvalRequest->tipe) {
                                        'restock' => '📦 Restock',
                                        'supplier' => '🏭 Supplier',
                                        'hapus_batch' => '🗑️ Hapus Batch',
                                        'tambah_obat' => '💊 Tambah Obat',
                                        default => $approvalRequest->tipe,
                                    } }}
                                </span>
                                <span style="font-size:11.5px;color:var(--tx-sub);">ID #{{ $approvalRequest->id }}</span>
                            </div>
                            <h1 class="ar-judul">{{ $approvalRequest->judul }}</h1>
                            <div class="ar-meta">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                {{ $approvalRequest->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div style="flex-shrink:0;">
                            @if ($approvalRequest->status === 'pending')
                                <span class="badge badge-pending">⏳ Pending</span>
                            @elseif($approvalRequest->status === 'approved')
                                <span class="badge badge-approved">✔ Approved</span>
                            @else
                                <span class="badge badge-rejected">✕ Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>

                <table class="ar-info-table">
                    <tr>
                        <td class="ar-info-key">Tipe pengajuan</td>
                        <td class="ar-info-val">
                            <span class="badge badge-tipe">
                                {{ match ($approvalRequest->tipe) {
                                    'restock' => '📦 Restock',
                                    'supplier' => '🏭 Supplier',
                                    'hapus_batch' => '🗑️ Hapus Batch',
                                    'tambah_obat' => '💊 Tambah Obat',
                                    default => $approvalRequest->tipe,
                                } }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="ar-info-key">Deskripsi</td>
                        <td class="ar-info-val"
                            style="{{ !$approvalRequest->deskripsi ? 'color:var(--tx-sub);font-style:italic;' : '' }}">
                            {{ $approvalRequest->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="ar-info-key">Diajukan oleh</td>
                        <td class="ar-info-val">
                            @if ($approvalRequest->requester)
                                <div class="user-chip">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($approvalRequest->requester->name, 0, 2)) }}</div>
                                    <span class="user-chip-name">{{ $approvalRequest->requester->name }}</span>
                                </div>
                            @else
                                <span style="color:var(--tx-sub);font-style:italic;">-</span>
                            @endif
                        </td>
                    </tr>
                    @if ($approvalRequest->approver)
                        <tr>
                            <td class="ar-info-key">
                                {{ $approvalRequest->status === 'approved' ? 'Disetujui oleh' : 'Ditolak oleh' }}
                            </td>
                            <td class="ar-info-val">
                                <div class="user-chip"
                                    style="border-color:{{ $approvalRequest->status === 'approved' ? '#BBF7D0' : '#FECACA' }};background:{{ $approvalRequest->status === 'approved' ? '#F0FDF4' : '#FEF2F2' }}">
                                    <div class="user-avatar"
                                        style="background:{{ $approvalRequest->status === 'approved' ? 'linear-gradient(135deg,#16A34A,#15803D)' : 'linear-gradient(135deg,#DC2626,#B91C1C)' }}">
                                        {{ strtoupper(substr($approvalRequest->approver->name, 0, 2)) }}
                                    </div>
                                    <span class="user-chip-name">{{ $approvalRequest->approver->name }}</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if ($approvalRequest->approved_at)
                        <tr>
                            <td class="ar-info-key">Tanggal diproses</td>
                            <td class="ar-info-val">{{ $approvalRequest->approved_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endif
                    @if ($approvalRequest->status === 'rejected' && $approvalRequest->reject_reason)
                        <tr>
                            <td class="ar-info-key">Alasan penolakan</td>
                            <td class="ar-info-val" style="color:#991B1B;">{{ $approvalRequest->reject_reason }}</td>
                        </tr>
                    @endif
                    @if ($approvalRequest->detail)
                        <tr>
                            <td class="ar-info-key">Detail tambahan</td>
                            <td class="ar-info-val">
                                <div class="ar-json">
                                    {{ json_encode($approvalRequest->detail, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            {{-- Proses lanjutan (admin, approved) --}}
            @if (Auth::user()->role === 'admin' && $approvalRequest->status === 'approved')
                <div class="ar-proses-banner">
                    <div class="ar-proses-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                        Proses lanjutan
                    </div>
                    <p class="ar-proses-desc">Pengajuan telah disetujui. Silakan lanjutkan proses sesuai tipe pengajuan.</p>
                    @if ($approvalRequest->tipe === 'restock')
                        <a href="{{ route('stok-obat.create') }}" class="ar-proses-btn">
                            📦 Tambah stok obat
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @elseif($approvalRequest->tipe === 'tambah_obat')
                        <a href="{{ route('master.obat.create') }}" class="ar-proses-btn">
                            💊 Tambah obat baru
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @elseif($approvalRequest->tipe === 'supplier')
                        <a href="{{ route('admin.supplier.create') }}" class="ar-proses-btn">
                            🏭 Tambah supplier
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @elseif($approvalRequest->tipe === 'hapus_batch')
                        <a href="{{ route('stok-obat.index') }}" class="ar-proses-btn">
                            🗑️ Kelola stok obat
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @endif
                </div>
            @endif

        </div>

        {{-- ── KANAN: Sidebar ── --}}
        <div>

            {{-- Timeline --}}
            <div class="ar-side-card">
                <div class="ar-side-header">Status pengajuan</div>
                <div class="ar-side-body">
                    <div class="ar-timeline">

                        <div class="ar-tl-item">
                            <div class="ar-tl-left">
                                <div class="ar-tl-dot ar-tl-dot-done">✔</div>
                                <div class="ar-tl-line"></div>
                            </div>
                            <div class="ar-tl-info">
                                <div class="ar-tl-label">Pengajuan dibuat</div>
                                <div class="ar-tl-sub">{{ $approvalRequest->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        <div class="ar-tl-item">
                            <div class="ar-tl-left">
                                @if ($approvalRequest->status === 'pending')
                                    <div class="ar-tl-dot ar-tl-dot-pending">⏳</div>
                                @elseif($approvalRequest->status === 'approved')
                                    <div class="ar-tl-dot ar-tl-dot-done">✔</div>
                                @else
                                    <div class="ar-tl-dot ar-tl-dot-reject">✕</div>
                                @endif
                                <div class="ar-tl-line"></div>
                            </div>
                            <div class="ar-tl-info">
                                <div class="ar-tl-label">
                                    @if ($approvalRequest->status === 'pending')
                                        Menunggu review
                                    @elseif($approvalRequest->status === 'approved')
                                        Disetujui manager
                                    @else
                                        Ditolak manager
                                    @endif
                                </div>
                                <div class="ar-tl-sub">
                                    @if ($approvalRequest->approved_at)
                                        {{ $approvalRequest->approved_at->format('d M Y, H:i') }}
                                        @if ($approvalRequest->approver)
                                            · {{ $approvalRequest->approver->name }}
                                        @endif
                                    @else
                                        Menunggu tindakan manager
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="ar-tl-item">
                            <div class="ar-tl-left">
                                <div
                                    class="ar-tl-dot {{ $approvalRequest->status === 'approved' ? 'ar-tl-dot-done' : 'ar-tl-dot-wait' }}">
                                    {{ $approvalRequest->status === 'approved' ? '✔' : '○' }}
                                </div>
                            </div>
                            <div class="ar-tl-info">
                                <div class="ar-tl-label">Selesai</div>
                                <div class="ar-tl-sub">
                                    {{ $approvalRequest->status === 'approved' ? 'Pengajuan berhasil diproses' : 'Belum selesai' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="ar-side-card">
                <div class="ar-side-header">Ringkasan</div>
                <div class="ar-side-body" style="padding:12px 16px;">
                    <div class="ar-summary-row">
                        <span class="ar-summary-key">Status</span>
                        <span class="ar-summary-val">
                            @if ($approvalRequest->status === 'pending')
                                <span style="color:#92400E;">⏳ Pending</span>
                            @elseif($approvalRequest->status === 'approved')
                                <span style="color:#166534;">✔ Approved</span>
                            @else
                                <span style="color:#991B1B;">✕ Rejected</span>
                            @endif
                        </span>
                    </div>
                    <div class="ar-summary-row">
                        <span class="ar-summary-key">Tipe</span>
                        <span class="ar-summary-val">{{ ucfirst(str_replace('_', ' ', $approvalRequest->tipe)) }}</span>
                    </div>
                    <div class="ar-summary-row">
                        <span class="ar-summary-key">Dibuat</span>
                        <span class="ar-summary-val">{{ $approvalRequest->created_at->format('d M Y') }}</span>
                    </div>
                    @if ($approvalRequest->approved_at)
                        <div class="ar-summary-row">
                            <span class="ar-summary-key">Diproses</span>
                            <span class="ar-summary-val">{{ $approvalRequest->approved_at->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tombol Approve/Reject — hanya Manager, status pending --}}
            @if (Auth::user()->role === 'manajer' && $approvalRequest->status === 'pending')
                <div class="ar-action-card">
                    <div class="ar-action-header">Tindakan manager</div>
                    <div class="ar-action-body">

                        <form action="{{ route('approval-requests.approve', $approvalRequest) }}" method="POST"
                            id="form-approve">
                            @csrf
                            <button type="button" class="btn-approve" onclick="confirmApprove()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Setujui pengajuan
                            </button>
                        </form>

                        <form action="{{ route('approval-requests.reject', $approvalRequest) }}" method="POST"
                            id="form-reject">
                            @csrf
                            <div style="margin-bottom:8px;">
                                <label class="ar-reject-label">
                                    Alasan penolakan
                                    <span style="font-weight:400;font-style:italic;">(opsional)</span>
                                </label>
                                <textarea name="reason" rows="2" class="ar-reject-textarea" placeholder="Jelaskan alasan penolakan..."></textarea>
                            </div>
                            <button type="button" class="btn-reject" onclick="confirmReject()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                                Tolak pengajuan
                            </button>
                        </form>

                        <p class="ar-action-note">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function confirmApprove() {
            if (confirm('Setujui pengajuan ini? Tindakan tidak dapat dibatalkan.')) {
                document.getElementById('form-approve').submit();
            }
        }

        function confirmReject() {
            if (confirm('Tolak pengajuan ini? Tindakan tidak dapat dibatalkan.')) {
                document.getElementById('form-reject').submit();
            }
        }
    </script>
@endpush
