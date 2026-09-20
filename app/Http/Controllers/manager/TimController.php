<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimController extends Controller
{
    public function index(Request $request)
    {
        $today    = Carbon::today()->toDateString();
        $bulanIni = Carbon::now()->startOfMonth()->toDateString();

        // ── Summary Strip ─────────────────────────────────────────
        // Role yang ada: admin, apoteker, kasir, dokter, manajer
        $rolesStaff = ['admin', 'apoteker', 'kasir'];

        $totalStaff = User::whereIn('role', $rolesStaff)->count();
        $staffAktif = User::whereIn('role', $rolesStaff)->where('aktif', true)->count();

        $transaksiHariIni = DB::table('pemakaian_obat')
            ->where('tanggal_pakai', $today)
            ->count();

        $totalTransaksiBulanIni = DB::table('pemakaian_obat')
            ->where('tanggal_pakai', '>=', $bulanIni)
            ->count();

        // ── Query Staff ───────────────────────────────────────────
        $query = User::whereIn('role', $rolesStaff);

        if ($status = $request->get('status')) {
            $query->where('aktif', $status === 'aktif');
        }

        if ($q = $request->get('q')) {
            $query->where(function ($qb) use ($q) {
                $qb->where('name',  'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $sort = $request->get('sort', 'nama');

        // Karena pemakaian_obat tidak punya created_by/user_id,
        // transaksi staff tidak bisa dihitung per user — set 0
        $staffList = $query->get()->map(function ($user) {
            $user->transaksi_bulan_ini = 0;
            $user->transaksi_hari_ini  = 0;
            $user->total_transaksi     = 0;
            $user->last_activity       = $user->last_login_at ?? null;
            return $user;
        });

    if ($sort === 'transaksi') {
    $staffList = $staffList->sortByDesc('transaksi_bulan_ini')->values();
} elseif ($sort === 'bergabung') {
    $staffList = $staffList->sortBy('created_at')->values();
} else {
    $staffList = $staffList->sortBy('name')->values();
}
        // ── Aktivitas Terbaru ─────────────────────────────────────
        $aktivitasTerbaru = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->selectRaw("
                '-' as user_name,
                '-' as user_role,
                CONCAT(o.nama_obat, ' ', v.nama_merek, ' ', v.dosis_mg, 'mg') as nama_obat,
                p.jumlah_pakai as qty,
                p.tanggal_pakai as waktu,
                'pemakaian' as tipe
            ")
            ->where('p.tanggal_pakai', $today)
            ->orderByDesc('p.created_at')
            ->limit(15)
            ->get();

        $notifCount = 0;

        return view('manager.tim', compact(
            'totalStaff',
            'staffAktif',
            'transaksiHariIni',
            'totalTransaksiBulanIni',
            'staffList',
            'aktivitasTerbaru',
            'notifCount',
        ));
    }
}
