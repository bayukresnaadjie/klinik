@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@700;800&display=swap');

        [x-cloak] {
            display: none !important;
        }

        /* ── Header ── */
        .pg-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .pg-eyebrow {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .25);
            margin-bottom: 5px;
        }

        .pg-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.5px;
            line-height: 1;
        }

        .pg-title span {
            color: #60a5fa;
        }

        .pg-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, .3);
            margin-top: 5px;
        }

        .hdr-btns {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(59, 130, 246, .35);
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, .45);
            color: #fff;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .5);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-export:hover {
            background: rgba(255, 255, 255, .09);
            color: #fff;
            border-color: rgba(255, 255, 255, .2);
        }

        .btn-export svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }

        /* ── Stat Cards ── */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .scard {
            background: #13161e;
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 14px;
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .scard:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .35);
        }

        .scard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 14px 14px 0 0;
        }

        .sc-blue::before {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .sc-purple::before {
            background: linear-gradient(90deg, #8b5cf6, #a78bfa);
        }

        .sc-green::before {
            background: linear-gradient(90deg, #22c55e, #4ade80);
        }

        .sc-red::before {
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .sc-lbl {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sc-lbl svg {
            opacity: .5;
        }

        .sc-val {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
        }

        .sc-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, .25);
            margin-top: 4px;
        }

        .role-pills {
            display: flex;
            gap: 5px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .rp {
            flex: 1;
            min-width: 0;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 8px;
            padding: 7px 5px;
            text-align: center;
        }

        .rp-num {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .rp-lbl {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-top: 3px;
        }

        .rp-blue .rp-lbl {
            color: #818cf8;
        }

        .rp-green .rp-lbl {
            color: #34d399;
        }

        .rp-yellow .rp-lbl {
            color: #fbbf24;
        }

        .rp-purple .rp-lbl {
            color: #a78bfa;
        }

        .rp-sky .rp-lbl {
            color: #38bdf8;
        }

        .sp-bar {
            height: 4px;
            background: rgba(255, 255, 255, .06);
            border-radius: 99px;
            overflow: hidden;
            margin-top: 10px;
        }

        .sp-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #4ade80, #22c55e);
        }

        .sp-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            font-size: 10px;
            color: rgba(255, 255, 255, .25);
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-box svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            stroke: rgba(255, 255, 255, .25);
            fill: none;
            stroke-width: 2;
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            background: #13161e;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 9px;
            padding: 9px 12px 9px 34px;
            color: #fff;
            font-size: 13px;
            outline: none;
            transition: border-color .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, .2);
        }

        .search-box input:focus {
            border-color: rgba(59, 130, 246, .5);
        }

        .ftab {
            padding: 8px 13px;
            background: #13161e;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 9px;
            color: rgba(255, 255, 255, .4);
            font-size: 11.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
        }

        .ftab:hover {
            border-color: rgba(255, 255, 255, .15);
            color: #fff;
        }

        .ftab.on {
            background: rgba(59, 130, 246, .12);
            border-color: rgba(59, 130, 246, .3);
            color: #60a5fa;
        }

        /* Sort select */
        .sort-wrap {
            position: relative;
        }

        .sort-wrap svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 13px;
            height: 13px;
            stroke: rgba(255, 255, 255, .3);
            fill: none;
            stroke-width: 2;
            pointer-events: none;
        }

        .sort-select {
            background: #13161e;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 9px;
            padding: 8px 12px 8px 30px;
            color: rgba(255, 255, 255, .6);
            font-size: 12px;
            outline: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .15s;
        }

        .sort-select:focus {
            border-color: rgba(59, 130, 246, .4);
            color: #fff;
        }

        /* ── Table Card ── */
        .tcard {
            background: #13161e;
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 16px;
            overflow: hidden;
        }

        .tcard-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .tcard-count {
            font-size: 12px;
            color: rgba(255, 255, 255, .3);
        }

        .tcard-count strong {
            color: rgba(255, 255, 255, .7);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        th {
            padding: 10px 16px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .9px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .2);
            text-align: left;
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
            transition: color .15s;
        }

        th:hover {
            color: rgba(255, 255, 255, .5);
        }

        th .sort-icon {
            display: inline-block;
            margin-left: 4px;
            opacity: .4;
            font-style: normal;
        }

        th.sort-asc .sort-icon {
            opacity: 1;
            color: #60a5fa;
        }

        th.sort-desc .sort-icon {
            opacity: 1;
            color: #60a5fa;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            transition: background .12s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, .02);
        }

        td {
            padding: 12px 16px;
            vertical-align: middle;
        }

        /* User cell */
        .ucell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .uavatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
            position: relative;
        }

        .ustatus-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            border: 2px solid #13161e;
        }

        .dot-on {
            background: #4ade80;
        }

        .dot-off {
            background: #6b7280;
        }

        .uname {
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            margin-bottom: 1px;
        }

        .uemail {
            font-size: 10.5px;
            color: rgba(255, 255, 255, .3);
        }

        .uhp {
            font-size: 10px;
            color: rgba(255, 255, 255, .25);
            margin-top: 1px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .uhp svg {
            width: 10px;
            height: 10px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            opacity: .5;
        }

        /* Badges */
        .rbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 5px;
            font-size: 10.5px;
            font-weight: 600;
        }

        .rbadge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .rb-admin {
            background: rgba(99, 102, 241, .12);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, .2);
        }

        .rb-admin::before {
            background: #818cf8;
        }

        .rb-apoteker {
            background: rgba(16, 185, 129, .1);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, .2);
        }

        .rb-apoteker::before {
            background: #34d399;
        }

        .rb-kasir {
            background: rgba(245, 158, 11, .1);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, .2);
        }

        .rb-kasir::before {
            background: #fbbf24;
        }

        .rb-manajer {
            background: rgba(139, 92, 246, .1);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, .2);
        }

        .rb-manajer::before {
            background: #a78bfa;
        }

        .rb-dokter {
            background: rgba(14, 165, 233, .1);
            color: #7dd3fc;
            border: 1px solid rgba(14, 165, 233, .2);
        }

        .rb-dokter::before {
            background: #38bdf8;
        }

        .rb-default {
            background: rgba(107, 114, 128, .1);
            color: #9ca3af;
            border: 1px solid rgba(107, 114, 128, .2);
        }

        .rb-default::before {
            background: #6b7280;
        }

        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 5px;
            font-size: 10.5px;
            font-weight: 600;
        }

        .sbadge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .sb-on {
            background: rgba(34, 197, 94, .1);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, .2);
        }

        .sb-on::before {
            background: #4ade80;
            box-shadow: 0 0 5px #4ade80;
        }

        .sb-off {
            background: rgba(107, 114, 128, .1);
            color: #9ca3af;
            border: 1px solid rgba(107, 114, 128, .2);
        }

        .sb-off::before {
            background: #6b7280;
        }

        /* Info cells */
        .jabatan-cell {
            font-size: 11.5px;
            color: rgba(255, 255, 255, .5);
        }

        .jabatan-cell.empty {
            color: rgba(255, 255, 255, .18);
            font-style: italic;
        }

        .date-cell {
            font-size: 11px;
            color: rgba(255, 255, 255, .35);
        }

        .date-cell .date-main {
            color: rgba(255, 255, 255, .55);
            font-weight: 500;
        }

        .llabel {
            font-size: 11px;
            color: rgba(255, 255, 255, .35);
        }

        .llabel.recent {
            color: #4ade80;
            font-weight: 500;
        }

        /* Actions */
        .acts {
            display: flex;
            gap: 3px;
            align-items: center;
            flex-wrap: wrap;
        }

        .abtn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 9px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
        }

        .abtn svg {
            width: 11px;
            height: 11px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .abtn:active {
            transform: scale(.95);
        }

        .ab-edit {
            background: rgba(59, 130, 246, .1);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, .18);
        }

        .ab-edit:hover {
            background: rgba(59, 130, 246, .2);
            color: #60a5fa;
        }

        .ab-del {
            background: rgba(239, 68, 68, .1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, .18);
        }

        .ab-del:hover {
            background: rgba(239, 68, 68, .2);
        }

        .ab-tog {
            background: rgba(245, 158, 11, .1);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, .18);
        }

        .ab-tog:hover {
            background: rgba(245, 158, 11, .2);
        }

        .ab-rst {
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, .35);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .ab-rst:hover {
            background: rgba(255, 255, 255, .09);
            color: rgba(255, 255, 255, .7);
        }

        .adiv {
            width: 1px;
            height: 16px;
            background: rgba(255, 255, 255, .07);
            flex-shrink: 0;
        }

        /* Empty */
        .empty-tr td {
            padding: 48px 20px;
            text-align: center;
            color: rgba(255, 255, 255, .2);
            font-size: 13px;
        }

        .empty-tr svg {
            display: block;
            margin: 0 auto 10px;
            width: 36px;
            height: 36px;
            stroke: rgba(255, 255, 255, .1);
            fill: none;
            stroke-width: 1.5;
        }

        /* ── Modal ── */
        .modal-wrap {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .75);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-box {
            background: #0d1117;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            width: 400px;
            padding: 32px;
            position: relative;
            box-shadow: 0 40px 80px rgba(0, 0, 0, .7);
            animation: popIn .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes popIn {
            from {
                transform: scale(.92) translateY(16px);
                opacity: 0;
            }

            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .modal-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 160px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ef4444, transparent);
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulseIcon 2.5s ease-in-out infinite;
        }

        @keyframes pulseIcon {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, .3);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }
        }

        .modal-icon svg {
            width: 26px;
            height: 26px;
            stroke: #ef4444;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }

        .modal-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            text-align: center;
            letter-spacing: -.3px;
            margin-bottom: 6px;
        }

        .modal-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, .35);
            text-align: center;
        }

        .modal-ucard {
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 12px;
            padding: 13px 15px;
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 16px 0 20px;
        }

        .modal-uavatar {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .modal-uname {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
        }

        .modal-uemail {
            font-size: 11px;
            color: rgba(255, 255, 255, .3);
            margin-top: 1px;
        }

        .modal-urole {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: .4px;
            background: rgba(251, 191, 36, .1);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, .2);
        }

        .modal-warn {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            background: rgba(239, 68, 68, .05);
            border: 1px solid rgba(239, 68, 68, .12);
            border-radius: 9px;
            padding: 11px 13px;
            margin-bottom: 22px;
        }

        .modal-warn svg {
            width: 14px;
            height: 14px;
            stroke: #ef4444;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .modal-warn p {
            font-size: 12px;
            color: rgba(255, 255, 255, .4);
            line-height: 1.55;
        }

        .modal-warn strong {
            color: rgba(255, 255, 255, .65);
        }

        .modal-btns {
            display: flex;
            gap: 8px;
        }

        .mbtn {
            flex: 1;
            height: 46px;
            border-radius: 11px;
            border: none;
            cursor: pointer;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all .2s;
        }

        .mbtn:active {
            transform: scale(.97);
        }

        .mb-cancel {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .5);
        }

        .mb-cancel:hover {
            background: rgba(255, 255, 255, .09);
            color: rgba(255, 255, 255, .8);
        }

        .mb-del {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            box-shadow: 0 4px 16px rgba(220, 38, 38, .3);
        }

        .mb-del:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(220, 38, 38, .4);
        }

        .mb-del svg {
            width: 14px;
            height: 14px;
            stroke: #fff;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
        }

        @media(max-width:1200px) {
            .stat-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:640px) {
            .toolbar {
                flex-wrap: wrap;
            }

            .hdr-btns {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
@endpush

@section('content')
    <div x-data="{
        open: false,
        uid: null,
        uname: '',
        uemail: '',
        urole: '',
        uinit: '',
        del(id, name, email, role) {
            this.uid = id;
            this.uname = name;
            this.uemail = email;
            this.urole = role;
            this.uinit = name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
            this.open = true;
        }
    }">

        {{-- ── Header ── --}}
        <div class="pg-header">
            <div>
                <div class="pg-eyebrow">Manajemen</div>
                <div class="pg-title">Kelola <span>User</span></div>
                <div class="pg-sub">Atur akun, role, dan akses pengguna sistem</div>
            </div>
            <div class="hdr-btns">
                <a href="{{ route('users.export') ?? '#' }}" class="btn-export" id="btnExport" onclick="exportCSV(event)">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('users.create') }}" class="btn-new">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        @php
            $total = $stats['total'] ?? 0;
            $aktif = $stats['aktif'] ?? 0;
            $nonaktif = $stats['nonaktif'] ?? 0;
            $pct = $total > 0 ? round(($aktif / $total) * 100) : 0;
        @endphp
        <div class="stat-row">
            <div class="scard sc-blue">
                <div class="sc-lbl">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                    Total User
                </div>
                <div class="sc-val">{{ $total }}</div>
                <div class="sc-sub">Terdaftar di sistem</div>
                <div class="role-pills">
                    <div class="rp rp-blue">
                        <div class="rp-num">{{ $stats['admin'] ?? 0 }}</div>
                        <div class="rp-lbl">Admin</div>
                    </div>
                    <div class="rp rp-green">
                        <div class="rp-num">{{ $stats['apoteker'] ?? 0 }}</div>
                        <div class="rp-lbl">Apo</div>
                    </div>
                    <div class="rp rp-yellow">
                        <div class="rp-num">{{ $stats['kasir'] ?? 0 }}</div>
                        <div class="rp-lbl">Kasir</div>
                    </div>
                    <div class="rp rp-purple">
                        <div class="rp-num">{{ $stats['manajer'] ?? 0 }}</div>
                        <div class="rp-lbl">Mgr</div>
                    </div>
                    <div class="rp rp-sky">
                        <div class="rp-num">{{ $stats['dokter'] ?? 0 }}</div>
                        <div class="rp-lbl">Dokter</div>
                    </div>
                </div>
            </div>
            <div class="scard sc-green">
                <div class="sc-lbl">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    Aktif
                </div>
                <div class="sc-val" style="color:#4ade80">{{ $aktif }}</div>
                <div class="sc-sub">dari {{ $total }} user</div>
                <div class="sp-bar">
                    <div class="sp-fill" style="width:{{ $pct }}%"></div>
                </div>
                <div class="sp-meta"><span>Rasio aktif</span><span>{{ $pct }}%</span></div>
            </div>
            <div class="scard sc-red">
                <div class="sc-lbl">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
                    </svg>
                    Non-Aktif
                </div>
                <div class="sc-val" style="color:#f87171">{{ $nonaktif }}</div>
                <div class="sc-sub">akun dinonaktifkan</div>
            </div>
            <div class="scard sc-purple">
                <div class="sc-lbl">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Bergabung Bulan Ini
                </div>
                <div class="sc-val" style="color:#a78bfa">
                    {{ $users->filter(fn($u) => \Carbon\Carbon::parse($u->created_at)->isCurrentMonth())->count() }}
                </div>
                <div class="sc-sub">user baru bulan ini</div>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                style="display:flex;align-items:center;gap:9px;padding:10px 14px;background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);color:#6ee7b7;border-radius:10px;margin-bottom:14px;font-size:13px">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-cloak
                style="display:flex;align-items:center;gap:9px;padding:10px 14px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#fca5a5;border-radius:10px;margin-bottom:14px;font-size:13px">
                ✕ {{ session('error') }}
            </div>
        @endif

        {{-- ── Toolbar ── --}}
        <div class="toolbar">
            <div class="search-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" id="srch" placeholder="Cari nama, email, no.HP, jabatan..."
                    oninput="doFilter()">
            </div>
            <button class="ftab on" onclick="setF('semua',   this)">Semua</button>
            <button class="ftab" onclick="setF('admin',   this)">Admin</button>
            <button class="ftab" onclick="setF('apoteker',this)">Apoteker</button>
            <button class="ftab" onclick="setF('kasir',   this)">Kasir</button>
            <button class="ftab" onclick="setF('manajer', this)">Manajer</button>
            <button class="ftab" onclick="setF('dokter',  this)">Dokter</button>
            <button class="ftab" onclick="setF('aktif',   this)">● Aktif</button>
            <button class="ftab" onclick="setF('nonaktif',this)">○ Nonaktif</button>
            <div class="sort-wrap">
                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6" />
                    <line x1="8" y1="12" x2="21" y2="12" />
                    <line x1="8" y1="18" x2="21" y2="18" />
                    <line x1="3" y1="6" x2="3.01" y2="6" />
                    <line x1="3" y1="12" x2="3.01" y2="12" />
                    <line x1="3" y1="18" x2="3.01" y2="18" />
                </svg>
                <select class="sort-select" id="sortSel" onchange="doSort()">
                    <option value="nama-asc">Nama A–Z</option>
                    <option value="nama-desc">Nama Z–A</option>
                    <option value="bergabung-desc">Terbaru</option>
                    <option value="bergabung-asc">Terlama</option>
                    <option value="login-desc">Login Terakhir</option>
                </select>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="tcard">
            <div class="tcard-head">
                <span class="tcard-count">Menampilkan <strong id="cnt">{{ $users->count() }}</strong> user</span>
                <span style="font-size:11px;color:rgba(255,255,255,.2)">Klik header kolom untuk sort</span>
            </div>
            <div style="overflow-x:auto">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th onclick="sortCol('name')" data-col="name"> User <i class="sort-icon">↕</i></th>
                            <th onclick="sortCol('jabatan')" data-col="jabatan"> Jabatan <i class="sort-icon">↕</i></th>
                            <th onclick="sortCol('role')" data-col="role"> Role <i class="sort-icon">↕</i></th>
                            <th onclick="sortCol('status')" data-col="status"> Status <i class="sort-icon">↕</i></th>
                            <th onclick="sortCol('bergabung')" data-col="bergabung">Bergabung <i class="sort-icon">↕</i>
                            </th>
                            <th onclick="sortCol('login')" data-col="login"> Login Terakhir <i class="sort-icon">↕</i>
                            </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @forelse($users as $u)
                            @php
                                $isAktif = $u->aktif ?? 0;
                                $words = explode(' ', $u->name);
                                $init = strtoupper(
                                    substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                                );
                                $grad = match ($u->role) {
                                    'admin' => 'linear-gradient(135deg,#6366f1,#4338ca)',
                                    'apoteker' => 'linear-gradient(135deg,#10b981,#047857)',
                                    'kasir' => 'linear-gradient(135deg,#f59e0b,#d97706)',
                                    'manajer' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
                                    'dokter' => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
                                    default => 'linear-gradient(135deg,#64748b,#475569)',
                                };
                                $lastLogin = $u->last_login_at
                                    ? \Carbon\Carbon::parse($u->last_login_at)->diffForHumans()
                                    : 'Belum pernah';
                                $isRecent =
                                    $u->last_login_at && \Carbon\Carbon::parse($u->last_login_at)->gt(now()->subDay());
                                $loginTs = $u->last_login_at ? \Carbon\Carbon::parse($u->last_login_at)->timestamp : 0;
                                $bergabung = \Carbon\Carbon::parse($u->created_at)->translatedFormat('d M Y');
                                $bergabungTs = \Carbon\Carbon::parse($u->created_at)->timestamp;
                            @endphp
                            <tr data-role="{{ $u->role }}" data-status="{{ $isAktif ? 'aktif' : 'nonaktif' }}"
                                data-name="{{ strtolower($u->name) }}" data-email="{{ strtolower($u->email) }}"
                                data-hp="{{ strtolower($u->no_hp ?? ($u->no_telepon ?? '')) }}"
                                data-jabatan="{{ strtolower($u->jabatan ?? '') }}" data-bergabung="{{ $bergabungTs }}"
                                data-login="{{ $loginTs }}">

                                <td>
                                    <div class="ucell">
                                        <div class="uavatar" style="background:{{ $grad }}">
                                            {{ $init }}
                                            <span class="ustatus-dot {{ $isAktif ? 'dot-on' : 'dot-off' }}"></span>
                                        </div>
                                        <div>
                                            <div class="uname">{{ $u->name }}</div>
                                            <div class="uemail">{{ $u->email }}</div>
                                            @if ($u->no_hp ?? ($u->no_telepon ?? null))
                                                <div class="uhp">
                                                    <svg viewBox="0 0 24 24">
                                                        <path
                                                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 12 19.79 19.79 0 011.61 3.37 2 2 0 013.6 1h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9a16 16 0 006.29 6.29l.87-.87a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                                                    </svg>
                                                    {{ $u->no_hp ?? $u->no_telepon }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="jabatan-cell {{ $u->jabatan ?? null ? '' : 'empty' }}">
                                        {{ $u->jabatan ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="rbadge rb-{{ $u->role }} {{ !in_array($u->role, ['admin', 'apoteker', 'kasir', 'manajer', 'dokter']) ? 'rb-default' : '' }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="sbadge {{ $isAktif ? 'sb-on' : 'sb-off' }}">
                                        {{ $isAktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="date-cell">
                                        <div class="date-main">{{ $bergabung }}</div>
                                        <div>{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}</div>
                                    </div>
                                </td>

                                <td>
                                    <span class="llabel {{ $isRecent ? 'recent' : '' }}">
                                        {{ $lastLogin }}
                                    </span>
                                </td>

                                <td>
                                    <div class="acts">
                                        <a href="{{ route('users.edit', $u) }}" class="abtn ab-edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <div class="adiv"></div>
                                        <button type="button" class="abtn ab-del"
                                            @click="del({{ $u->id }},'{{ addslashes($u->name) }}','{{ $u->email }}','{{ ucfirst($u->role) }}')">
                                            <svg viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                            </svg>
                                            Hapus
                                        </button>
                                        <div class="adiv"></div>
                                        <form action="{{ route('users.toggle-aktif', $u) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="abtn ab-tog">
                                                <svg viewBox="0 0 24 24">
                                                    <path
                                                        d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3" />
                                                </svg>
                                                {{ $isAktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('users.reset-password', $u) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="abtn ab-rst">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M3 12a9 9 0 101.5-5M3 7V3m0 4H7" />
                                                </svg>
                                                Reset
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-tr">
                                <td colspan="7">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                    Belum ada data user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="emptyMsg"
                style="display:none;padding:40px 20px;text-align:center;color:rgba(255,255,255,.2);font-size:13px">
                Tidak ada user yang cocok
            </div>

            @if ($users->hasPages())
                <div style="padding:12px 20px;border-top:1px solid rgba(255,255,255,.05)">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- ── Modal Hapus ── --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="modal-wrap" @click.self="open=false">
            <div class="modal-box" x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                <div class="modal-icon">
                    <svg viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        <path d="M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                    </svg>
                </div>
                <div class="modal-title">Hapus Akun User</div>
                <div class="modal-desc">Akun berikut akan dihapus dari sistem.</div>
                <div class="modal-ucard">
                    <div class="modal-uavatar" x-text="uinit"></div>
                    <div style="flex:1">
                        <div class="modal-uname" x-text="uname"></div>
                        <div class="modal-uemail" x-text="uemail"></div>
                    </div>
                    <span class="modal-urole" x-text="urole"></span>
                </div>
                <div class="modal-warn">
                    <svg viewBox="0 0 24 24">
                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    <p><strong>Tindakan ini tidak dapat dibatalkan.</strong> Data terkait akun akan dihapus permanen.</p>
                </div>
                <div class="modal-btns">
                    <button type="button" class="mbtn mb-cancel" @click="open=false">Batal</button>
                    <form :action="'/users/' + uid" method="POST" style="flex:1;display:flex">
                        @csrf @method('DELETE')
                        <button type="submit" class="mbtn mb-del" style="flex:1">
                            <svg viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                            </svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        let cf = 'semua';
        let sortDir = {};

        /* Filter tab */
        function setF(r, btn) {
            cf = r;
            document.querySelectorAll('.ftab').forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
            doFilter();
        }

        /* Filter rows */
        function doFilter() {
            const q = document.getElementById('srch').value.toLowerCase();
            const rows = document.querySelectorAll('#tbody tr[data-role]');
            let v = 0;
            rows.forEach(row => {
                const byF = cf === 'semua' ? true :
                    ['aktif', 'nonaktif'].includes(cf) ? row.dataset.status === cf :
                    row.dataset.role === cf;
                const byS = row.dataset.name.includes(q) ||
                    row.dataset.email.includes(q) ||
                    (row.dataset.hp || '').includes(q) ||
                    (row.dataset.jabatan || '').includes(q);
                const show = byF && byS;
                row.style.display = show ? '' : 'none';
                if (show) v++;
            });
            document.getElementById('cnt').textContent = v;
            document.getElementById('emptyMsg').style.display = v === 0 ? 'block' : 'none';
        }

        /* Sort by column header click */
        function sortCol(col) {
            sortDir[col] = sortDir[col] === 'asc' ? 'desc' : 'asc';
            const dir = sortDir[col];

            // Update header icons
            document.querySelectorAll('th[data-col]').forEach(th => {
                th.classList.remove('sort-asc', 'sort-desc');
                th.querySelector('.sort-icon').textContent = '↕';
            });
            const th = document.querySelector(`th[data-col="${col}"]`);
            if (th) {
                th.classList.add(dir === 'asc' ? 'sort-asc' : 'sort-desc');
                th.querySelector('.sort-icon').textContent = dir === 'asc' ? '↑' : '↓';
            }

            const tbody = document.getElementById('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-role]'));

            rows.sort((a, b) => {
                let av, bv;
                if (col === 'name') {
                    av = a.dataset.name;
                    bv = b.dataset.name;
                }
                if (col === 'jabatan') {
                    av = a.dataset.jabatan;
                    bv = b.dataset.jabatan;
                }
                if (col === 'role') {
                    av = a.dataset.role;
                    bv = b.dataset.role;
                }
                if (col === 'status') {
                    av = a.dataset.status;
                    bv = b.dataset.status;
                }
                if (col === 'bergabung') {
                    av = parseInt(a.dataset.bergabung) || 0;
                    bv = parseInt(b.dataset.bergabung) || 0;
                }
                if (col === 'login') {
                    av = parseInt(a.dataset.login) || 0;
                    bv = parseInt(b.dataset.login) || 0;
                }

                if (typeof av === 'number') return dir === 'asc' ? av - bv : bv - av;
                return dir === 'asc' ? av.localeCompare(bv) : bv.localeCompare(av);
            });

            rows.forEach(row => tbody.appendChild(row));
            doFilter();
        }

        /* Sort select dropdown */
        function doSort() {
            const val = document.getElementById('sortSel').value;
            const [col, dir] = val.split('-');
            sortDir[col] = dir;
            const tbody = document.getElementById('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-role]'));

            rows.sort((a, b) => {
                if (col === 'nama') return dir === 'asc' ? a.dataset.name.localeCompare(b.dataset.name) : b.dataset
                    .name.localeCompare(a.dataset.name);
                if (col === 'bergabung') {
                    const av = parseInt(a.dataset.bergabung) || 0,
                        bv = parseInt(b.dataset.bergabung) || 0;
                    return dir === 'asc' ? av - bv : bv - av;
                }
                if (col === 'login') {
                    const av = parseInt(a.dataset.login) || 0,
                        bv = parseInt(b.dataset.login) || 0;
                    return dir === 'asc' ? av - bv : bv - av;
                }
                return 0;
            });
            rows.forEach(row => tbody.appendChild(row));
            doFilter();
        }

        /* Export CSV */
        function exportCSV(e) {
            e.preventDefault();
            const rows = document.querySelectorAll('#tbody tr[data-role]');
            const lines = [
                ['Nama', 'Email', 'No HP', 'Jabatan', 'Role', 'Status', 'Bergabung', 'Login Terakhir']
            ];

            rows.forEach(row => {
                if (row.style.display === 'none') return;
                const tds = row.querySelectorAll('td');
                const name = row.dataset.name;
                const email = row.dataset.email;
                const hp = row.dataset.hp || '';
                const jabatan = row.dataset.jabatan || '';
                const role = row.dataset.role;
                const status = row.dataset.status;
                const bergabung = tds[4] ? tds[4].querySelector('.date-main')?.textContent.trim() : '';
                const login = tds[5] ? tds[5].textContent.trim() : '';
                lines.push([name, email, hp, jabatan, role, status, bergabung, login]);
            });

            const csv = lines.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
            const blob = new Blob(['\uFEFF' + csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'users-' + new Date().toISOString().slice(0, 10) + '.csv';
            a.click();
            URL.revokeObjectURL(url);
        }
    </script>
@endpush
