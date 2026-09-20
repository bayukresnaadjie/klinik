<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function harian(Request $request)
    {
        $tanggal = $request->get('tanggal', today()->toDateString());

        $totalResep      = Resep::whereDate('created_at', $tanggal)->count();
        $totalSelesai    = Resep::whereDate('created_at', $tanggal)->where('status', 'selesai')->count();
        $totalPendapatan = Resep::whereDate('created_at', $tanggal)->where('status', 'selesai')->sum('total_harga');
        $totalMenunggu   = Resep::whereDate('created_at', $tanggal)->where('status', 'menunggu')->count();

        $resep = Resep::whereDate('created_at', $tanggal)
            ->orderByDesc('created_at')
            ->get();

        return view('kasir.laporan.harian', compact(
            'tanggal',
            'totalResep',
            'totalSelesai',
            'totalPendapatan',
            'totalMenunggu',
            'resep'
        ));
    }
}
