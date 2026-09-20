<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Resep;

class StrukController extends Controller
{
    public function index()
    {
        $resepSelesai = Resep::with('items.varianObat.obat')
             ->where('status', 'selesai')
    ->orderByDesc('updated_at')
    ->paginate(20);

        $resepJson = $resepSelesai->map(function($r) {
            return [
                'id'         => $r->id,
                'no_resep'   => $r->no_resep ?? 'RES-'.str_pad($r->id, 4, '0', STR_PAD_LEFT),
                'pasien'     => $r->pasien,
                'total'      => $r->total_harga,
                'updated_at' => (string) $r->updated_at,
                'items'      => $r->items->map(function($i) {
                    return [
                        'nama'             => trim((optional($i->varianObat)->nama_merek ?? '-') . ' ' . (optional($i->varianObat)->dosis_mg ? optional($i->varianObat)->dosis_mg.'mg' : '')),
                        'zat_aktif'        => optional($i->varianObat->obat)->nama_obat ?? '',
                        'jumlah'           => $i->jumlah,
                        'satuan'           => $i->satuan,
                        'sigma1'           => $i->sigma1,
                        'sigma2'           => $i->sigma2,
                        'qty1'             => $i->qty1,
                        'pagi'             => $i->pagi,
                        'siang'            => $i->siang,
                        'sore'             => $i->sore,
                        'malam'            => $i->malam,
                        'qty2'             => $i->qty2,
                        'keterangan_pakai' => $i->keterangan_pakai,
                        'harga'            => $i->harga,
                        'subtotal'         => $i->subtotal,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        return view('kasir.struk.index', compact('resepSelesai', 'resepJson'));
    }
}
