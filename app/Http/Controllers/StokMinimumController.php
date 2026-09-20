<?php

namespace App\Http\Controllers;

use App\Models\VarianObat;
use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMinimumController extends Controller
{
    /**
     * Halaman utama — daftar semua varian dengan status stok minimum.
     */
    public function index(Request $request)
{
    $query = VarianObat::with(['obat.jenisObat', 'stokObat']);

    // Filter search — blade pakai 'search', bukan 'cari'
    if ($request->filled('search')) {
        $cari = $request->search;
        $query->where(function ($q) use ($cari) {
            $q->where('nama_merek', 'like', "%{$cari}%")
              ->orWhereHas('obat', fn($q2) => $q2->where('nama_obat', 'like', "%{$cari}%"));
        });
    }

    // Filter jenis — blade pakai 'jenis_obat_id'
    if ($request->filled('jenis_obat_id')) {
        $query->whereHas('obat', fn($q) => $q->where('id_obat', $request->jenis_obat_id));
    }

    // Filter status
    if ($request->get('status') === 'bawah') {
        $query->where('alert_minimum', true)->where('stok_minimum', '>', 0);
    } elseif ($request->get('status') === 'aktif') {
        $query->alertAktif();
    }

    $semuaVarian = VarianObat::with('stokObat')->get()->map(function ($v) {
        $v->total_stok_aktual = $v->stokObat->where('jumlah', '>', 0)->sum('jumlah');
        return $v;
    });

    // Summary stats — sesuai nama variabel di blade
    $totalVarian  = $semuaVarian->count();
    $alertAktif   = $semuaVarian->where('alert_minimum', true)->where('stok_minimum', '>', 0)->count();
    $bawahMinimum = $semuaVarian->filter(fn($v) =>
        $v->alert_minimum && $v->stok_minimum > 0 && $v->total_stok_aktual <= $v->stok_minimum
    )->count();
    $stokHabis = $semuaVarian->filter(fn($v) => $v->total_stok_aktual === 0)->count();

    // varianList — sesuai nama di blade
 $varianList = $query->orderBy('nama_merek')->get()->map(function ($v) {
    $v->loadMissing(['obat.jenisObat']); // ← tambah ini
    $v->stok        = $v->stokObat->where('jumlah', '>', 0)->sum('jumlah');
    $v->alert_aktif = $v->alert_minimum;
    $v->nama        = $v->nama_merek;
    return $v;
});
    // Filter status habis (perlu filter setelah map)
    if ($request->get('status') === 'habis') {
        $varianList = $varianList->filter(fn($v) => $v->stok === 0)->values();
    }

    $jenisObatList = JenisObat::orderBy('nama_jenis')->get();

    return view('stok-minimum.index', compact(
        'varianList',
        'totalVarian',
        'alertAktif',
        'bawahMinimum',
        'stokHabis',
        'jenisObatList',
    ));
}

    /**
     * Update stok minimum satu varian.
     */
    public function update(Request $request, VarianObat $varianObat)
    {
        $request->validate([
            'stok_minimum'  => 'required|integer|min:0',
            'alert_minimum' => 'boolean',
        ], [
            'stok_minimum.required' => 'Stok minimum wajib diisi.',
            'stok_minimum.min'      => 'Stok minimum tidak boleh negatif.',
        ]);

        $varianObat->update([
            'stok_minimum'  => $request->stok_minimum,
            'alert_minimum' => $request->boolean('alert_minimum'),
        ]);

        return back()->with('success',
            "Stok minimum {$varianObat->nama_merek} berhasil diperbarui menjadi {$request->stok_minimum}."
        );
    }

    /**
     * Update stok minimum massal (semua varian sekaligus dari form tabel).
     */
   public function updateMassal(Request $request)
{
    $diupdate = 0;

    DB::transaction(function () use ($request, &$diupdate) {
        foreach ($request->input('minimum', []) as $id => $nilai) {
            VarianObat::where('id_varian', $id)->update([
                'stok_minimum'  => (int) $nilai,
                'alert_minimum' => isset($request->input('alert', [])[$id]),
            ]);
            $diupdate++;
        }
    });

    return back()->with('success', "{$diupdate} varian obat berhasil diperbarui.");
}

    /**
     * AJAX: ambil daftar varian yang stoknya di bawah minimum
     * untuk ditampilkan di dashboard sebagai notifikasi.
     */
    public function alertBawahMinimum()
    {
        $data = VarianObat::with(['obat', 'stokObat'])
            ->alertAktif()
            ->get()
            ->filter(fn($v) => $v->stokObat->where('jumlah', '>', 0)->sum('jumlah') <= $v->stok_minimum)
            ->map(fn($v) => [
                'id_varian'     => $v->id_varian,
                'nama_merek'    => $v->nama_merek,
                'nama_obat'     => $v->obat->nama_obat ?? '-',
                'dosis_mg'      => $v->dosis_mg,
                'total_stok'    => $v->stokObat->where('jumlah', '>', 0)->sum('jumlah'),
                'stok_minimum'  => $v->stok_minimum,
                'selisih'       => $v->stok_minimum - $v->stokObat->where('jumlah', '>', 0)->sum('jumlah'),
                'status'        => $v->stokObat->where('jumlah', '>', 0)->sum('jumlah') === 0 ? 'habis' : 'kritis',
            ])
            ->sortByDesc('selisih')
            ->values();

        return response()->json([
            'status' => 'ok',
            'jumlah' => $data->count(),
            'data'   => $data,
        ]);
    }

    /**
    * Static helper untuk komponen Blade / navigasi.
 * Mengembalikan Collection varian yang stoknya ≤ minimum.
 */
 public static function getVarianKritis(): \Illuminate\Support\Collection
    {
        return VarianObat::with(['obat', 'stokObat'])
            ->alertAktif()
            ->get()
            ->filter(fn($v) =>
                $v->stokObat->where('jumlah', '>', 0)->sum('jumlah') <= $v->stok_minimum
            )
            ->map(fn($v) => [
                'id_varian'    => $v->id_varian,
                'nama_merek'   => $v->nama_merek,
                'nama_obat'    => $v->obat->nama_obat ?? '-',
                'dosis_mg'     => $v->dosis_mg,
                'total_stok'   => $v->stokObat->where('jumlah', '>', 0)->sum('jumlah'),
                'stok_minimum' => $v->stok_minimum,
                'selisih'      => $v->stok_minimum - $v->stokObat->where('jumlah', '>', 0)->sum('jumlah'),
                'status'       => $v->stokObat->where('jumlah', '>', 0)->sum('jumlah') === 0
                                    ? 'habis' : 'kritis',
            ])
            ->sortByDesc('selisih')
            ->values();
    }
}
