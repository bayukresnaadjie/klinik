@extends('layouts.kasir')

@section('title', 'Edit Resep')
@section('page-title', 'Edit Resep')

@push('styles')
    <style>
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            color: var(--text-muted);
            font-family: 'IBM Plex Mono', monospace;
        }

        .breadcrumb a {
            color: var(--accent-cyan);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            font-family: 'IBM Plex Mono', monospace;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 16px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-cyan);
            flex-shrink: 0;
        }

        .card-body {
            padding: 20px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            background: var(--bg-card-alt);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            transition: border .15s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--accent-cyan);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        select.form-input {
            cursor: pointer;
        }

        .form-error {
            font-size: 11px;
            color: var(--accent-red);
            margin-top: 4px;
        }

        /* ITEMS */
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 1fr 100px 100px 36px;
            gap: 10px;
            align-items: center;
            background: var(--bg-card-alt);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 14px;
        }

        .item-name {
            font-size: 13px;
            font-weight: 600;
        }

        .item-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .item-qty {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            font-family: 'IBM Plex Mono', monospace;
            width: 100%;
            text-align: center;
            outline: none;
            transition: border .15s;
        }

        .item-qty:focus {
            border-color: var(--accent-cyan);
        }

        .item-harga {
            font-size: 12px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-secondary);
        }

        .item-subtotal {
            font-size: 13px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
            font-weight: 600;
        }

        .btn-remove {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .2);
            color: var(--accent-red);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
            flex-shrink: 0;
        }

        .btn-remove:hover {
            background: rgba(239, 68, 68, .2);
        }

        /* ADD ITEM */
        .add-item-area {
            background: var(--bg-card-alt);
            border: 1px dashed var(--border-light);
            border-radius: 8px;
            padding: 16px;
        }

        .add-item-grid {
            display: grid;
            grid-template-columns: 1fr 100px;
            gap: 10px;
            margin-bottom: 10px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 7px;
            background: rgba(0, 200, 200, .1);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 200, 200, .2);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-add:hover {
            background: rgba(0, 200, 200, .2);
        }

        /* TOTAL */
        .total-bar {
            background: var(--bg-card-alt);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 12px;
            color: var(--text-muted);
            font-family: 'IBM Plex Mono', monospace;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .total-value {
            font-size: 20px;
            font-weight: 700;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity .15s, background .15s;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary {
            background: var(--accent-cyan);
            color: #0a1a1a;
        }

        .btn-primary:hover {
            opacity: .88;
        }

        .btn-secondary {
            background: var(--bg-card-alt);
            color: var(--text-primary);
            border: 1px solid var(--border-light);
        }

        .btn-secondary:hover {
            background: var(--bg-hover);
        }

        .btn-danger {
            background: rgba(239, 68, 68, .15);
            color: var(--accent-red);
            border: 1px solid rgba(239, 68, 68, .25);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, .25);
        }

        .side-info {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .side-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
        }

        .side-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .08em;
            font-family: 'IBM Plex Mono', monospace;
        }

        .side-body {
            padding: 16px 18px;
        }

        .side-row {
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .side-row:last-child {
            border-bottom: none;
        }

        .side-label {
            font-size: 10px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .side-val {
            font-size: 14px;
            font-weight: 600;
        }

        .side-val.mono {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
            font-size: 13px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            letter-spacing: .04em;
        }

        .status-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pill.menunggu {
            background: rgba(245, 158, 11, .15);
            color: #fbbf24;
        }

        .status-pill.selesai {
            background: rgba(34, 197, 94, .15);
            color: var(--accent-green);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .25);
            color: var(--accent-red);
        }

        .empty-items {
            padding: 24px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 16px 0;
        }
    </style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('kasir.resep.index') }}">← Daftar Resep</a>
        <span>/</span>
        <a href="{{ route('kasir.resep.show', $resep->id) }}">Detail #{{ $resep->id }}</a>
        <span>/</span>
        <span>Edit</span>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Resep</h1>
            <p class="page-subtitle">{{ $resep->no_resep ?? 'RES-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
        <a href="{{ route('kasir.resep.show', $resep->id) }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('kasir.resep.update', $resep->id) }}" id="form-edit">
        @csrf
        @method('PUT')

        <div class="edit-grid">

            {{-- KIRI --}}
            <div>
                {{-- Info Pasien --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-title-dot"></span>
                            Informasi Pasien
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Nama Pasien <span style="color:var(--accent-red)">*</span></label>
                            <input type="text" name="nama_pasien" class="form-input"
                                value="{{ old('nama_pasien', $resep->pasien) }}" placeholder="Masukkan nama pasien"
                                required>
                            @error('nama_pasien')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Dokter</label>
                            <input type="text" name="dokter" class="form-input"
                                value="{{ old('dokter', $resep->dokter) }}" placeholder="Nama dokter pemeriksa">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-input" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('catatan', $resep->catatan) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Daftar Obat --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-title-dot" style="background:var(--accent-blue)"></span>
                            Daftar Obat
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Item list yang sudah ada --}}
                        <div class="items-list" id="items-list">
                            @forelse($resep->items as $i => $item)
                                <div class="item-row" id="item-row-{{ $i }}">
                                    <input type="hidden" name="items[{{ $i }}][id_varian]"
                                        value="{{ $item->id_varian }}">
                                    <div>
                                        <div class="item-name">{{ $item->varianObat->nama_merek ?? '-' }}</div>
                                        <div class="item-sub">
                                            {{ $item->varianObat->obat->nama_obat ?? '' }}
                                            @if ($item->varianObat->dosis_mg ?? false)
                                                · {{ $item->varianObat->dosis_mg }}mg
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <input type="number" name="items[{{ $i }}][jumlah]" class="item-qty"
                                            value="{{ $item->jumlah }}" min="1"
                                            data-harga="{{ $item->harga ?? 0 }}" onchange="hitungTotal()">
                                    </div>
                                    <div>
                                        <div class="item-harga">Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                        </div>
                                        <div class="item-subtotal" id="subtotal-{{ $i }}">
                                            Rp {{ number_format(($item->harga ?? 0) * $item->jumlah, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn-remove" onclick="hapusItem({{ $i }})"
                                        title="Hapus">
                                        <svg width="14" height="14" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="empty-items" id="empty-msg">Belum ada obat. Tambahkan dari daftar di bawah.
                                </div>
                            @endforelse
                        </div>

                        <div class="divider"></div>

                        {{-- Tambah obat baru --}}
                        <div class="add-item-area">
                            <p
                                style="font-size:11px;color:var(--text-muted);font-family:'IBM Plex Mono',monospace;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">
                                Tambah Obat</p>
                            <div class="add-item-grid">
                                <select id="pilih-varian" class="form-input">
                                    <option value="">-- Pilih obat --</option>
                                    @foreach ($varian as $v)
                                        <option value="{{ $v->id_varian }}" data-nama="{{ $v->nama_merek }}"
                                            data-obat="{{ $v->obat->nama_obat ?? '' }}"
                                            data-dosis="{{ $v->dosis_mg ?? '' }}" data-harga="{{ $v->harga ?? 0 }}"
                                            data-stok="{{ $v->stokObat()->sum('jumlah') ?? 0 }}">
                                            {{ $v->nama_merek }}
                                            @if ($v->dosis_mg)
                                                ({{ $v->dosis_mg }}mg)
                                            @endif
                                            — Stok: {{ $v->stokObat()->sum('jumlah') ?? 0 }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" id="pilih-jumlah" class="form-input" placeholder="Jml"
                                    min="1" value="1">
                            </div>
                            <button type="button" class="btn-add" onclick="tambahItem()">
                                <svg width="13" height="13" fill="none" stroke="currentColor"
                                    stroke-width="2.5" viewBox="0 0 24 24">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Tambah ke Resep
                            </button>
                        </div>

                        <div class="divider"></div>

                        {{-- Total --}}
                        <div class="total-bar">
                            <div>
                                <div class="total-label">Total Harga</div>
                                <div style="font-size:11px;color:var(--text-muted);margin-top:2px;" id="total-item-count">
                                    {{ $resep->items->count() }} item · {{ $resep->items->sum('jumlah') }} unit
                                </div>
                            </div>
                            <div class="total-value" id="total-display">
                                Rp {{ number_format($resep->total_harga ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <input type="hidden" name="total_harga" id="total-hidden"
                            value="{{ $resep->total_harga ?? 0 }}">

                    </div>
                </div>
            </div>

            {{-- KANAN --}}
            <div>
                {{-- Info Resep --}}
                <div class="side-info">
                    <div class="side-header">
                        <div class="side-title">Info Resep</div>
                    </div>
                    <div class="side-body">
                        <div class="side-row">
                            <span class="side-label">No. Resep</span>
                            <span
                                class="side-val mono">{{ $resep->no_resep ?? 'RES-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="side-row">
                            <span class="side-label">Status</span>
                            <span class="status-pill {{ $resep->status ?? 'menunggu' }}" style="margin-top:4px;">
                                {{ ucfirst($resep->status ?? 'menunggu') }}
                            </span>
                        </div>
                        <div class="side-row">
                            <span class="side-label">Dibuat</span>
                            <span class="side-val" style="font-size:12px;">
                                {{ \Carbon\Carbon::parse($resep->created_at)->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="side-info">
                    <div class="side-header">
                        <div class="side-title">Simpan</div>
                    </div>
                    <div class="side-body">
                        <button type="submit" form="form-edit" class="btn btn-primary"
                            style="width:100%;justify-content:center;margin-bottom:10px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('kasir.resep.show', $resep->id) }}" class="btn btn-secondary"
                            style="width:100%;justify-content:center;margin-bottom:10px;">
                            Batal
                        </a>
                        <div style="height:1px;background:var(--border);margin:8px 0;"></div>
                        {{-- Tombol hapus pakai form terpisah --}}
                        <button type="submit" form="form-hapus" class="btn btn-danger"
                            style="width:100%;justify-content:center;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                            </svg>
                            Hapus Resep
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

    {{-- Form hapus TERPISAH di luar form edit --}}
    <form id="form-hapus" method="POST" action="{{ route('kasir.resep.destroy', $resep->id) }}"
        onsubmit="return confirm('Yakin hapus resep ini? Aksi ini tidak bisa dibatalkan.')">
        @csrf
        @method('DELETE')
    </form>

@endsection

@push('scripts')
    <script>
        let itemCount = {{ $resep->items->count() }};

        // Hitung total semua item
        function hitungTotal() {
            let total = 0;
            let unitTotal = 0;
            let itemTotal = 0;

            document.querySelectorAll('#items-list .item-row').forEach((row, idx) => {
                const qtyInput = row.querySelector('.item-qty');
                const harga = parseFloat(qtyInput.dataset.harga) || 0;
                const jumlah = parseInt(qtyInput.value) || 0;
                const subtotal = harga * jumlah;

                total += subtotal;
                unitTotal += jumlah;
                itemTotal++;

                // Update subtotal display per baris
                const subtotalEl = row.querySelector('.item-subtotal');
                if (subtotalEl) {
                    subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                }
            });

            document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total-hidden').value = total;
            document.getElementById('total-item-count').textContent = itemTotal + ' item · ' + unitTotal + ' unit';
        }

        // Hapus item dari list
        function hapusItem(idx) {
            const row = document.getElementById('item-row-' + idx);
            if (row) {
                row.remove();
                renumberItems();
                hitungTotal();

                if (document.querySelectorAll('#items-list .item-row').length === 0) {
                    const list = document.getElementById('items-list');
                    list.innerHTML =
                        '<div class="empty-items" id="empty-msg">Belum ada obat. Tambahkan dari daftar di bawah.</div>';
                }
            }
        }

        // Renumber name attributes setelah hapus
        function renumberItems() {
            document.querySelectorAll('#items-list .item-row').forEach((row, idx) => {
                row.id = 'item-row-' + idx;
                row.querySelector('input[name*="id_varian"]').name = 'items[' + idx + '][id_varian]';
                row.querySelector('.item-qty').name = 'items[' + idx + '][jumlah]';
                row.querySelector('.btn-remove').setAttribute('onclick', 'hapusItem(' + idx + ')');
                const subtotalEl = row.querySelector('.item-subtotal');
                if (subtotalEl) subtotalEl.id = 'subtotal-' + idx;
            });
            itemCount = document.querySelectorAll('#items-list .item-row').length;
        }

        // Tambah item baru
        function tambahItem() {
            const select = document.getElementById('pilih-varian');
            const jumlahInput = document.getElementById('pilih-jumlah');

            const idVarian = select.value;
            const jumlah = parseInt(jumlahInput.value) || 1;

            if (!idVarian) {
                alert('Pilih obat terlebih dahulu.');
                return;
            }

            const opt = select.options[select.selectedIndex];
            const nama = opt.dataset.nama;
            const namaObat = opt.dataset.obat;
            const dosis = opt.dataset.dosis;
            const harga = parseFloat(opt.dataset.harga) || 0;
            const stok = parseInt(opt.dataset.stok) || 0;

            if (jumlah > stok) {
                alert('Stok tidak cukup. Tersedia: ' + stok);
                return;
            }

            // Cek apakah sudah ada di list
            const existing = document.querySelector('input[name*="id_varian"][value="' + idVarian + '"]');
            if (existing) {
                const row = existing.closest('.item-row');
                const qtyEl = row.querySelector('.item-qty');
                qtyEl.value = parseInt(qtyEl.value) + jumlah;
                hitungTotal();
                select.value = '';
                jumlahInput.value = 1;
                return;
            }

            // Hapus empty msg kalau ada
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();

            const subtotal = harga * jumlah;
            const idx = itemCount;

            const html = `
        <div class="item-row" id="item-row-${idx}">
            <input type="hidden" name="items[${idx}][id_varian]" value="${idVarian}">
            <div>
                <div class="item-name">${nama}</div>
                <div class="item-sub">${namaObat}${dosis ? ' · ' + dosis + 'mg' : ''}</div>
            </div>
            <div>
                <input type="number" name="items[${idx}][jumlah]"
                       class="item-qty" value="${jumlah}"
                       min="1" data-harga="${harga}"
                       onchange="hitungTotal()">
            </div>
            <div>
                <div class="item-harga">Rp ${harga.toLocaleString('id-ID')}</div>
                <div class="item-subtotal" id="subtotal-${idx}">Rp ${subtotal.toLocaleString('id-ID')}</div>
            </div>
            <button type="button" class="btn-remove" onclick="hapusItem(${idx})" title="Hapus">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    `;

            document.getElementById('items-list').insertAdjacentHTML('beforeend', html);
            itemCount++;
            hitungTotal();

            select.value = '';
            jumlahInput.value = 1;
        }

        // Init hitung total saat load
        hitungTotal();
    </script>
@endpush
