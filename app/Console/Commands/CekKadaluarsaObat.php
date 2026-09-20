<?php

namespace App\Console\Commands;

use App\Mail\KadaluarsaObatMail;
use App\Models\StokObat;
use App\Models\VarianObat;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CekKadaluarsaObat extends Command
{
    protected $signature   = 'obat:cek-kadaluarsa {--email : Kirim notifikasi email ke admin dan apoteker}';
    protected $description = 'Cek stok obat yang mendekati atau sudah kadaluarsa, opsional kirim email notifikasi';

    public function handle(): int
    {
        $this->info('Memulai pengecekan kadaluarsa obat...');

        // ── 1. Cek kadaluarsa ─────────────────────────────────────
        $expired = StokObat::with('varianObat.obat')
            ->expired()->adaStok()
            ->orderBy('tanggal_kadaluarsa')->get();

        $kritis = StokObat::with('varianObat.obat')
            ->mendekatiKadaluarsa(30)
            ->orderBy('tanggal_kadaluarsa')->get();

        $warning = StokObat::with('varianObat.obat')
            ->mendekatiKadaluarsa(90)
            ->where('tanggal_kadaluarsa', '>', now()->addDays(30))
            ->orderBy('tanggal_kadaluarsa')->get();

        // ── 2. Cek stok minimum ───────────────────────────────────
        $bawahMinimum = VarianObat::with(['obat', 'stokObat'])
            ->where('alert_minimum', true)
            ->where('stok_minimum', '>', 0)
            ->get()
            ->filter(function ($v) {
                $stokAktual    = $v->stokObat->where('jumlah', '>', 0)->sum('jumlah');
                $v->stok_aktual = $stokAktual;
                return $stokAktual <= $v->stok_minimum;
            });

        // ── 3. Output ke terminal ─────────────────────────────────
        if ($expired->isNotEmpty()) {
            $this->error("⚠ {$expired->count()} batch sudah EXPIRED:");
            foreach ($expired as $s) {
                $this->line("  - {$s->varianObat->nama_merek} {$s->varianObat->dosis_mg}mg | Exp: {$s->tanggal_kadaluarsa->format('d/m/Y')} | Stok: {$s->jumlah}");
            }
        }

        if ($kritis->isNotEmpty()) {
            $this->warn("⏰ {$kritis->count()} batch kritis (≤30 hari):");
            foreach ($kritis as $s) {
                $this->line("  - {$s->varianObat->nama_merek} {$s->varianObat->dosis_mg}mg | Exp: {$s->tanggal_kadaluarsa->format('d/m/Y')} | Sisa: {$s->sisa_hari} hari");
            }
        }

        if ($warning->isNotEmpty()) {
            $this->info("ℹ {$warning->count()} batch perlu diwaspadai (≤90 hari)");
        }

        if ($bawahMinimum->isNotEmpty()) {
            $this->warn("📦 {$bawahMinimum->count()} varian stoknya di bawah minimum:");
            foreach ($bawahMinimum as $v) {
                $this->line("  - {$v->nama_merek} {$v->dosis_mg}mg | Stok: {$v->stok_aktual} | Min: {$v->stok_minimum}");
            }
        }

        if ($expired->isEmpty() && $kritis->isEmpty() && $warning->isEmpty() && $bawahMinimum->isEmpty()) {
            $this->info('✓ Semua stok obat dalam kondisi aman.');
        }

        // ── 4. Kirim email ────────────────────────────────────────
        $kirimEmail = $this->option('email');

        if (!$kirimEmail && ($expired->isNotEmpty() || $kritis->isNotEmpty() || $bawahMinimum->isNotEmpty())) {
            $kirimEmail = true;
            $this->info('Email akan dikirim otomatis karena ada masalah stok.');
        }

        if ($kirimEmail) {
            // Teruskan $bawahMinimum sebagai parameter
            $this->kirimEmail($expired, $kritis, $warning, $bawahMinimum);
        }

        // ── 5. Log audit trail ────────────────────────────────────
        Log::channel('daily')->info('Cek kadaluarsa obat selesai', [
            'expired'        => $expired->count(),
            'kritis'         => $kritis->count(),
            'warning'        => $warning->count(),
            'bawah_minimum'  => $bawahMinimum->count(),
            'email_terkirim' => $kirimEmail,
        ]);

        $this->info('Pengecekan selesai.');
        return Command::SUCCESS;  // ← return ada di paling bawah
    }

    private function kirimEmail($expired, $kritis, $warning, $bawahMinimum): void
    {
        // $bawahMinimum diterima sebagai parameter — tidak undefined lagi
        $penerima = User::whereIn('role', ['admin', 'apoteker'])
            ->where('aktif', true)
            ->whereNotNull('email')
            ->get();

        if ($penerima->isEmpty()) {
            $this->warn('Tidak ada penerima email (admin/apoteker aktif).');
            return;
        }

        $tanggalLaporan = now()->isoFormat('dddd, D MMMM Y');

        $mail = new KadaluarsaObatMail(
            stokExpired:    $expired,
            stokKritis:     $kritis,
            stokWarning:    $warning,
            bawahMinimum:   $bawahMinimum,
            tanggalLaporan: $tanggalLaporan,
        );

        $berhasil = 0;
        $gagal    = 0;

        foreach ($penerima as $user) {
            try {
                Mail::to($user->email, $user->name)->send($mail);
                $berhasil++;
                $this->info("  ✓ Email terkirim ke {$user->name} ({$user->email})");
            } catch (\Exception $e) {
                $gagal++;
                $this->error("  ✗ Gagal kirim ke {$user->email}: {$e->getMessage()}");
                Log::error('Gagal kirim email kadaluarsa', [
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Email: {$berhasil} berhasil, {$gagal} gagal.");
    }
}
