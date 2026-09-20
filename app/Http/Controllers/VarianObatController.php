<?php

namespace App\Http\Controllers;

use App\Models\VarianObat;
use App\Models\Obat;
use Illuminate\Http\Request;

class VarianObatController extends Controller
{
    public function index()
    {
        $data = VarianObat::with('obat.jenisObat')
                          ->orderBy('nama_merek')
                          ->paginate(10);
        return view('varian_obat.index', compact('data'));
    }

    public function create()
    {
        $obatList = Obat::with('jenisObat')->orderBy('nama_obat')->get();
        return view('varian_obat.create', compact('obatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat'    => 'required|exists:obat,id_obat',
            'nama_merek' => 'required|string|max:100',
            'dosis_mg'   => 'required|integer|min:1',
            'harga'      => 'required|numeric|min:0',
        ], [
            'id_obat.required'    => 'Nama obat wajib dipilih.',
            'nama_merek.required' => 'Nama merek wajib diisi.',
            'dosis_mg.required'   => 'Dosis wajib diisi.',
            'dosis_mg.integer'    => 'Dosis harus berupa angka.',
            'harga.required'      => 'Harga wajib diisi.',
        ]);

        VarianObat::create($request->only('id_obat', 'nama_merek', 'dosis_mg', 'harga'));

        return redirect()->route('master.varian-obat.index')
                         ->with('success', 'Varian obat berhasil ditambahkan.');
    }

    public function edit(VarianObat $varianObat)
    {
        $obat = Obat::with('jenisObat')->orderBy('nama_obat')->get();
        return view('varian_obat.edit', compact('varianObat', 'obat'));
    }

    public function update(Request $request, VarianObat $varianObat)
    {
        $request->validate([
            'id_obat'    => 'required|exists:obat,id_obat',
            'nama_merek' => 'required|string|max:100',
            'dosis_mg'   => 'required|integer|min:1',
            'harga'      => 'required|numeric|min:0',
        ]);

        $varianObat->update($request->only('id_obat', 'nama_merek', 'dosis_mg', 'harga'));

        return redirect()->route('master.varian-obat.index')
                         ->with('success', 'Varian obat berhasil diperbarui.');
    }

    public function destroy(VarianObat $varianObat)
    {
        if ($varianObat->stokObat()->exists()) {
            return back()->with('error', 'Tidak bisa dihapus, masih ada data stok untuk varian ini.');
        }

        $varianObat->delete();

        return redirect()->route('master.varian-obat.index')
                         ->with('success', 'Varian obat berhasil dihapus.');
    }
}
