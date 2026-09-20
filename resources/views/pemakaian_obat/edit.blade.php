{{-- resources/views/pemakaian_obat/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pemakaian Obat')

@section('content')
<div class="container" style="max-width: 600px">

    <div class="page-header">
        <div>
            <h4>Edit Pemakaian Obat</h4>
            <p>Ubah jumlah, tanggal, atau keterangan pemakaian</p>
        </div>
        <a href="{{ route('pemakaian-obat.index') }}" class="btn-outline">← Kembali</a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Info varian (read-only) --}}
    <div style="background:var(--gold-pale,#F5EDD6); border:1px solid rgba(201,168,76,0.3);
                border-radius:var(--radius,10px); padding:14px 18px; margin-bottom:20px;
                display:flex; gap:14px; align-items:center">
        <div>
            <div style="font-size:11px; font-weight:500; letter-spacing:.06em;
                        text-transform:uppercase; color:#7A5C1E; margin-bottom:3px">
                Varian Obat
            </div>
            <div style="font-size:15px; font-weight:500; color:#0B1F3A">
                {{ $pemakaianObat->varianObat->nama_merek ?? '-' }}
                {{ $pemakaianObat->varianObat->dosis_mg ?? '' }} mg
            </div>
            <div style="font-size:12px; color:#7A5C1E; margin-top:2px">
                {{ $pemakaianObat->varianObat->obat->nama_obat ?? '-' }} &bull;
                {{ $pemakaianObat->varianObat->obat->jenisObat->nama_jenis ?? '-' }}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 1.5rem">
            <form action="{{ route('pemakaian-obat.update', $pemakaianObat->id_pemakaian) }}"
                  method="POST"
                  id="formEditPemakaian">
                @csrf
                @method('PUT')

                {{-- Info stok saat ini --}}
                <div id="info-stok-box"
                     style="border:1px solid #BFDBFE; border-radius:8px; padding:10px 14px;
                            font-size:13px; margin-bottom:20px; background:#EFF6FF; color:#1E40AF">
                    Memuat info stok...
                </div>

                {{-- Jumlah Dipakai --}}
                <div style="margin-bottom: 20px">
                    <label class="form-label fw-semibold">
                        Jumlah Dipakai <span style="color:#EF4444">*</span>
                    </label>
                    <input type="number"
                           name="jumlah_pakai"
                           id="jumlah_pakai"
                           class="form-control @error('jumlah_pakai') is-invalid @enderror"
                           value="{{ old('jumlah_pakai', $pemakaianObat->jumlah_pakai) }}"
                           min="1"
                           placeholder="Masukkan jumlah">
                    <div id="info-sisa" class="form-text"></div>
                    @error('jumlah_pakai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Pemakaian --}}
                <div style="margin-bottom: 20px">
                    <label class="form-label fw-semibold">
                        Tanggal Pemakaian <span style="color:#EF4444">*</span>
                    </label>
                    <input type="date"
                           name="tanggal_pakai"
                           class="form-control @error('tanggal_pakai') is-invalid @enderror"
                           value="{{ old('tanggal_pakai', $pemakaianObat->tanggal_pakai->format('Y-m-d')) }}">
                    @error('tanggal_pakai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div style="margin-bottom: 28px">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <input type="text"
                           name="keterangan"
                           class="form-control"
                           value="{{ old('keterangan', $pemakaianObat->keterangan) }}"
                           placeholder="cth: Pasien a/n Budi, Poli Umum (opsional)">
                </div>

                <div style="display:flex; gap:10px">
                    <button type="submit" class="btn-gold" id="btnSimpan">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('pemakaian-obat.index') }}" class="btn-outline">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
// Data dari server — stok tersedia + jumlah lama (dikembalikan ke stok saat edit)
const idVarian      = {{ $pemakaianObat->id_varian }};
const jumlahLama    = {{ $pemakaianObat->jumlah_pakai }};
let   totalStok     = 0;   // akan diisi setelah fetch

const warnColor = {
    expired : '#dc3545',
    kritis  : '#fd7e14',
    warning : '#0dcaf0',
    aman    : '#198754',
};

async function muatInfoStok() {
    const infoBox  = document.getElementById('info-stok-box');
    const infoSisa = document.getElementById('info-sisa');

    try {
        const res  = await fetch(`{{ route('pemakaian-obat.cek-stok') }}?id_varian=${idVarian}`);
        const data = await res.json();

        // Stok tersedia = stok saat ini + jumlah lama (karena ini edit, bukan tambah baru)
        totalStok = data.total_stok + jumlahLama;

        infoSisa.innerHTML =
            `<span class="text-success fw-semibold">Stok tersedia (termasuk jumlah lama): ${totalStok}</span>`;

        if (data.batches.length === 0) {
            infoBox.innerHTML = '<span style="color:#991B1B">Tidak ada stok batch tersedia.</span>';
            infoBox.style.cssText += 'background:#FEF2F2;border-color:#FECACA;color:#991B1B';
        } else {
            const rows = data.batches.map((b, i) => `
                <div style="display:flex; justify-content:space-between; padding:4px 0;
                            ${i < data.batches.length - 1 ? 'border-bottom:1px solid #BFDBFE' : ''}">
                    <span>
                        <strong>${i + 1}.</strong>
                        Batch <strong>${b.no_batch}</strong>
                        &mdash; <strong>${b.jumlah}</strong> pcs
                    </span>
                    <span>
                        Exp: ${b.tanggal_kadaluarsa}
                        <span style="color:${warnColor[b.status] ?? '#888'}; font-weight:500">
                            [${b.status}]
                        </span>
                    </span>
                </div>
            `).join('');

            infoBox.innerHTML =
                `<div style="font-size:11px; font-weight:500; letter-spacing:.06em;
                             text-transform:uppercase; margin-bottom:6px; color:#1E40AF">
                    Detail batch (FIFO — paling atas dipakai duluan)
                 </div>` + rows;
        }

    } catch (e) {
        document.getElementById('info-stok-box').textContent = 'Gagal memuat info stok.';
        document.getElementById('info-sisa').textContent     = '';
    }
}

// Validasi sebelum submit
document.getElementById('formEditPemakaian').addEventListener('submit', function (e) {
    const jumlah = parseInt(document.getElementById('jumlah_pakai').value);

    if (totalStok > 0 && jumlah > totalStok) {
        e.preventDefault();
        alert(`Jumlah melebihi stok tersedia (${totalStok}). Silakan kurangi jumlahnya.`);
        return;
    }

    if (jumlah < 1) {
        e.preventDefault();
        alert('Jumlah pemakaian minimal 1.');
        return;
    }
});

// Muat saat halaman siap
muatInfoStok();
</script>

@endsection
