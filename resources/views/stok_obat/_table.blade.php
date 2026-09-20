{{-- resources/views/stok_obat/_table.blade.php --}}

@if ($data->isEmpty())
    <div class="so-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
        </svg>
        <div class="so-empty-title">Tidak ada data stok</div>
        <div class="so-empty-sub">Coba ubah filter atau tambah stok baru</div>
    </div>
@else
    <div class="so-table-wrap">
        <table class="so-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>No. Batch</th>
                    <th class="thc">Jumlah</th>
                    <th class="thc">Stok Min.</th>
                    <th>Tgl Masuk</th>
                    <th>Kadaluarsa</th>
                    <th class="thc">Status Exp.</th>
                    <th class="thc">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $stok)
                    @php
                        $sisa = $stok->sisa_hari;
                        $isExpired = $sisa < 0;
                        $isKritis = !$isExpired && $sisa <= 30;
                        $isWarning = !$isExpired && !$isKritis && $sisa <= 90;
                        $rowClass = $isExpired ? 'row-expired' : ($isKritis ? 'row-kritis' : '');

                        $varian = $stok->varianObat;
                        $obat = $varian?->obat;
                        $statusStok = $varian?->status_stok; // 'habis' | 'kritis' | 'minimum' | 'aman' | 'no_limit'
                        $totalStok = $varian?->total_stok ?? 0;
                        $stokMin = $varian?->stok_minimum ?? 0;
                        $alertAktif = $varian?->alert_minimum;
                    @endphp
                    <tr class="{{ $rowClass }}">

                        <td class="so-td-no">{{ $data->firstItem() + $i }}</td>

                        <td>
                            <div class="so-drug-name">
                                {{ $obat->nama_obat ?? '-' }}
                                @if ($varian?->dosis_mg)
                                    <span class="so-drug-dose">{{ $varian->dosis_mg }} mg</span>
                                @endif
                            </div>
                            @if ($varian?->nama_merek)
                                <div class="so-drug-sub">{{ $varian->nama_merek }}</div>
                            @endif
                        </td>

                        <td>
                            <span class="so-batch">{{ $stok->no_batch ?: '-' }}</span>
                        </td>

                        <td class="tdc">
                            <span class="so-qty {{ $stok->jumlah > 0 ? 'so-qty-ok' : 'so-qty-empty' }}">
                                {{ $stok->jumlah }}
                            </span>
                        </td>

                        {{-- ── Kolom Stok Minimum ── --}}
                        <td class="tdc">
                            @if ($alertAktif && $stokMin > 0)
                                <div style="line-height:1.3">
                                    <div
                                        style="font-size:13px;font-weight:700;color:
                                        {{ $statusStok === 'habis'
                                            ? '#F87171'
                                            : ($statusStok === 'kritis'
                                                ? '#FCD34D'
                                                : ($statusStok === 'minimum'
                                                    ? '#93C5FD'
                                                    : '#6EE7B7')) }}">
                                        {{ $totalStok }}
                                    </div>
                                    <div style="font-size:10.5px;color:#5A6472;margin-top:1px">
                                        min. {{ $stokMin }}
                                    </div>
                                </div>
                                @if (in_array($statusStok, ['habis', 'kritis', 'minimum']))
                                    <div style="margin-top:4px">
                                        @if ($statusStok === 'habis')
                                            <span class="so-badge so-badge-habis"
                                                style="font-size:10px;padding:2px 7px">Habis</span>
                                        @elseif ($statusStok === 'kritis')
                                            <span class="so-badge so-badge-kritis"
                                                style="font-size:10px;padding:2px 7px">Di bawah min.</span>
                                        @elseif ($statusStok === 'minimum')
                                            <span class="so-badge so-badge-warning"
                                                style="font-size:10px;padding:2px 7px">Tepat min.</span>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <span style="font-size:11px;color:#5A6472">—</span>
                            @endif
                        </td>

                        <td>
                            <span class="so-date">
                                {{ \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d M Y') }}
                            </span>
                        </td>

                        <td>
                            @if ($isExpired)
                                <span class="so-date-danger">
                                    {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y') }}
                                </span>
                            @elseif ($isKritis)
                                <span class="so-date-warning">
                                    {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y') }}
                                </span>
                            @else
                                <span class="so-date">
                                    {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d M Y') }}
                                </span>
                            @endif
                        </td>

                        <td class="tdc">
                            @if ($stok->jumlah == 0)
                                <span class="so-badge so-badge-habis">Habis</span>
                            @elseif ($isExpired)
                                <span class="so-badge so-badge-expired">Expired</span>
                            @elseif ($isKritis)
                                <span class="so-badge so-badge-kritis">Kritis</span>
                            @elseif ($isWarning)
                                <span class="so-badge so-badge-warning">Waspada</span>
                            @else
                                <span class="so-badge so-badge-aman">Aman</span>
                            @endif
                        </td>

                        <td class="tdc">
                            <div class="so-action-group">
                                <a href="{{ route('stok-obat.edit', $stok->id_stok) }}" class="so-btn-edit">Edit</a>
                                <form method="POST" action="{{ route('stok-obat.destroy', $stok->id_stok) }}"
                                    onsubmit="return confirm('Hapus batch ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="so-btn-del">Hapus</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="so-pagination">
        {{ $data->appends(request()->query())->links() }}
    </div>
@endif
