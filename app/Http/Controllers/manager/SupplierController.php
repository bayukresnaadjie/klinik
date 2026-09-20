<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\PengirimanSupplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    // ── Index ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($status = $request->get('status')) {
            $query->where('aktif', $status === 'aktif');
        }

        if ($q = $request->get('q')) {
            $query->where(fn($qb) => $qb
                ->where('nama', 'like', "%{$q}%")
                ->orWhere('kota', 'like', "%{$q}%")
            );
        }

        $sort = $request->get('sort', 'nama');
        match ($sort) {
            'rating'     => $query->orderByDesc('rating'),
            'pengiriman' => $query->withCount('pengiriman')->orderByDesc('pengiriman_count'),
            default      => $query->orderBy('nama'),
        };

        $supplierList = $query->withCount('pengiriman')->get();

        // ── Summary ────────────────────────────────────────────
        $totalSupplier      = Supplier::count();
        $supplierAktif      = Supplier::aktif()->count();
        $ratingRataRata     = round(Supplier::avg('rating') ?? 0, 1);
        $pengirimanBulanIni = PengirimanSupplier::whereMonth('tanggal_kirim', now()->month)
                                                ->whereYear('tanggal_kirim',  now()->year)
                                                ->count();

        // ── Riwayat Pengiriman ─────────────────────────────────
        $riwayatPengiriman = PengirimanSupplier::with(['supplier', 'createdBy'])
            ->terbaru()
            ->paginate(15);

        return view('manager.supplier', compact(
            'totalSupplier', 'supplierAktif',
            'pengirimanBulanIni', 'ratingRataRata',
            'supplierList', 'riwayatPengiriman',
        ));
    }

    // ── Store Pengiriman ───────────────────────────────────────
    public function storePengiriman(Request $request)
    {
        $request->validate([
            'supplier_id'    => 'required|exists:supplier,id_supplier',
            'tanggal_kirim'  => 'required|date',
            'tanggal_terima' => 'nullable|date|after_or_equal:tanggal_kirim',
            'keterangan'     => 'nullable|string|max:255',
            'status'         => 'required|in:dikirim,diterima,dibatalkan',
        ]);

        PengirimanSupplier::create([
            'supplier_id'    => $request->supplier_id,
            'tanggal_kirim'  => $request->tanggal_kirim,
            'tanggal_terima' => $request->tanggal_terima,
            'keterangan'     => $request->keterangan,
            'status'         => $request->status,
            'created_by'     => Auth::id(),
        ]);

       return redirect()->route('manager.supplier')
    ->with('success', 'Pengiriman berhasil dicatat.')
    ->withFragment('riwayat');
    }

    // ── Update Status Pengiriman ───────────────────────────────
    public function updatePengiriman(Request $request, PengirimanSupplier $pengiriman)
    {
        $request->validate([
            'status'         => 'required|in:dikirim,diterima,dibatalkan',
            'tanggal_terima' => 'nullable|date',
        ]);

        $pengiriman->update([
            'status'         => $request->status,
            'tanggal_terima' => $request->tanggal_terima,
        ]);

        return back()->with('success', 'Status pengiriman berhasil diupdate.');
    }
}
