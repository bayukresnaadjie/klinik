<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with('jenisObat')
                     ->withCount('varianObat')
                     ->orderBy('nama_obat');

        // Filter berdasarkan jenis (dari klik jumlah obat di halaman Jenis Obat)
        if ($request->filled('jenis')) {
            $query->where('id_jenis', $request->jenis);
        }

        $data = $query->paginate(10);

        // Untuk label filter aktif
        $filterJenis = null;
        if ($request->filled('jenis')) {
            $filterJenis = JenisObat::find($request->jenis);
        }

        return view('obat.index', compact('data', 'filterJenis'));
    }

    public function create()
    {
        $jenisObatList = JenisObat::orderBy('nama_jenis')->get();
        return view('obat.create', compact('jenisObatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis'  => 'required|exists:jenis_obat,id_jenis',
            'nama_obat' => 'required|string|max:100',
        ], [
            'id_jenis.required'  => 'Jenis obat wajib dipilih.',
            'id_jenis.exists'    => 'Jenis obat tidak valid.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
        ]);

        Obat::create($request->only('id_jenis', 'nama_obat'));

        return redirect()->route('master.obat.index')
                         ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit(Obat $obat)
    {
        $jenisObat = JenisObat::orderBy('nama_jenis')->get();
        return view('obat.edit', compact('obat', 'jenisObat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'id_jenis'  => 'required|exists:jenis_obat,id_jenis',
            'nama_obat' => 'required|string|max:100',
        ]);

        $obat->update($request->only('id_jenis', 'nama_obat'));

        return redirect()->route('master.obat.index')
                         ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        if ($obat->varianObat()->exists()) {
            return back()->with('error', 'Tidak bisa dihapus, masih ada varian obat terdaftar.');
        }

        $obat->delete();

        return redirect()->route('master.obat.index')
                         ->with('success', 'Obat berhasil dihapus.');
    }
}
