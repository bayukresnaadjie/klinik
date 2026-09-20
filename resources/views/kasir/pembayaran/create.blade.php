@extends('layouts.kasir')

@section('title', 'Pembayaran Baru')
@section('page-title', 'Pembayaran Baru')

@section('content')

    <div style="max-width:700px;">

        <div style="margin-bottom:20px;">
            <a href="{{ route('kasir.pembayaran.index') }}"
                style="color:var(--text-muted); text-decoration:none; font-size:13px;">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('kasir.pembayaran.store') }}">
            @csrf

            {{-- Info Resep --}}
            <div
                style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:16px;">
                <div
                    style="font-size:11px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
                    Informasi Resep</div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div>
                        <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Nama
                            Pasien *</label>
                        <input type="text" name="nama_pasien" value="{{ old('nama_pasien') }}" placeholder="Nama pasien"
                            style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Jenis
                            Pembayaran *</label>
                        <select name="jenis_pembayaran"
                            style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            <option value="umum">Umum</option>
                            <option value="bpjs">BPJS</option>
                            <option value="asuransi">Asuransi</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Rincian Pembayaran --}}
            <div
                style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:16px;">
                <div
                    style="font-size:11px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
                    Rincian Pembayaran</div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div>
                        <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Total
                            Tagihan</label>
                        <input type="number" name="total_harga" value="{{ old('total_harga', 0) }}" min="0"
                            style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Jumlah
                            Dibayar</label>
                        <input type="number" name="jumlah_bayar" value="{{ old('jumlah_bayar', 0) }}" min="0"
                            id="jumlah_bayar" oninput="hitungKembalian()"
                            style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                    </div>
                    <div>
                        <label
                            style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Kembalian</label>
                        <input type="text" id="kembalian" readonly value="Rp 0"
                            style="width:100%; background:var(--bg-card-alt,#1b1f2a); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--accent-cyan); font-size:13px; font-family:'IBM Plex Mono',monospace; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:var(--text-secondary); margin-bottom:6px;">Metode
                            Pembayaran</label>
                        <select name="metode_bayar"
                            style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none;">
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                            <option value="debit">Kartu Debit</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            <div
                style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:20px;">
                <div
                    style="font-size:11px; font-family:'IBM Plex Mono',monospace; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
                    Catatan</div>
                <textarea name="catatan" rows="3" placeholder="Catatan tambahan (opsional)"
                    style="width:100%; background:var(--bg-base); border:1px solid var(--border); border-radius:7px; padding:9px 12px; color:var(--text-primary); font-size:13px; font-family:'DM Sans',sans-serif; outline:none; resize:vertical;">{{ old('catatan') }}</textarea>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit"
                    style="background:var(--accent-cyan); color:#0a1a1a; font-weight:700; padding:10px 28px; border-radius:8px; border:none; cursor:pointer; font-size:13px; font-family:'DM Sans',sans-serif;">
                    Proses Pembayaran
                </button>
                <a href="{{ route('kasir.pembayaran.index') }}"
                    style="background:var(--bg-card); color:var(--text-secondary); border:1px solid var(--border); padding:10px 20px; border-radius:8px; font-size:13px; text-decoration:none; display:inline-flex; align-items:center;">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        function hitungKembalian() {
            const total = parseFloat(document.querySelector('[name=total_harga]').value) || 0;
            const bayar = parseFloat(document.getElementById('jumlah_bayar').value) || 0;
            const kembalian = bayar - total;
            document.getElementById('kembalian').value =
                'Rp ' + (kembalian >= 0 ? kembalian : 0).toLocaleString('id-ID');
        }
    </script>
@endpush
