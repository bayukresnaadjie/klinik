{{-- =============================================================
   resources/views/components/alert-stok-minimum.blade.php
   Sertakan komponen ini di layouts/app.blade.php
   Contoh: <x-alert-stok-minimum />
   ============================================================= --}}

@php
    use App\Http\Controllers\StokMinimumController;
    $alertStok = StokMinimumController::getVarianKritis();
    $totalAlert = $alertStok->count();
@endphp

@if ($totalAlert > 0)
    <div
        style="background:#FFFBEB;border-bottom:1px solid #FDE68A;padding:8px 20px;
                display:flex;align-items:center;gap:12px;font-size:13px;flex-wrap:wrap">

        <span style="color:#92400E;font-weight:500">
            ⚠ {{ $totalAlert }} varian stok
            {{ $alertStok->where('status', 'habis')->count() > 0 ? 'habis / ' : '' }}kritis:
        </span>

        <div style="display:flex;gap:6px;flex-wrap:wrap;flex:1">
            @foreach ($alertStok->take(5) as $item)
                <span
                    style="background:{{ $item['status'] === 'habis' ? '#FEF2F2' : '#FFFBEB' }};
                             color:{{ $item['status'] === 'habis' ? '#991B1B' : '#92400E' }};
                             border:1px solid {{ $item['status'] === 'habis' ? '#FECACA' : '#FDE68A' }};
                             border-radius:20px;padding:2px 10px;font-size:11.5px;font-weight:500">
                    {{ $item['nama_merek'] }} {{ $item['dosis_mg'] }}mg
                    — <strong>{{ $item['total_stok'] }}</strong> pcs
                    (min: {{ $item['stok_minimum'] }})
                </span>
            @endforeach

            @if ($totalAlert > 5)
                <span style="color:#92400E;font-size:12px;align-self:center">
                    +{{ $totalAlert - 5 }} lainnya
                </span>
            @endif
        </div>

        <a href="{{ route('stok-minimum.index') }}"
            style="color:#92400E;font-weight:500;text-decoration:none;white-space:nowrap;font-size:12px">
            Kelola stok →
        </a>
    </div>
@endif


{{-- =============================================================
   ROUTES — tambahkan ke routes/web.php
   ============================================================= --}}

{{--
Route::middleware('auth')->group(function () {

    Route::get('/stok-minimum',         [StokMinimumController::class, 'index'])      ->name('stok-minimum.index');
    Route::put('/stok-minimum',         [StokMinimumController::class, 'update'])     ->name('stok-minimum.update');
    Route::get('/api/stok-minimum',     [StokMinimumController::class, 'apiRingkasan'])->name('stok-minimum.api');

});
--}}


{{-- =============================================================
   CARA PAKAI DI layouts/app.blade.php
   Tambahkan tepat di bawah tag <nav> atau <header>
   ============================================================= --}}

{{--
    <x-alert-stok-minimum />
--}}


{{-- =============================================================
   TAMBAH LINK DI MENU NAVIGASI (opsional)
   ============================================================= --}}

{{--
    <a href="{{ route('stok-minimum.index') }}" class="nav-link">
        Stok Minimum
        @php $n = \App\Http\Controllers\StokMinimumController::getVarianKritis()->count(); @endphp
        @if ($n > 0)
            <span class="badge bg-danger ms-1" style="font-size:10px">{{ $n }}</span>
        @endif
    </a>
--}}
