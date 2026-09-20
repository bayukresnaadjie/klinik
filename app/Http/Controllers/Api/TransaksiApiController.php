<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiApiController extends Controller
{
    // GET /api/transaksi
    public function index(Request $request)
    {
        $query = DB::table('transaksi');

        if ($request->dari)    $query->whereDate('created_at', '>=', $request->dari);
        if ($request->sampai)  $query->whereDate('created_at', '<=', $request->sampai);
        if ($request->status)  $query->where('status', $request->status);
        if ($request->kasir)   $query->where('kasir', $request->kasir);
        if ($request->pasien)  $query->where('nama_pasien', 'like', "%{$request->pasien}%");

        $data = $query->orderByDesc('created_at')->paginate(20);

        return response()->json([
            'status'  => 'ok',
            'total'   => $data->total(),
            'omset'   => $query->sum('total_bayar'),
            'data'    => $data,
        ]);
    }

    // GET /api/transaksi/{no}
    public function show($no)
    {
        $transaksi = DB::table('transaksi')->where('no_transaksi', $no)->first();

        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ditemukan'], 404);
        }

        $detail = DB::table('detail_transaksi')->where('no_transaksi', $no)->get();

        return response()->json([
            'status'    => 'ok',
            'transaksi' => $transaksi,
            'detail'    => $detail,
        ]);
    }

    // GET /api/transaksi/rekap-harian
    public function rekapHarian(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $data = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah, SUM(total_bayar) as omset')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->groupByRaw('DATE(created_at)')
            ->orderBy('tanggal')
            ->get();

        return response()->json(['status' => 'ok', 'data' => $data]);
    }

    // GET /api/transaksi/rekap-kasir
    public function rekapKasir(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $data = DB::table('transaksi')
            ->selectRaw('kasir, COUNT(*) as jumlah, SUM(total_bayar) as omset, AVG(total_bayar) as rata_rata')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->groupBy('kasir')
            ->orderByDesc('omset')
            ->get();

        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}
