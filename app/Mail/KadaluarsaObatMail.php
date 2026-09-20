<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class KadaluarsaObatMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Collection $stokExpired,   // batch sudah expired tapi masih ada stok
        public Collection $stokKritis,    // exp <= 30 hari
        public Collection $stokWarning,   // exp <= 90 hari
        public Collection $bawahMinimum,
        public string     $tanggalLaporan,
    ) {}

    public function envelope(): Envelope
    {
        $jumlahMasalah = $this->stokExpired->count() + $this->stokKritis->count();

        $subject = $jumlahMasalah > 0
            ? "⚠ [{$jumlahMasalah} Batch Bermasalah] Laporan Kadaluarsa Obat — Klinik Yos Benito"
            : "✓ [Semua Aman] Laporan Kadaluarsa Obat — Klinik Yos Benito";

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.kadaluarsa-obat',
        );
    }
}
