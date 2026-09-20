<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\StokObat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class KirimNotifKadaluarsa extends Command
{
    protected $signature   = 'notif:kadaluarsa';
    protected $description = 'Kirim notifikasi otomatis untuk stok mendekati kadaluarsa';

    public function handle(): void
    {
        $today = Carbon::today();
        $batas = $today->copy()->addDays(30);

        // Ambil stok yang hampir kadaluarsa
        $stokHampirExp = StokObat::with('varianObat')
            ->where('jumlah', '>', 0)
            ->where('tanggal_kadaluarsa', '>=', $today)
            ->where('tanggal_kadaluarsa', '<=', $batas)
            ->get();

        if ($stokHampirExp->isEmpty()) {
            $this->info('Tidak ada stok mendekati kadaluarsa.');
            return;
        }

        // Kirim ke Admin dan Manager
        $penerima = User::whereIn('role', ['admin', 'manajer'])->get();

        foreach ($stokHampirExp as $stok) {
            $namaObat  = ($stok->varianObat->nama_merek ?? '-') . ' ' . ($stok->varianObat->dosis_mg ?? '') . 'mg';
            $expDate   = Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y');
            $sisaHari  = $today->diffInDays($stok->tanggal_kadaluarsa);

            foreach ($penerima as $user) {
                // Cek apakah notifikasi hari ini sudah dikirim
                $sudahKirim = Notification::where('user_id', $user->id)
                    ->where('type', 'stok_kadaluarsa')
                    ->where('message', 'like', "%{$namaObat}%")
                    ->whereDate('created_at', $today)
                    ->exists();

                if (!$sudahKirim) {
                    Notification::kirim(
                        userId : $user->id,
                        type   : 'stok_kadaluarsa',
                        title  : '⚠️ Stok Mendekati Kadaluarsa',
                        message: "{$namaObat} — sisa {$stok->jumlah} unit, exp. {$expDate} ({$sisaHari} hari lagi)",
                        url    : route('stok-obat.index'),
                    );
                }
            }
        }

        $this->info("Notifikasi kadaluarsa berhasil dikirim untuk {$stokHampirExp->count()} item.");
    }
}
