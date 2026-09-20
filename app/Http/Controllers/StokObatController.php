<?php

namespace App\Http\Controllers;

use App\Imports\StokObatImport;
use App\Models\StokObat;
use App\Models\VarianObat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StokObatController extends Controller
{
    // ------------------------------------------------------------------
    // Index — daftar semua stok
    // ------------------------------------------------------------------
    public function index(Request $request)
{
    $query = StokObat::with('varianObat.obat.jenisObat');

    // --- Filter: pencarian teks ---
    if ($request->filled('cari')) {
        $cari = $request->cari;
        $query->whereHas('varianObat', function ($q) use ($cari) {
            $q->where('nama_merek', 'like', "%{$cari}%")
              ->orWhere('no_batch', 'like', "%{$cari}%")
              ->orWhereHas('obat', fn($q2) => $q2->where('nama_obat', 'like', "%{$cari}%"));
        })->orWhere('no_batch', 'like', "%{$cari}%");
    }

    // --- Filter: jenis obat ---
    if ($request->filled('jenis') && $request->jenis !== 'semua') {
        $query->whereHas('varianObat.obat', function ($q) use ($request) {
            $q->where('id_jenis', $request->jenis);
        });
    }

    // --- Filter: status kadaluarsa ---
    switch ($request->get('status', 'semua')) {
        case 'ada_stok':
            $query->where('jumlah', '>', 0);
            break;
        case 'kritis':
            $query->where('jumlah', '>', 0)
                  ->whereBetween('tanggal_kadaluarsa', [today(), today()->addDays(30)]);
            break;
        case 'warning':
            $query->where('jumlah', '>', 0)
                  ->whereBetween('tanggal_kadaluarsa', [today()->addDays(31), today()->addDays(90)]);
            break;
        case 'expired':
            $query->where('jumlah', '>', 0)
                  ->where('tanggal_kadaluarsa', '<', today());
            break;
        case 'habis':
            $query->where('jumlah', 0);
            break;
    }

    // --- Filter: rentang tanggal masuk ---
    if ($request->filled('dari')) {
        $query->where('tanggal_masuk', '>=', $request->dari);
    }
    if ($request->filled('sampai')) {
        $query->where('tanggal_masuk', '<=', $request->sampai);
    }

    // --- Sorting ---
    $sortable = ['tanggal_kadaluarsa', 'tanggal_masuk', 'jumlah'];
    $sort     = in_array($request->get('sort'), $sortable)
                    ? $request->sort
                    : 'tanggal_kadaluarsa';
    $query->orderBy($sort);

    // Variabel $data — sesuai nama yang dipakai di blade
    $data = $query->paginate(20)->withQueryString();

    // --- Summary untuk alert banner ---
    $jumlahExpired = StokObat::where('jumlah', '>', 0)
                             ->where('tanggal_kadaluarsa', '<', today())
                             ->count();

    $jumlahKritis  = StokObat::where('jumlah', '>', 0)
                             ->whereBetween('tanggal_kadaluarsa', [today(), today()->addDays(30)])
                             ->count();

    // --- Dropdown filter jenis obat ---
    $jenisObatList = \App\Models\JenisObat::orderBy('nama_jenis')->get();

    return view('stok_obat.index', compact(
        'data',
        'jumlahExpired',
        'jumlahKritis',
        'jenisObatList'
    ));
}

    // ------------------------------------------------------------------
    // Create — form tambah stok baru
    // ------------------------------------------------------------------
   public function create()
{
    $varian = VarianObat::with('obat.jenisObat')  // tambah jenisObat
                ->orderBy('nama_merek')
                ->get();

    return view('stok_obat.create', compact('varian'));
}

    // ------------------------------------------------------------------
    // Store — simpan stok baru
    // ------------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'id_varian'          => 'required|exists:varian_obat,id_varian',
            'no_batch'           => 'nullable|string|max:100',
            'jumlah'             => 'required|integer|min:1',
            'harga_satuan'       => 'nullable|integer|min:0',
            'tanggal_masuk'      => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'keterangan'         => 'nullable|string|max:255',
        ]);

        StokObat::create([
            'id_varian'          => $request->id_varian,
            'no_batch'           => strtoupper($request->no_batch ?? ''),
            'jumlah'             => $request->jumlah,
            'harga_satuan'       => $request->harga_satuan,
            'tanggal_masuk'      => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'keterangan'         => $request->keterangan,
        ]);

        return redirect()->route('stok-obat.index')
                         ->with('success', 'Stok obat berhasil ditambahkan.');
    }

    // ------------------------------------------------------------------
    // Edit — form edit stok
    // ------------------------------------------------------------------
    public function edit($id)
    {
        $stokObat = StokObat::with('varianObat.obat.jenisObat')->findOrFail($id);

        return view('stok_obat.edit', compact('stokObat'));
    }

    // ------------------------------------------------------------------
    // Update — simpan perubahan stok
    // ------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        $stokObat = StokObat::findOrFail($id);

        $request->validate([
            'no_batch'           => 'nullable|string|max:100',
            'jumlah'             => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'required|date|after:' . $stokObat->tanggal_masuk->toDateString(),
            'keterangan'         => 'nullable|string|max:255',
        ]);

        $stokObat->update([
            'no_batch'           => strtoupper($request->no_batch ?? ''),
            'jumlah'             => $request->jumlah,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'keterangan'         => $request->keterangan,
        ]);

        return redirect()->route('stok-obat.index')
                         ->with('success', 'Stok obat berhasil diperbarui.');
    }

    // ------------------------------------------------------------------
    // Destroy — hapus stok
    // ------------------------------------------------------------------
    public function destroy($id)
    {
        StokObat::findOrFail($id)->delete();

        return redirect()->route('stok-obat.index')
                         ->with('success', 'Stok obat berhasil dihapus.');
    }

    // ------------------------------------------------------------------
    // Import — tampilkan form upload Excel
    // ------------------------------------------------------------------
    public function importForm()
    {
        return view('stok_obat.import');
    }

    // ------------------------------------------------------------------
    // Import — proses upload & simpan dari Excel
    // ------------------------------------------------------------------
    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'Pilih file Excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus .xlsx atau .xls.',
            'file.max'      => 'Ukuran file maksimal 5 MB.',
        ]);

        $import = new StokObatImport();

        Excel::import($import, $request->file('file'));

        $errors   = $import->importErrors;
        $failures = $import->failures();

        foreach ($failures as $failure) {
            $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
        }

        $totalGagal  = count($errors);
        $pesanSukses = $totalGagal > 0
            ? "Import selesai. {$totalGagal} baris dilewati karena error."
            : 'Import berhasil! Semua baris berhasil dimasukkan ke sistem.';

        if ($totalGagal > 0) {
            return redirect()->route('stok-obat.import.form')
                             ->with('success', $pesanSukses)
                             ->with('import_errors', $errors);
        }

        return redirect()->route('stok-obat.index')
                         ->with('success', $pesanSukses);
    }

    // ------------------------------------------------------------------
    // Download template Excel untuk import
    // ------------------------------------------------------------------
    public function downloadTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Stok Obat');

        $headers = [
            'A1' => 'nama_merek',
            'B1' => 'dosis_mg',
            'C1' => 'no_batch',
            'D1' => 'jumlah',
            'E1' => 'harga_satuan',
            'F1' => 'tanggal_masuk',
            'G1' => 'tanggal_kadaluarsa',
            'H1' => 'keterangan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFF3CD'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CCA500'],
                ],
            ],
        ]);

        $sheet->fromArray([
            'Paracetamol GSK', 500, 'BTH-2024-001', 100, 1500,
            date('Y-m-d'), date('Y-m-d', strtotime('+2 years')), 'PBF Kimia Farma',
        ], null, 'A2');

        $sheet->getStyle('A2:H2')->applyFromArray([
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F1F5F9'],
            ],
        ]);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        $panduan = $spreadsheet->createSheet();
        $panduan->setTitle('Panduan');
        $panduan->setCellValue('A1', 'Panduan Pengisian Template Import Stok Obat');
        $panduan->getStyle('A1')->getFont()->setBold(true)->setSize(13);

        $panduan->fromArray([
            ['Kolom',               'Keterangan',                                                     'Wajib'],
            ['nama_merek',          'Harus cocok persis dengan nama merek varian di sistem',          'Ya'],
            ['dosis_mg',            'Angka saja tanpa satuan, contoh: 500',                           'Ya'],
            ['no_batch',            'Nomor batch dari supplier, boleh dikosongkan',                   'Tidak'],
            ['jumlah',              'Jumlah stok yang masuk, minimal 1',                              'Ya'],
            ['harga_satuan',        'Harga per satuan dalam rupiah (angka saja), boleh kosong',       'Tidak'],
            ['tanggal_masuk',       'Format YYYY-MM-DD, contoh: 2024-01-15',                          'Ya'],
            ['tanggal_kadaluarsa',  'Format YYYY-MM-DD, harus lebih besar dari tanggal_masuk',        'Ya'],
            ['keterangan',          'Nama supplier atau catatan tambahan, boleh kosong',              'Tidak'],
        ], null, 'A3');

        $panduan->getStyle('A3:C3')->getFont()->setBold(true);
        foreach (range('A', 'C') as $col) {
            $panduan->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="template_import_stok_obat.xlsx"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
