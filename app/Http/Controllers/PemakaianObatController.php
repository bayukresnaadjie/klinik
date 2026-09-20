<?php

namespace App\Http\Controllers;

use App\Models\PemakaianObat;
use App\Models\StokObat;
use App\Models\VarianObat;
use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianObatController extends Controller
{
    public function index(Request $request)
    {

        $query = PemakaianObat::with(['varianObat.obat.jenisObat', 'stokObat']);

        // ── Pencarian teks ────────────────────────────────────────
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('keterangan', 'like', "%{$cari}%")
                  ->orWhereHas('varianObat', function ($q2) use ($cari) {
                      $q2->where('nama_merek', 'like', "%{$cari}%")
                         ->orWhereHas('obat', fn($q3) =>
                             $q3->where('nama_obat', 'like', "%{$cari}%")
                         );
                  });
            });
        }

        // ── Filter jenis obat ─────────────────────────────────────
        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->whereHas('varianObat.obat.jenisObat', fn($q) =>
                $q->where('id_jenis', $request->jenis)
            );
        }

        // ── Filter tanggal pemakaian ──────────────────────────────
        if ($request->filled('dari')) {
            $query->where('tanggal_pakai', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tanggal_pakai', '<=', $request->sampai);
        }

        // ── Urutan ────────────────────────────────────────────────
        $query->orderBy('tanggal_pakai', 'desc')->orderBy('created_at', 'desc');

        // ── Paginate (nama variabel disesuaikan dengan blade) ─────
        $pemakaianList = $query->paginate(15)->withQueryString();

        // ── Ringkasan hasil filter ────────────────────────────────
        $totalJumlah = PemakaianObat::when($request->filled('dari'), fn($q) =>
                            $q->where('tanggal_pakai', '>=', $request->dari))
                        ->when($request->filled('sampai'), fn($q) =>
                            $q->where('tanggal_pakai', '<=', $request->sampai))
                        ->sum('jumlah_pakai');

        // ── Stat cards ────────────────────────────────────────────
        $totalPemakaian = PemakaianObat::sum('jumlah_pakai');

        $pemakaianBulanIni = PemakaianObat::whereMonth('tanggal_pakai', now()->month)
                                ->whereYear('tanggal_pakai', now()->year)
                                ->sum('jumlah_pakai');

       // SESUDAH (benar)
$nilaiPemakaian = PemakaianObat::with('varianObat')
                    ->whereMonth('tanggal_pakai', now()->month)
                    ->whereYear('tanggal_pakai', now()->year)
                    ->get()
                    ->sum(fn($p) => $p->jumlah_pakai * ($p->varianObat->harga ?? 0));

        $jumlahJenis = PemakaianObat::whereMonth('tanggal_pakai', now()->month)
                        ->whereYear('tanggal_pakai', now()->year)
                        ->with('varianObat')
                        ->get()
                        ->pluck('varianObat.id_varian')
                        ->unique()
                        ->count();
        // Tambahkan setelah $jumlahJenis
$bulanLalu = now()->subMonth()->month;
$tahunLalu = now()->subMonth()->year;

$pemakaianBulanLalu = PemakaianObat::whereMonth('tanggal_pakai', $bulanLalu)
                        ->whereYear('tanggal_pakai', $tahunLalu)
                        ->sum('jumlah_pakai');

$nilaiPemakaianLalu = PemakaianObat::with('varianObat')
                        ->whereMonth('tanggal_pakai', $bulanLalu)
                        ->whereYear('tanggal_pakai', $tahunLalu)
                        ->get()
                        ->sum(fn($p) => $p->jumlah_pakai * ($p->varianObat->harga ?? 0));

        // ── Dropdown filter jenis obat ────────────────────────────
        $jenisObatList = JenisObat::orderBy('nama_jenis')->get();

        // ── Dropdown varian untuk modal catat pemakaian ───────────
        $varianList = VarianObat::with('obat')
                        ->whereHas('stokObat', fn($q) => $q->adaStok())
                        ->orderBy('nama_merek')
                        ->get()
                        ->map(function ($v) {
                            $v->stok = $v->stokObat()->adaStok()->sum('jumlah');
                            return $v;
                        });

        return view('pemakaian_obat.index', compact(
            'pemakaianList',
            'totalJumlah',
            'jenisObatList',
            'totalPemakaian',
            'pemakaianBulanIni',
            'nilaiPemakaian',
            'jumlahJenis',
            'varianList',
            'pemakaianBulanLalu',
'nilaiPemakaianLalu',
        ));
    }

    public function create()
    {
        $varian = VarianObat::with('obat')
            ->whereHas('stokObat', fn($q) => $q->adaStok())
            ->orderBy('nama_merek')
            ->get()
            ->map(function ($v) {
                $v->total_stok = $v->stokObat()->adaStok()->sum('jumlah');
                return $v;
            });

        return view('pemakaian_obat.create', compact('varian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_varian'     => 'required|exists:varian_obat,id_varian',
            'jumlah_pakai'  => 'required|integer|min:1',
            'tanggal_pakai' => 'required|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $idVarian  = $request->id_varian;
        $sisaAmbil = $request->jumlah_pakai;
        $totalStok = StokObat::where('id_varian', $idVarian)->adaStok()->sum('jumlah');

        if ($totalStok < $sisaAmbil) {
            return back()->withInput()
                ->with('error', "Stok tidak cukup. Tersedia: {$totalStok}.");
        }

        DB::transaction(function () use ($idVarian, $sisaAmbil, $request) {
            $batches = StokObat::where('id_varian', $idVarian)
                ->adaStok()->orderBy('tanggal_kadaluarsa')->get();

            foreach ($batches as $batch) {
                if ($sisaAmbil <= 0) break;
                $ambil = min($sisaAmbil, $batch->jumlah);
                PemakaianObat::create([
                    'id_varian'    => $idVarian,
                    'id_stok'      => $batch->id_stok,
                    'jumlah_pakai' => $ambil,
                    'tanggal_pakai'=> $request->tanggal_pakai,
                    'keterangan'   => $request->keterangan,
                ]);
                $batch->decrement('jumlah', $ambil);
                $sisaAmbil -= $ambil;
            }
        });

        return redirect()->route('pemakaian-obat.index')
                         ->with('success', 'Pemakaian obat berhasil dicatat.');
    }

    public function destroy(PemakaianObat $pemakaianObat)
    {
        DB::transaction(function () use ($pemakaianObat) {
            $pemakaianObat->stokObat->increment('jumlah', $pemakaianObat->jumlah_pakai);
            $pemakaianObat->delete();
        });

        return redirect()->route('pemakaian-obat.index')
                         ->with('success', 'Pemakaian dibatalkan dan stok dikembalikan.');
    }

    public function cekStok(Request $request)
    {
        $varian = VarianObat::with(['stokObat' => fn($q) => $q->adaStok()->orderBy('tanggal_kadaluarsa')])
                            ->findOrFail($request->id_varian);

        return response()->json([
            'total_stok' => $varian->stokObat->sum('jumlah'),
            'batches'    => $varian->stokObat->map(fn($s) => [
                'no_batch'           => $s->no_batch ?? '-',
                'jumlah'             => $s->jumlah,
                'tanggal_kadaluarsa' => $s->tanggal_kadaluarsa->format('d/m/Y'),
                'status'             => $s->status_kadaluarsa,
            ]),
        ]);
    }
}
