<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// ── Core ──────────────────────────────────────────────────────────────────────
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;

// ── Master Data ───────────────────────────────────────────────────────────────
use App\Http\Controllers\JenisObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\VarianObatController;

// ── Stok & Pemakaian ──────────────────────────────────────────────────────────
use App\Http\Controllers\StokObatController;
use App\Http\Controllers\PemakaianObatController;
use App\Http\Controllers\StokMinimumController;

// ── Laporan & Export ──────────────────────────────────────────────────────────
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ExportController;

// ── User Management ───────────────────────────────────────────────────────────
use App\Http\Controllers\UserController;

// ── Kasir ─────────────────────────────────────────────────────────────────────
use App\Http\Controllers\Kasir\KasirDashboardController;
use App\Http\Controllers\Master\HargaVarianController;

// ── Manager ───────────────────────────────────────────────────────────────────
use App\Http\Controllers\Manager\DashboardController  as ManagerDashboardController;
use App\Http\Controllers\Manager\LaporanController    as ManagerLaporanController;
use App\Http\Controllers\Manager\PersetujuanController;
use App\Http\Controllers\Manager\StokController       as ManagerStokController;
use App\Http\Controllers\Manager\TrenController;
use App\Http\Controllers\Manager\PeringatanController;
use App\Http\Controllers\Manager\TimController;
use App\Http\Controllers\Manager\SupplierController;
use App\Http\Controllers\ApprovalRequestController;
/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| Profil (semua role)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profil',          [ProfilController::class, 'edit'])          ->name('profil.edit');
    Route::put('/profil',          [ProfilController::class, 'update'])        ->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

/*
|--------------------------------------------------------------------------
| Dashboard Utama — redirect sesuai role
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'manajer' => redirect()->route('manager.dashboard'),
        'kasir'   => redirect()->route('kasir.dashboard'),
        default   => app(\App\Http\Controllers\DashboardController::class)->index(request()),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Master Data
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('master')->name('master.')->group(function () {
    Route::resource('jenis-obat',  JenisObatController::class) ->except(['show'])->names('jenis-obat');
    Route::resource('obat',        ObatController::class)      ->except(['show'])->names('obat');
    Route::resource('varian-obat', VarianObatController::class)->except(['show'])->names('varian-obat');
    Route::get('harga-varian/{id}/show',  [HargaVarianController::class, 'show'])->name('harga-varian.show');
    Route::get('harga-varian/{id}/edit',  [HargaVarianController::class, 'edit'])->name('harga-varian.edit');
    Route::put('harga-varian/{id}',       [HargaVarianController::class, 'update'])->name('harga-varian.update');
    Route::get ('harga-varian/{id}/list',   [HargaVarianController::class, 'list'])  ->name('harga-varian.list');
    Route::put ('harga-varian/{id}',        [HargaVarianController::class, 'update'])->name('harga-varian.update');
});

/*
|--------------------------------------------------------------------------
| Stok Obat
|--------------------------------------------------------------------------
*/

// ✅ GANTI dengan ini
Route::middleware('auth')->group(function () {
    // Import & template — harus SEBELUM resource agar tidak tertimpa
    Route::get('stok-obat/import',         [StokObatController::class, 'importForm'])      ->name('stok-obat.import.form');
    Route::post('stok-obat/import',        [StokObatController::class, 'importStore'])     ->name('stok-obat.import');
    Route::get('stok-obat/template-excel', [StokObatController::class, 'downloadTemplate'])->name('stok-obat.template');

    // Resource utama
    Route::resource('stok-obat', StokObatController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Pemakaian Obat
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('pemakaian-obat')->name('pemakaian-obat.')->group(function () {
    Route::resource('/', PemakaianObatController::class)->only(['index', 'create', 'store', 'destroy'])->names([
        'index'   => 'index',
        'create'  => 'create',
        'store'   => 'store',
        'destroy' => 'destroy',
    ]);

    // AJAX cek stok per varian
    Route::get('/cek-stok', [PemakaianObatController::class, 'cekStok'])->name('cek-stok');
});

/*
|--------------------------------------------------------------------------
| Stok Minimum
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,apoteker'])->prefix('stok-minimum')->name('stok-minimum.')->group(function () {
    Route::get('/',               [StokMinimumController::class, 'index'])             ->name('index');
    Route::patch('/{varianObat}', [StokMinimumController::class, 'update'])            ->name('update');
    Route::post('/massal',        [StokMinimumController::class, 'updateMassal'])      ->name('update-massal');
    Route::get('/alert',          [StokMinimumController::class, 'alertBawahMinimum']) ->name('alert');
});

/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/',          [LaporanController::class, 'index'])    ->name('index');
    Route::get('/pemakaian', [LaporanController::class, 'pemakaian'])->name('pemakaian');
    Route::get('/stok',      [LaporanController::class, 'stok'])     ->name('stok');
    Route::get('/tren',      [LaporanController::class, 'tren'])     ->name('tren');
});

/*
|--------------------------------------------------------------------------
| Export
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,apoteker'])->prefix('export')->name('export.')->group(function () {
    Route::get('/pemakaian/excel', [ExportController::class, 'pemakaianExcel'])->name('pemakaian.excel');
    Route::get('/pemakaian/pdf',   [ExportController::class, 'pemakaianPdf'])  ->name('pemakaian.pdf');
    Route::get('/stok/excel',      [ExportController::class, 'stokExcel'])     ->name('stok.excel');
    Route::get('/stok/pdf',        [ExportController::class, 'stokPdf'])       ->name('stok.pdf');
});

/*
|--------------------------------------------------------------------------
| Manajemen User (admin only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('users/export',              [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class)->except(['show']);
    Route::patch('users/{user}/toggle-aktif',   [UserController::class, 'toggleAktif'])  ->name('users.toggle-aktif');
    Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

/*
|--------------------------------------------------------------------------
| Kasir
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('kasir')->name('kasir.')->group(function () {

    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::resource('resep',      \App\Http\Controllers\Kasir\ResepController::class);
    Route::resource('pembayaran', \App\Http\Controllers\Kasir\PembayaranController::class);
    Route::resource('struk',      \App\Http\Controllers\Kasir\StrukController::class);

    // Stok — urutan penting: /menipis sebelum /{id}
    Route::get('/stok',         [\App\Http\Controllers\Kasir\StokController::class, 'index'])  ->name('stok.index');
    Route::get('/stok/menipis', [\App\Http\Controllers\Kasir\StokController::class, 'menipis'])->name('stok.menipis');
    Route::get('/stok/{id}',    [\App\Http\Controllers\Kasir\StokController::class, 'show'])   ->name('stok.show');

    // Laporan
    Route::get('/laporan/harian', [\App\Http\Controllers\Kasir\LaporanController::class, 'harian'])->name('laporan.harian');

    // Profil
    Route::get('/profil', [\App\Http\Controllers\Kasir\ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [\App\Http\Controllers\Kasir\ProfilController::class, 'update'])->name('profil.update');
});

// SSO auto-login kasir via token
Route::get('/kasir/auto-login', function (\Illuminate\Http\Request $request) {
    $ssoToken = env('SSO_TOKEN');

    // Tolak jika SSO_TOKEN belum di-set di .env
    if (empty($ssoToken)) {
        abort(403, 'SSO tidak dikonfigurasi.');
    }

    // Tolak jika token tidak cocok
    if (! hash_equals($ssoToken, (string) $request->query('token', ''))) {
        abort(403, 'Token tidak valid.');
    }

    // Cari user kasir secara spesifik berdasarkan role saja
    $user = \App\Models\User::where('role', 'kasir')->first();

    if (! $user) {
        abort(404, 'Akun kasir tidak ditemukan.');
    }

    \Illuminate\Support\Facades\Auth::login($user, false); // jangan remember

    $request->session()->regenerate(); // cegah session fixation

    return redirect()->route('kasir.dashboard');
})->middleware('throttle:sso'); // throttle tersendiri untuk SSO

/*
|--------------------------------------------------------------------------
| Admin Supplier
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/supplier')
    ->name('admin.supplier.')
    ->group(function () {
        Route::get('/',           [\App\Http\Controllers\Admin\SupplierController::class, 'index'])     ->name('index');
        Route::get('/create',     [\App\Http\Controllers\Admin\SupplierController::class, 'create'])    ->name('create');
        Route::post('/',          [\App\Http\Controllers\Admin\SupplierController::class, 'store'])     ->name('store');
        Route::get('/{supplier}/edit',    [\App\Http\Controllers\Admin\SupplierController::class, 'edit'])      ->name('edit');
        Route::put('/{supplier}',         [\App\Http\Controllers\Admin\SupplierController::class, 'update'])    ->name('update');
        Route::delete('/{supplier}',      [\App\Http\Controllers\Admin\SupplierController::class, 'destroy'])   ->name('destroy');
        Route::patch('/{supplier}/toggle',[\App\Http\Controllers\Admin\SupplierController::class, 'toggleAktif'])->name('toggle');
    });

/*
|--------------------------------------------------------------------------
| Manager
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:manajer'])->prefix('manager')->name('manager.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    // Laporan Kinerja
    Route::get('/laporan',        [ManagerLaporanController::class, 'index']) ->name('laporan');
    Route::get('/laporan/export', [ManagerLaporanController::class, 'export'])->name('laporan.export');

    // Persetujuan
Route::get('/persetujuan', fn() => redirect()->route('approval-requests.index'))
    ->name('persetujuan');

    // Monitoring
    Route::get('/stok',       [ManagerStokController::class, 'index'])->name('stok');
    Route::get('/tren',       [TrenController::class,        'index'])->name('tren');
    Route::get('/peringatan', [PeringatanController::class,  'index'])->name('peringatan');

    // Manajemen
    Route::get('/tim',      [TimController::class,      'index'])->name('tim');
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');

    // Di dalam group middleware manager
Route::post('/supplier/pengiriman', [SupplierController::class, 'storePengiriman'])
    ->name('supplier.pengiriman.store');
Route::patch('/supplier/pengiriman/{pengiriman}',[SupplierController::class, 'updatePengiriman'])->name('supplier.pengiriman.update');
});

Route::middleware(['auth'])->group(function () {

Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/',              [NotificationController::class, 'index'])      ->name('index');
    Route::patch('/{notification}/read', [NotificationController::class, 'markRead'])   ->name('read');
    Route::patch('/read-all',    [NotificationController::class, 'markAllRead'])->name('read-all');
});
    Route::prefix('approval-requests')->name('approval-requests.')->group(function () {

        // ── Static routes dulu — sebelum {approvalRequest} ────
        Route::get('/',         [ApprovalRequestController::class, 'index']) ->name('index');
        Route::get('/create',   [ApprovalRequestController::class, 'create'])->name('create');
        Route::post('/',        [ApprovalRequestController::class, 'store']) ->name('store');
        Route::get('/riwayat',  [ApprovalRequestController::class, 'riwayat'])->name('riwayat'); // ← pindah ke atas

        // ── Dynamic routes — setelah static ───────────────────
        Route::get('/{approvalRequest}',         [ApprovalRequestController::class, 'show'])   ->name('show');
        Route::post('/{approvalRequest}/approve',[ApprovalRequestController::class, 'approve'])->name('approve');
        Route::post('/{approvalRequest}/reject', [ApprovalRequestController::class, 'reject']) ->name('reject');
    });

});
/*
|--------------------------------------------------------------------------
| Auth (Breeze — login, register, dll)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
