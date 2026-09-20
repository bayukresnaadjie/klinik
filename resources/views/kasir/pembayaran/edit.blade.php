@extends('layouts.kasir')
@section('title', 'Edit Pembayaran')
@section('page-title', 'Edit Pembayaran')
@section('content')
    <div
        style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:40px; text-align:center; color:var(--text-muted);">
        Edit pembayaran #{{ $id }}
    </div>
@endsection
