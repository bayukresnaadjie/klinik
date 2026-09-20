{{-- resources/views/stok_obat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Stok Obat')

@section('content')

    <style>
        /* ─── Google Fonts ─────────────────────────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        /* ─── Scoped Variables ─────────────────────────────────────────────── */
        .so {
            --so-gold: #C9A84C;
            --so-gold-hover: #b8932f;
            --so-gold-dim: rgba(201, 168, 76, 0.12);
            --so-gold-dimmer: rgba(201, 168, 76, 0.06);

            /* surface: ikut background konten area (bukan sidebar) */
            --so-surface: rgba(255, 255, 255, 0.04);
            --so-surface-hover: rgba(255, 255, 255, 0.07);
            --so-surface-input: rgba(255, 255, 255, 0.06);

            /* border */
            --so-border: rgba(255, 255, 255, 0.09);
            --so-border-hover: rgba(201, 168, 76, 0.5);

            /* text */
            --so-text-primary: #E8E8E0;
            --so-text-muted: #8A97A8;
            --so-text-faint: #5A6472;

            /* radius */
            --so-radius: 10px;
            --so-radius-sm: 7px;

            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            color: var(--so-text-primary);
        }

        /* ─── Page Header ──────────────────────────────────────────────────── */
        .so-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .so-header-title h4 {
            font-size: 21px;
            font-weight: 700;
            color: var(--so-text-primary);
            letter-spacing: -0.4px;
            margin: 0 0 3px;
        }

        .so-header-title p {
            font-size: 12px;
            color: var(--so-text-muted);
            margin: 0;
        }

        /* ─── Live indicator ──────────────────────────────────────────────── */
        .so-live {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--so-text-faint);
            margin-top: 6px;
        }

        .so-live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ADE80;
            box-shadow: 0 0 0 0 rgba(74, 222, 128, .6);
            animation: soLivePulse 2s infinite;
        }

        .so-live-dot.is-syncing {
            background: #FCD34D;
            animation: none;
        }

        @keyframes soLivePulse {
            0% {
                box-shadow: 0 0 0 0 rgba(74, 222, 128, .55);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(74, 222, 128, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(74, 222, 128, 0);
            }
        }

        /* ─── Buttons ──────────────────────────────────────────────────────── */
        .so-btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .so-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            border-radius: var(--so-radius-sm);
            font-size: 12.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            border: 1px solid;
            transition: all 0.15s ease;
            white-space: nowrap;
            line-height: 1;
        }

        .so-btn-outline {
            background: var(--so-surface);
            border-color: var(--so-border);
            color: var(--so-text-muted);
        }

        .so-btn-outline:hover {
            border-color: var(--so-gold);
            color: var(--so-gold);
            background: var(--so-gold-dimmer);
        }

        .so-btn-gold {
            background: var(--so-gold);
            border-color: var(--so-gold);
            color: #1a1208 !important;
            font-weight: 600;
        }

        .so-btn-gold:hover {
            background: var(--so-gold-hover);
            border-color: var(--so-gold-hover);
        }

        .so-btn-import {
            background: rgba(6, 95, 70, 0.25);
            border-color: rgba(52, 211, 153, 0.25);
            color: #6EE7B7;
        }

        .so-btn-import:hover {
            background: rgba(6, 95, 70, 0.4);
            border-color: rgba(52, 211, 153, 0.4);
        }

        /* ─── Alerts ───────────────────────────────────────────────────────── */
        .so-alerts {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 18px;
        }

        .so-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            border-radius: var(--so-radius);
            font-size: 12.5px;
            font-weight: 500;
        }

        .so-alert-success {
            background: rgba(6, 95, 70, 0.2);
            color: #6EE7B7;
            border: 1px solid rgba(52, 211, 153, 0.2);
        }

        .so-alert-danger {
            background: rgba(153, 27, 27, 0.2);
            color: #FCA5A5;
            border: 1px solid rgba(252, 165, 165, 0.2);
        }

        .so-alert-warning {
            background: rgba(146, 64, 14, 0.2);
            color: #FCD34D;
            border: 1px solid rgba(252, 211, 77, 0.2);
        }

        .so-alert a {
            margin-left: auto;
            font-size: 11.5px;
            color: inherit;
            opacity: 0.75;
            text-decoration: underline !important;
            white-space: nowrap;
        }

        .so-btn-close {
            background: none;
            border: none;
            font-size: 17px;
            cursor: pointer;
            color: inherit;
            opacity: 0.55;
            padding: 0 0 0 6px;
            line-height: 1;
            margin-left: auto;
        }

        .so-btn-close:hover {
            opacity: 1;
        }

        /* ─── Filter Card ──────────────────────────────────────────────────── */
        .so-filter-card {
            background: var(--so-surface);
            border: 1px solid var(--so-border);
            border-radius: var(--so-radius);
            padding: 14px 18px;
            margin-bottom: 16px;
        }

        .so-filter-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .so-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .so-search-wrap svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--so-text-muted);
            pointer-events: none;
            opacity: 0.6;
        }

        .so-input {
            width: 100%;
            padding: 8px 11px 8px 34px;
            border: 1px solid var(--so-border);
            border-radius: var(--so-radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            color: var(--so-text-primary);
            background-color: #2a2d35;
            outline: none;
            transition: border-color 0.15s;
            color-scheme: dark;
        }

        .so-input:focus {
            border-color: var(--so-gold);
            background-color: #2f323b;
        }

        .so-input::placeholder {
            color: var(--so-text-faint);
        }

        .so-select,
        .so-date {
            padding: 8px 10px;
            border: 1px solid var(--so-border);
            border-radius: var(--so-radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            color: var(--so-text-primary);
            background-color: #2a2d35;
            outline: none;
            cursor: pointer;
            transition: border-color 0.15s;
            -webkit-appearance: auto;
            appearance: auto;
            color-scheme: dark;
        }

        .so-select:focus,
        .so-date:focus {
            border-color: var(--so-gold);
            background-color: #2f323b;
        }

        .so-select option,
        .so-date option {
            background-color: #2a2d35;
            color: #E8E8E0;
        }

        .so-date {
            width: 148px;
        }

        /* fix: browser date picker icon warna gelap */
        .so-date::-webkit-calendar-picker-indicator {
            filter: invert(0.7);
            cursor: pointer;
        }

        .so-date-sep {
            font-size: 12px;
            color: var(--so-text-faint);
            align-self: center;
            flex-shrink: 0;
        }

        .so-btn-reset {
            padding: 8px 13px;
            border: 1px solid var(--so-border);
            border-radius: var(--so-radius-sm);
            font-size: 12px;
            color: var(--so-text-muted);
            background: none;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .so-btn-reset:hover {
            color: #FCA5A5;
            border-color: rgba(252, 165, 165, 0.3);
            background: rgba(153, 27, 27, 0.15);
        }

        /* ─── Main Card ────────────────────────────────────────────────────── */
        .so-card {
            background: var(--so-surface);
            border: 1px solid var(--so-border);
            border-radius: var(--so-radius);
            overflow: hidden;
        }

        .so-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--so-border);
            background: linear-gradient(90deg, var(--so-gold-dimmer) 0%, transparent 60%);
        }

        .so-card-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: var(--so-text-primary);
            margin: 0;
        }

        .so-card-header-right {
            font-size: 12px;
            color: var(--so-text-muted);
        }

        .so-card-header-right a {
            color: var(--so-gold);
            text-decoration: none !important;
        }

        .so-card-header-right a:hover {
            text-decoration: underline !important;
        }

        /* ─── Empty State ──────────────────────────────────────────────────── */
        .so-empty {
            padding: 56px 20px;
            text-align: center;
            color: var(--so-text-muted);
        }

        .so-empty svg {
            opacity: 0.2;
            margin-bottom: 14px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .so-empty-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--so-text-primary);
            opacity: 0.6;
        }

        .so-empty-sub {
            font-size: 12.5px;
            margin-top: 4px;
        }

        /* ─── Table ────────────────────────────────────────────────────────── */
        .so-table-wrap {
            overflow-x: auto;
        }

        .so-table {
            width: 100%;
            border-collapse: collapse;
        }

        .so-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            color: var(--so-text-faint);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid var(--so-border);
            white-space: nowrap;
        }

        .so-table thead th.thc {
            text-align: center;
        }

        .so-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            transition: background 0.1s;
        }

        .so-table tbody tr:last-child {
            border-bottom: none;
        }

        .so-table tbody tr:hover {
            background: var(--so-surface-hover);
        }

        .so-table tbody tr.row-expired {
            background: rgba(153, 27, 27, 0.1);
        }

        .so-table tbody tr.row-expired:hover {
            background: rgba(153, 27, 27, 0.17);
        }

        .so-table tbody tr.row-kritis {
            background: rgba(146, 64, 14, 0.1);
        }

        .so-table tbody tr.row-kritis:hover {
            background: rgba(146, 64, 14, 0.17);
        }

        .so-table td {
            padding: 11px 14px;
            vertical-align: middle;
        }

        .so-table td.tdc {
            text-align: center;
        }

        /* cells */
        .so-td-no {
            color: var(--so-text-faint);
            font-size: 12px;
        }

        .so-drug-name {
            font-weight: 600;
            font-size: 13.5px;
            color: var(--so-text-primary);
            line-height: 1.3;
        }

        .so-drug-dose {
            font-size: 11.5px;
            color: var(--so-text-muted);
            font-weight: 400;
            margin-left: 4px;
        }

        .so-drug-sub {
            font-size: 11px;
            color: var(--so-text-faint);
            margin-top: 2px;
        }

        .so-batch {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            color: var(--so-text-muted);
            letter-spacing: 0.3px;
        }

        .so-qty {
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
        }

        .so-qty-ok {
            color: var(--so-text-primary);
        }

        .so-qty-empty {
            color: #F87171;
        }

        .so-date {
            font-size: 12.5px;
            color: var(--so-text-muted);
            white-space: nowrap;
        }

        .so-date-danger {
            font-size: 12.5px;
            color: #FCA5A5;
            font-weight: 600;
            white-space: nowrap;
        }

        .so-date-warning {
            font-size: 12.5px;
            color: #FCD34D;
            font-weight: 600;
            white-space: nowrap;
        }

        /* badges */
        .so-badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .so-badge-expired {
            background: rgba(153, 27, 27, 0.25);
            color: #FCA5A5;
            border: 1px solid rgba(252, 165, 165, 0.2);
        }

        .so-badge-kritis {
            background: rgba(146, 64, 14, 0.25);
            color: #FCD34D;
            border: 1px solid rgba(252, 211, 77, 0.2);
        }

        .so-badge-warning {
            background: rgba(30, 64, 175, 0.25);
            color: #93C5FD;
            border: 1px solid rgba(147, 197, 253, 0.2);
        }

        .so-badge-aman {
            background: rgba(6, 95, 70, 0.25);
            color: #6EE7B7;
            border: 1px solid rgba(110, 231, 183, 0.2);
        }

        .so-badge-habis {
            background: rgba(75, 85, 99, 0.25);
            color: #9CA3AF;
            border: 1px solid rgba(156, 163, 175, 0.15);
        }

        /* action buttons */
        .so-action-group {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .so-btn-edit,
        .so-btn-del {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.12s;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            border: 1px solid;
            line-height: 1;
            background: none;
        }

        .so-btn-edit {
            color: #FCD34D;
            border-color: rgba(252, 211, 77, 0.25);
        }

        .so-btn-edit:hover {
            background: rgba(146, 64, 14, 0.3);
            border-color: rgba(252, 211, 77, 0.5);
            color: #FDE68A;
        }

        .so-btn-del {
            color: #FCA5A5;
            border-color: rgba(252, 165, 165, 0.25);
        }

        .so-btn-del:hover {
            background: rgba(153, 27, 27, 0.3);
            border-color: rgba(252, 165, 165, 0.5);
            color: #FECACA;
        }

        /* ─── Pagination ───────────────────────────────────────────────────── */
        .so-pagination {
            padding: 14px 20px;
            border-top: 1px solid var(--so-border);
            font-size: 12px;
            color: var(--so-text-muted);
        }

        /* Override Laravel pagination */
        .so-pagination nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .so-pagination .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .so-pagination .page-item .page-link {
            padding: 5px 11px;
            border-radius: 6px;
            border: 1px solid var(--so-border);
            background: none;
            font-size: 12px;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--so-text-muted);
            transition: all 0.12s;
            text-decoration: none;
            display: inline-block;
            line-height: 1.4;
        }

        .so-pagination .page-item.active .page-link {
            background: var(--so-gold);
            border-color: var(--so-gold);
            color: #1a1208;
            font-weight: 600;
        }

        .so-pagination .page-item:not(.active) .page-link:hover {
            border-color: var(--so-gold);
            color: var(--so-gold);
            background: var(--so-gold-dimmer);
        }

        .so-pagination .page-item.disabled .page-link {
            opacity: 0.35;
            cursor: default;
        }

        /* ─── Export Buttons (Excel & PDF) ────────────────────────────── */
        .so-btn-excel {
            background: linear-gradient(135deg, rgba(16, 78, 37, 0.35) 0%, rgba(21, 128, 61, 0.2) 100%);
            border-color: rgba(34, 197, 94, 0.3);
            color: #4ADE80;
            position: relative;
            overflow: hidden;
        }

        .so-btn-excel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .so-btn-excel:hover {
            border-color: rgba(34, 197, 94, 0.6);
            color: #86EFAC;
            background: linear-gradient(135deg, rgba(16, 78, 37, 0.5) 0%, rgba(21, 128, 61, 0.35) 100%);
            box-shadow: 0 0 12px rgba(34, 197, 94, 0.15);
            transform: translateY(-1px);
        }

        .so-btn-excel:hover::before {
            opacity: 1;
        }

        .so-btn-pdf {
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.35) 0%, rgba(185, 28, 28, 0.2) 100%);
            border-color: rgba(239, 68, 68, 0.3);
            color: #F87171;
            position: relative;
            overflow: hidden;
        }

        .so-btn-pdf::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .so-btn-pdf:hover {
            border-color: rgba(239, 68, 68, 0.6);
            color: #FCA5A5;
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.5) 0%, rgba(185, 28, 28, 0.35) 100%);
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.15);
            transform: translateY(-1px);
        }

        .so-btn-pdf:hover::before {
            opacity: 1;
        }

        /* icon dot accent */
        .so-btn-excel .so-btn-dot,
        .so-btn-pdf .so-btn-dot {
            width: 6px;
            height: 6px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .so-btn-excel .so-btn-dot {
            background: #4ADE80;
        }

        .so-btn-pdf .so-btn-dot {
            background: #F87171;
        }

        /* ─── Polling fade transition ──────────────────────────────────── */
        #so-table-container {
            transition: opacity .15s ease;
        }

        #so-table-container.is-refreshing {
            opacity: .45;
        }
    </style>

    <div class="so">

        {{-- ── Page Header ─────────────────────────────────────────────── --}}
        <div class="so-header">
            <div class="so-header-title">
                <h4>Stok Obat</h4>
                <p>Data stok per batch — diurutkan berdasarkan kadaluarsa terdekat</p>
                <div class="so-live">
                    <span class="so-live-dot" id="so-live-dot"></span>
                    <span id="so-live-text">Update otomatis aktif</span>
                </div>
            </div>
            <div class="so-btn-group">
                <a href="{{ route('export.stok.excel', request()->query()) }}" class="so-btn so-btn-excel">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7.414A2 2 0 0017.414 6L14 2.586A2 2 0 0012.586 2H4zm2 7a1 1 0 000 2h4a1 1 0 000-2H6zm0 3a1 1 0 000 2h6a1 1 0 000-2H6z" />
                    </svg>
                    Excel
                    <span class="so-btn-dot"></span>
                </a>

                <a href="{{ route('export.stok.pdf', request()->query()) }}" class="so-btn so-btn-pdf">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd" />
                    </svg>
                    PDF
                    <span class="so-btn-dot"></span>
                </a>
                <a href="{{ route('stok-obat.create') }}" class="so-btn so-btn-gold">
                    + Tambah Stok
                </a>
                <a href="{{ route('stok-obat.import.form') }}" class="so-btn so-btn-import">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Import Excel
                </a>
            </div>
        </div>

        {{-- ── Flash Messages & Alerts ──────────────────────────────────── --}}
        <div class="so-alerts">
            @if (session('success'))
                <div class="so-alert so-alert-success">
                    <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="so-btn-close">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="so-alert so-alert-danger">
                    <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="so-btn-close">&times;</button>
                </div>
            @endif
            @if ($jumlahExpired > 0)
                <div class="so-alert so-alert-danger">
                    <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><strong>{{ $jumlahExpired }} batch sudah EXPIRED</strong> namun masih ada stok.</span>
                    <a href="{{ route('stok-obat.index', ['status' => 'expired']) }}">Lihat &rarr;</a>
                </div>
            @endif
            @if ($jumlahKritis > 0)
                <div class="so-alert so-alert-warning">
                    <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><strong>{{ $jumlahKritis }} batch</strong> akan kadaluarsa dalam 30 hari.</span>
                    <a href="{{ route('stok-obat.index', ['status' => 'kritis']) }}">Lihat &rarr;</a>
                </div>
            @endif
        </div>

        {{-- ── Filter ──────────────────────────────────────────────────── --}}
        <div class="so-filter-card">
            <form method="GET" action="{{ route('stok-obat.index') }}" id="form-filter">
                <div class="so-filter-row">

                    <div class="so-search-wrap">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                        <input type="text" name="cari" value="{{ request('cari') }}"
                            placeholder="Cari nama obat, merek, no. batch..." class="so-input"
                            oninput="clearTimeout(window._soSt);window._soSt=setTimeout(()=>this.form.submit(),500)">
                    </div>

                    <select name="jenis" class="so-select" style="min-width:148px" onchange="this.form.submit()">
                        <option value="semua" {{ !request('jenis') || request('jenis') == 'semua' ? 'selected' : '' }}>
                            Semua Jenis
                        </option>
                        @foreach ($jenisObatList as $j)
                            <option value="{{ $j->id_jenis }}" {{ request('jenis') == $j->id_jenis ? 'selected' : '' }}>
                                {{ $j->nama_jenis }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="so-select" style="min-width:165px" onchange="this.form.submit()">
                        @foreach ([
            'semua' => 'Semua Status',
            'ada_stok' => 'Ada Stok',
            'kritis' => 'Kritis (≤30 hari)',
            'warning' => 'Waspadai (≤90 hari)',
            'expired' => 'Expired',
            'habis' => 'Stok Habis',
        ] as $val => $lbl)
                            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>

                    <input type="date" name="dari" class="so-date" value="{{ request('dari') }}"
                        title="Tanggal masuk dari" onchange="this.form.submit()">

                    <span class="so-date-sep">—</span>

                    <input type="date" name="sampai" class="so-date" value="{{ request('sampai') }}"
                        title="Tanggal masuk sampai" onchange="this.form.submit()">

                    <select name="sort" class="so-select" style="min-width:168px" onchange="this.form.submit()">
                        @foreach ([
            'tanggal_kadaluarsa' => 'Urut: Kadaluarsa',
            'tanggal_masuk' => 'Urut: Tgl Masuk',
            'jumlah' => 'Urut: Jumlah',
        ] as $val => $lbl)
                            <option value="{{ $val }}"
                                {{ request('sort', 'tanggal_kadaluarsa') == $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>

                    @if (request()->hasAny(['cari', 'jenis', 'status', 'dari', 'sampai', 'sort']))
                        <a href="{{ route('stok-obat.index') }}" class="so-btn-reset">
                            &times; Reset
                        </a>
                    @endif

                </div>
            </form>
        </div>

        {{-- ── Tabel ───────────────────────────────────────────────────── --}}
        <div class="so-card">

            <div class="so-card-header">
                <h5>Daftar Stok</h5>
                <span class="so-card-header-right" id="so-total-text">
                    {{ $data->total() }} batch ditemukan
                    @if (request()->hasAny(['cari', 'jenis', 'status', 'dari', 'sampai']))
                        — <a href="{{ route('stok-obat.index') }}">hapus filter</a>
                    @endif
                </span>
            </div>

            {{-- Konten tabel dipecah ke partial supaya bisa di-refresh ulang via AJAX
                 tanpa reload seluruh halaman (header, filter, alert tetap diam). --}}
            <div id="so-table-container">
                @include('stok_obat._table')
            </div>

        </div>{{-- /so-card --}}

    </div>{{-- /so --}}

    <script>
        (function() {
            const POLL_INTERVAL_MS = 15000; // refresh tiap 15 detik, ubah sesuai kebutuhan
            const container = document.getElementById('so-table-container');
            const totalText = document.getElementById('so-total-text');
            const liveDot = document.getElementById('so-live-dot');
            const liveText = document.getElementById('so-live-text');

            let pollTimer = null;
            let isTabActive = true;

            function currentUrl() {
                // pakai URL saat ini (termasuk filter/search/page yang sedang aktif)
                return window.location.href;
            }

            async function refreshTable() {
                if (!isTabActive) return; // hemat request kalau tab tidak aktif

                container.classList.add('is-refreshing');
                liveDot.classList.add('is-syncing');
                liveText.textContent = 'Menyinkronkan...';

                try {
                    const res = await fetch(currentUrl(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-store',
                    });

                    if (!res.ok) throw new Error('Gagal memuat data');

                    const html = await res.text();

                    // Parse response: kalau controller mengembalikan partial murni,
                    // langsung pakai. Kalau ternyata full page ter-render, ambil
                    // bagian #so-table-container saja dari hasil parse.
                    if (html.includes('id="so-table-container"')) {
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const newContainer = doc.getElementById('so-table-container');
                        const newTotal = doc.getElementById('so-total-text');
                        if (newContainer) container.innerHTML = newContainer.innerHTML;
                        if (newTotal && totalText) totalText.innerHTML = newTotal.innerHTML;
                    } else {
                        container.innerHTML = html;
                    }

                    liveText.textContent = 'Update otomatis aktif';
                } catch (e) {
                    liveText.textContent = 'Gagal sinkron, mencoba lagi...';
                } finally {
                    container.classList.remove('is-refreshing');
                    liveDot.classList.remove('is-syncing');
                }
            }

            function startPolling() {
                stopPolling();
                pollTimer = setInterval(refreshTable, POLL_INTERVAL_MS);
            }

            function stopPolling() {
                if (pollTimer) clearInterval(pollTimer);
                pollTimer = null;
            }

            // Berhenti polling saat tab tidak aktif, jalan lagi saat kembali fokus
            document.addEventListener('visibilitychange', function() {
                isTabActive = document.visibilityState === 'visible';
                if (isTabActive) {
                    refreshTable();
                    startPolling();
                } else {
                    stopPolling();
                }
            });

            startPolling();
        })();
    </script>

@endsection
