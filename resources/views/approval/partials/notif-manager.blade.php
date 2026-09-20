{{--
    Partial: resources/views/approval/partials/notif-admin.blade.php

    Update bagian notif-list di layouts/app.blade.php:

    <div class="notif-list">
        @if (Auth::user()->role === 'manager')
            @include('approval.partials.notif-manager')
        @elseif(Auth::user()->role === 'admin')
            @include('approval.partials.notif-admin')
        @else
            <div class="notif-empty">Tidak ada notifikasi baru</div>
        @endif
    </div>
--}}

@php
    // Pengajuan yang baru diproses manager (approved/rejected) dalam 7 hari terakhir
    $notifHasil = \App\Models\ApprovalRequest::where('requested_by', Auth::id())
        ->whereIn('status', ['approved', 'rejected'])
        ->whereNotNull('approved_at')
        ->where('approved_at', '>=', now()->subDays(7))
        ->with('approver')
        ->latest('approved_at')
        ->take(5)
        ->get();

    // Pengajuan pending milik admin
    $notifPending = \App\Models\ApprovalRequest::where('requested_by', Auth::id())
        ->where('status', 'pending')
        ->latest()
        ->take(3)
        ->get();
@endphp

{{-- Hasil keputusan manager --}}
@foreach ($notifHasil as $notif)
    <a href="{{ route('approval-requests.show', $notif) }}"
        style="display:flex;gap:10px;padding:9px 14px;transition:background .12s;text-decoration:none;color:inherit;"
        onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">

        <div class="ni-icon {{ $notif->status === 'approved' ? 'ni-success' : 'ni-danger' }}">
            {{ $notif->status === 'approved' ? '✔' : '✕' }}
        </div>

        <div style="flex:1;min-width:0">
            <div class="notif-text" style="font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ $notif->judul }}
            </div>
            <div class="notif-text" style="color:#6B7280">
                {{ $notif->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                oleh {{ $notif->approver->name ?? 'Manager' }}
            </div>
            <div class="notif-time">{{ $notif->approved_at->diffForHumans() }}</div>
        </div>

        <div style="flex-shrink:0;align-self:center">
            <span
                style="font-size:9px;font-weight:700;border-radius:10px;padding:2px 7px;
                {{ $notif->status === 'approved' ? 'background:#DCFCE7;color:#166534;' : 'background:#FEE2E2;color:#991B1B;' }}">
                {{ strtoupper($notif->status) }}
            </span>
        </div>
    </a>
@endforeach

{{-- Pending milik admin --}}
@foreach ($notifPending as $notif)
    <a href="{{ route('approval-requests.show', $notif) }}"
        style="display:flex;gap:10px;padding:9px 14px;transition:background .12s;text-decoration:none;color:inherit;"
        onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">

        <div class="ni-icon ni-warning">⏳</div>

        <div style="flex:1;min-width:0">
            <div class="notif-text" style="font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ $notif->judul }}
            </div>
            <div class="notif-text" style="color:#6B7280">Menunggu persetujuan manager</div>
            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
        </div>

        <div style="flex-shrink:0;align-self:center">
            <span
                style="font-size:9px;font-weight:700;background:#FEF3C7;color:#92400E;border-radius:10px;padding:2px 7px;">
                PENDING
            </span>
        </div>
    </a>
@endforeach

@if ($notifHasil->isEmpty() && $notifPending->isEmpty())
    <div class="notif-empty">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5"
            style="margin-bottom:6px">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
        </svg>
        <div>Tidak ada notifikasi baru</div>
    </div>
@endif

@if ($notifHasil->count() + $notifPending->count() > 0)
    <div style="padding:10px 14px;text-align:center;border-top:1px solid #E5E7EB">
        <a href="{{ route('approval-requests.index') }}"
            style="font-size:12px;color:#3B82F6;text-decoration:none;font-weight:500">
            Lihat semua pengajuan →
        </a>
    </div>
@endif
