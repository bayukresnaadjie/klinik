<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\StokObat;
use App\Models\VarianObat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = StokObat::with('varianObat.obat.jenisObat')
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_kadaluarsa');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('varianObat', fn($q) =>
                $q->where('nama_merek', 'like', "%{$cari}%")
            );
        }

        $data = $query->paginate(15)->withQueryString();

        return view('kasir.stok.index', compact('data'));
    }

    public function menipis()
    {
        $data = StokObat::with('varianObat.obat')
            ->where('jumlah', '>', 0)
            ->where('jumlah', '<', 50)
            ->orderBy('jumlah')
            ->get();

        return view('kasir.stok.menipis', compact('data'));
    }

    public function show($id)
    {
        $stok = StokObat::with('varianObat.obat.jenisObat')->findOrFail($id);

        return view('kasir.stok.show', compact('stok'));
    }
}
