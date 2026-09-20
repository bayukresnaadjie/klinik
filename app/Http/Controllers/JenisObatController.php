<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use Illuminate\Http\Request;

class JenisObatController extends Controller
{
    public function index()
    {
        $data = JenisObat::withCount('obat')->orderBy('nama_jenis')->paginate(10);
        return view('jenis_obat.index', compact('data'));
    }

    public function create()
    {
        return view('jenis_obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jenis_obat,nama_jenis',
        ], [
            'nama_jenis.required' => 'Nama jenis obat wajib diisi.',
            'nama_jenis.unique'   => 'Jenis obat ini sudah terdaftar.',
        ]);

        JenisObat::create($request->only('nama_jenis'));

       return redirect()->route('master.jenis-obat.index')
                         ->with('success', 'Jenis obat berhasil ditambahkan.');
    }

    public function edit(JenisObat $jenisObat)
    {
        return view('jenis_obat.edit', compact('jenisObat'));
    }

    public function update(Request $request, JenisObat $jenisObat)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jenis_obat,nama_jenis,' . $jenisObat->id_jenis . ',id_jenis',
        ]);

        $jenisObat->update($request->only('nama_jenis'));

       return redirect()->route('master.jenis-obat.index')
                 ->with('success', 'Jenis obat berhasil ditambahkan.');
    }

    public function destroy(JenisObat $jenisObat)
    {
        // Cegah hapus jika masih ada obat yang pakai jenis ini
        if ($jenisObat->obat()->exists()) {
            return back()->with('error', 'Tidak bisa dihapus, masih ada obat dengan jenis ini.');
        }

        $jenisObat->delete();

        return redirect()->route('master.jenis-obat.index')
                         ->with('success', 'Jenis obat berhasil dihapus.');
    }
}
