<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($q = $request->get('q')) {
            $query->where(function ($qb) use ($q) {
                $qb->where('nama',  'like', "%{$q}%")
                   ->orWhere('kota', 'like', "%{$q}%")
                   ->orWhere('email','like', "%{$q}%");
            });
        }

        if ($request->get('status') === 'aktif') {
            $query->where('aktif', true);
        } elseif ($request->get('status') === 'nonaktif') {
            $query->where('aktif', false);
        }

        $suppliers = $query->orderBy('nama')->paginate(15)->withQueryString();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'kota'   => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'aktif'  => 'boolean',
        ]);

        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['rating'] = $validated['rating'] ?? 0;

        Supplier::create($validated);

        return redirect()->route('admin.supplier.index')
            ->with('success', "Supplier \"{$validated['nama']}\" berhasil ditambahkan.");
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'kota'   => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'aktif'  => 'boolean',
        ]);

        $validated['aktif']  = $request->boolean('aktif');
        $validated['rating'] = $validated['rating'] ?? 0;

        $supplier->update($validated);

        return redirect()->route('admin.supplier.index')
            ->with('success', "Supplier \"{$supplier->nama}\" berhasil diperbarui.");
    }

    public function destroy(Supplier $supplier)
    {
        $nama = $supplier->nama;
        $supplier->delete();

        return redirect()->route('admin.supplier.index')
            ->with('success', "Supplier \"{$nama}\" berhasil dihapus.");
    }

    public function toggleAktif(Supplier $supplier)
    {
        $supplier->update(['aktif' => !$supplier->aktif]);
        $status = $supplier->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Supplier \"{$supplier->nama}\" berhasil {$status}.");
    }
}
