<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $jumlahStokMinimum = 0;

        try {
            $jumlahStokMinimum = DB::table('varian_obat')
                ->join('stok_minimum', 'varian_obat.id_varian', '=', 'stok_minimum.id_varian')
                ->whereRaw('
                    COALESCE((
                        SELECT SUM(s.jumlah) FROM stok_obat s
                        WHERE s.id_varian = varian_obat.id_varian
                        AND s.tanggal_kadaluarsa > NOW()
                    ), 0) < stok_minimum.batas_minimum
                ')
                ->count();
        } catch (\Exception $e) {
            // tabel belum ada, tetap 0
        }

        $view->with('jumlahStokMinimum', $jumlahStokMinimum);
    }
}
