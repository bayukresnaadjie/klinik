<?php

// app/Imports/StokObatImport.php

namespace App\Imports;

use App\Models\StokObat;
use App\Models\VarianObat;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class StokObatImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    /** @var array Kumpulkan error per baris untuk ditampilkan ke user */
    public array $importErrors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $noBaris = $index + 2; // +2 karena baris 1 = header

            // Lewati baris kosong sepenuhnya
            if (empty(array_filter($row->toArray()))) {
                continue;
            }

            // --- Validasi manual per baris ---

            // Cari varian berdasarkan nama_merek + dosis_mg
            $namaMenuruk  = trim($row['nama_merek'] ?? '');
            $dosisMg      = trim($row['dosis_mg'] ?? '');

            if (empty($namaMenuruk) || $dosisMg === '') {
                $this->importErrors[] = "Baris {$noBaris}: nama_merek dan dosis_mg wajib diisi.";
                continue;
            }

            $varian = VarianObat::where('nama_merek', $namaMenuruk)
                                ->where('dosis_mg', (float) $dosisMg)
                                ->first();

            if (! $varian) {
                $this->importErrors[] = "Baris {$noBaris}: Varian '{$namaMenuruk} {$dosisMg}mg' tidak ditemukan di sistem.";
                continue;
            }

            // Jumlah
            $jumlah = (int) ($row['jumlah'] ?? 0);
            if ($jumlah < 1) {
                $this->importErrors[] = "Baris {$noBaris}: jumlah harus minimal 1.";
                continue;
            }

            // Tanggal masuk
            try {
                $tglMasuk = Carbon::parse($row['tanggal_masuk']);
            } catch (\Exception $e) {
                $this->importErrors[] = "Baris {$noBaris}: tanggal_masuk tidak valid (gunakan format YYYY-MM-DD).";
                continue;
            }

            // Tanggal kadaluarsa
            try {
                $tglExp = Carbon::parse($row['tanggal_kadaluarsa']);
            } catch (\Exception $e) {
                $this->importErrors[] = "Baris {$noBaris}: tanggal_kadaluarsa tidak valid (gunakan format YYYY-MM-DD).";
                continue;
            }

            if ($tglExp->lte($tglMasuk)) {
                $this->importErrors[] = "Baris {$noBaris}: tanggal_kadaluarsa harus lebih besar dari tanggal_masuk.";
                continue;
            }

            // --- Simpan ke database ---
            StokObat::create([
                'id_varian'          => $varian->id_varian,
                'no_batch'           => strtoupper(trim($row['no_batch'] ?? '')),
                'jumlah'             => $jumlah,
                'harga_satuan'       => isset($row['harga_satuan']) && $row['harga_satuan'] !== ''
                                            ? (int) $row['harga_satuan']
                                            : null,
                'tanggal_masuk'      => $tglMasuk->toDateString(),
                'tanggal_kadaluarsa' => $tglExp->toDateString(),
                'keterangan'         => trim($row['keterangan'] ?? ''),
            ]);
        }
    }
}

