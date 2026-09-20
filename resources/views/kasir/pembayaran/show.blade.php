@extends('layouts.kasir')
@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('content')
    <div
        style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:40px; text-align:center; color:var(--text-muted);">
        Detail pembayaran #{{ $id }}
    </div>
@endsection
