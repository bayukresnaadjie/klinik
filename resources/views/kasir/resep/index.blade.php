@extends('layouts.kasir')

@section('title', 'Daftar Resep')
@section('page-title', 'Daftar Resep')

@section('content')

    <div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="font-size:16px; font-weight:600; color:var(--text-primary);">Daftar Resep Hari Ini</h2>
        <a href="{{ route('kasir.resep.create') }}"
            style="background:var(--accent-cyan); color:#0a1a1a; padding:8px 18px; border-radius:7px; text-decoration:none; font-size:13px; font-weight:700;">
            + Buat Resep
        </a>
    </div>

    @if (session('success'))
        <div
            style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.3); color:var(--accent-green); padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div
        style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:900px;">
            <thead>
                <tr style="background:var(--bg-card-alt);">
                    @foreach (['#', 'Pasien', 'Jenis Pembayaran', 'Dokter', 'Item Obat', 'Status', 'Total', 'Waktu', 'Aksi'] as $col)
                        <th
                            style="padding:12px 16px; text-align:left; font-size:10px; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:.1em; border-bottom:1px solid var(--border); font-family:'IBM Plex Mono',monospace; white-space:nowrap;">
                            {{ $col }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($data as $resep)
                    @php
                        $status = $resep->status ?? 'menunggu';
                        $jenisBayar = $resep->jenis_pembayaran ?? 'umum';
                        $umurVal = $resep->umur ?? null;
                        $umurSatuan = $resep->umur_satuan ?? 'tahun';
                        $totalItem = $resep->items->count();
                        $totalUnit = $resep->items->sum('jumlah');
                    @endphp
                    <tr style="border-bottom:1px solid var(--border); transition:background .15s; vertical-align:top;"
                        onmouseover="this.style.background='var(--bg-hover)'"
                        onmouseout="this.style.background='transparent'">

                        {{-- # --}}
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; white-space:nowrap;">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Pasien --}}
                        <td style="padding:12px 16px; white-space:nowrap;">
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">
                                {{ $resep->pasien ?? '-' }}
                            </div>
                            @if ($umurVal)
                                <div
                                    style="font-size:11px; color:var(--text-muted); margin-top:2px; font-family:'IBM Plex Mono',monospace;">
                                    {{ $umurVal }} {{ $umurSatuan }}
                                </div>
                            @endif
                        </td>

                        {{-- Jenis Pembayaran --}}
                        <td style="padding:12px 16px; white-space:nowrap;">
                            @if ($jenisBayar === 'bpjs')
                                <span
                                    style="background:rgba(59,130,246,.1); color:var(--accent-blue); border:1px solid rgba(59,130,246,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                    🏥 BPJS
                                </span>
                            @elseif($jenisBayar === 'asuransi')
                                <span
                                    style="background:rgba(139,92,246,.1); color:#a78bfa; border:1px solid rgba(139,92,246,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                    🛡️ Asuransi
                                </span>
                            @else
                                <span
                                    style="background:rgba(0,200,200,.08); color:var(--accent-cyan); border:1px solid rgba(0,200,200,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                    👤 Umum
                                </span>
                            @endif
                        </td>

                        {{-- Dokter --}}
                        <td style="padding:12px 16px; font-size:12px; color:var(--text-secondary); white-space:nowrap;">
                            @if (!empty($resep->dokter))
                                {{ $resep->dokter }}
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>

                        {{-- Item Obat --}}
                        <td style="padding:10px 16px; width:320px;">
                            <div
                                style="font-size:10px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:6px; letter-spacing:.05em;">
                                {{ $totalItem }} item · {{ $totalUnit }} unit
                            </div>
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                @foreach ($resep->items as $item)
                                    @php
                                        $jadwal = [];
                                        if ($item->pagi ?? false) {
                                            $jadwal[] = ['label' => 'Pagi', 'color' => '#f59e0b'];
                                        }
                                        if ($item->siang ?? false) {
                                            $jadwal[] = ['label' => 'Siang', 'color' => '#3b82f6'];
                                        }
                                        if ($item->sore ?? false) {
                                            $jadwal[] = ['label' => 'Sore', 'color' => '#f97316'];
                                        }
                                        if ($item->malam ?? false) {
                                            $jadwal[] = ['label' => 'Malam', 'color' => '#8b5cf6'];
                                        }
                                    @endphp
                                    <div
                                        style="
                background:var(--bg-card-alt);
                border:1px solid var(--border);
                border-radius:7px;
                padding:7px 10px;
            ">
                                        {{-- Baris 1: Nama + qty --}}
                                        <div
                                            style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:4px;">
                                            <div style="display:flex; align-items:baseline; gap:5px; min-width:0;">
                                                <span
                                                    style="font-size:12px; font-weight:600; color:var(--text-primary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                                    {{ $item->varianObat->nama_merek ?? ($item->nama_obat ?? '-') }}
                                                </span>
                                                @if ($item->varianObat->dosis_mg ?? false)
                                                    <span style="font-size:10px; color:var(--text-muted); flex-shrink:0;">
                                                        {{ $item->varianObat->dosis_mg }}mg
                                                    </span>
                                                @endif
                                            </div>
                                            <span
                                                style="
                        font-size:10px; font-weight:700;
                        font-family:'IBM Plex Mono',monospace;
                        background:var(--bg-hover);
                        border:1px solid var(--border-light);
                        border-radius:4px;
                        padding:1px 6px;
                        color:var(--text-secondary);
                        flex-shrink:0;
                    ">×{{ $item->jumlah }}</span>
                                        </div>

                                        {{-- Baris 2: Signa + Jadwal dalam satu baris --}}
                                        <div style="display:flex; align-items:center; flex-wrap:wrap; gap:4px;">
                                            @if ($item->signa ?? false)
                                                <span style="font-size:10px; color:var(--text-muted); margin-right:2px;">
                                                    {{ $item->signa }}
                                                </span>
                                                @if (!empty($jadwal))
                                                    <span style="color:var(--border-light); font-size:10px;">·</span>
                                                @endif
                                            @endif
                                            @foreach ($jadwal as $j)
                                                <span
                                                    style="
                            font-size:10px; font-weight:600;
                            padding:1px 7px; border-radius:20px;
                            background:{{ $j['color'] }}1a;
                            color:{{ $j['color'] }};
                            border:1px solid {{ $j['color'] }}33;
                            line-height:1.6;
                        ">{{ $j['label'] }}</span>
                                            @endforeach
                                            @if ($item->keterangan ?? false)
                                                @if ($item->signa || !empty($jadwal))
                                                    <span style="color:var(--border-light); font-size:10px;">·</span>
                                                @endif
                                                <span style="font-size:10px; color:var(--text-muted); font-style:italic;">
                                                    {{ $item->keterangan }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        {{-- Status --}}
                        <td style="padding:12px 16px; white-space:nowrap;">
                            @if ($status === 'selesai')
                                <span
                                    style="background:rgba(34,197,94,.1); color:var(--accent-green); border:1px solid rgba(34,197,94,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                    ✓ Selesai
                                </span>
                            @elseif($status === 'tunda')
                                <span
                                    style="background:rgba(245,158,11,.1); color:var(--accent-amber); border:1px solid rgba(245,158,11,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                    ⏸ Tunda
                                </span>
                            @else
                                <span
                                    style="background:rgba(59,130,246,.1); color:var(--accent-blue); border:1px solid rgba(59,130,246,.2); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                    ⏳ Menunggu
                                </span>
                            @endif
                        </td>

                        {{-- Total --}}
                        <td
                            style="padding:12px 16px; font-size:13px; font-weight:600; color:var(--accent-cyan); font-family:'IBM Plex Mono',monospace; white-space:nowrap;">
                            Rp {{ number_format($resep->total_harga ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- Waktu --}}
                        <td
                            style="padding:12px 16px; font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($resep->created_at)->format('d M Y H:i') }}
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:12px 16px; vertical-align:top;">
                            <div style="display:flex; flex-direction:row; gap:6px; flex-wrap:wrap; align-items:flex-start;">
                                <a href="{{ route('kasir.resep.show', $resep->id) }}"
                                    style="background:rgba(59,130,246,.1); color:var(--accent-blue); border:1px solid rgba(59,130,246,.2); padding:4px 12px; border-radius:5px; font-size:11px; text-decoration:none; font-weight:600; white-space:nowrap;">
                                    Detail
                                </a>
                                <a href="{{ route('kasir.resep.edit', $resep->id) }}"
                                    style="background:rgba(245,158,11,.1); color:var(--accent-amber); border:1px solid rgba(245,158,11,.2); padding:4px 12px; border-radius:5px; font-size:11px; text-decoration:none; font-weight:600; white-space:nowrap;">
                                    Edit
                                </a>
                                @if ($status !== 'selesai')
                                    <a href="{{ config('app.kasir_url', 'http://127.0.0.1:8001') }}/kasir/dari-resep/{{ $resep->id }}"
                                        style="background:rgba(34,197,94,.1); color:var(--accent-green); border:1px solid rgba(34,197,94,.2); padding:4px 12px; border-radius:5px; font-size:11px; text-decoration:none; font-weight:600; white-space:nowrap;">
                                        💳 Bayar
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding:48px; text-align:center;">
                            <div style="color:var(--text-muted); font-size:13px;">Belum ada resep hari ini.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($data->hasPages())
        <div
            style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">

            {{-- Info kiri --}}
            <span style="font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace;">
                {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} resep
            </span>

            {{-- Tombol pagination kanan --}}
            <div
                style="display:flex; align-items:center; gap:4px; font-size:12px; font-family:'IBM Plex Mono',monospace; margin-left:auto;">

                {{-- Prev --}}
                @if ($data->onFirstPage())
                    <span
                        style="padding:5px 12px; border-radius:6px; background:var(--bg-card); border:1px solid var(--border); color:var(--text-muted); cursor:default; opacity:.4;">←
                        Prev</span>
                @else
                    <a href="{{ $data->previousPageUrl() }}"
                        style="padding:5px 12px; border-radius:6px; background:var(--bg-card); border:1px solid var(--border); color:var(--text-secondary); text-decoration:none; transition:all .15s;"
                        onmouseover="this.style.borderColor='var(--accent-cyan)';this.style.color='var(--accent-cyan)'"
                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">←
                        Prev</a>
                @endif

                {{-- Nomor halaman --}}
                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if ($page == $data->currentPage())
                        <span
                            style="padding:5px 12px; border-radius:6px; background:var(--accent-cyan); color:#0a1a1a; font-weight:700;">{{ $page }}</span>
                    @elseif (abs($page - $data->currentPage()) <= 2 || $page == 1 || $page == $data->lastPage())
                        <a href="{{ $url }}"
                            style="padding:5px 12px; border-radius:6px; background:var(--bg-card); border:1px solid var(--border); color:var(--text-secondary); text-decoration:none; transition:all .15s;"
                            onmouseover="this.style.borderColor='var(--accent-cyan)';this.style.color='var(--accent-cyan)'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">{{ $page }}</a>
                    @elseif (abs($page - $data->currentPage()) == 3)
                        <span style="padding:5px 4px; color:var(--text-muted);">...</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}"
                        style="padding:5px 12px; border-radius:6px; background:var(--bg-card); border:1px solid var(--border); color:var(--text-secondary); text-decoration:none; transition:all .15s;"
                        onmouseover="this.style.borderColor='var(--accent-cyan)';this.style.color='var(--accent-cyan)'"
                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">Next
                        →</a>
                @else
                    <span
                        style="padding:5px 12px; border-radius:6px; background:var(--bg-card); border:1px solid var(--border); color:var(--text-muted); cursor:default; opacity:.4;">Next
                        →</span>
                @endif

            </div>
        </div>
    @endif

@endsection
