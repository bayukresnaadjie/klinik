{{-- resources/views/obat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

.mx {
    --gold:    #E2B96F;
    --gold2:   #C9953A;
    --gold-glow: rgba(226,185,111,0.15);
    --gold-dim:  rgba(226,185,111,0.08);
    --bg:      #0D0F14;
    --bg2:     #13161D;
    --bg3:     #1A1E28;
    --bg4:     #222838;
    --border:  rgba(255,255,255,0.07);
    --border2: rgba(226,185,111,0.2);
    --tx1: #F0EDE6;
    --tx2: #8C95A6;
    --tx3: #4A5568;
    --green:  #4ADE80;
    --red:    #F87171;
    --blue:   #60A5FA;
    --teal:   #2DD4BF;
    --purple: #A78BFA;
    font-family: 'Outfit', sans-serif;
    font-size: 13.5px;
    color: var(--tx1);
}
.mx-header {
    display:flex; align-items:flex-end; justify-content:space-between;
    margin-bottom:28px; gap:16px; flex-wrap:wrap;
}
.mx-eyebrow {
    font-size:10px; font-weight:700; letter-spacing:.12em; text-transform:uppercase;
    color:var(--gold); margin-bottom:5px; display:flex; align-items:center; gap:7px;
}
.mx-eyebrow::before { content:''; display:block; width:18px; height:1.5px; background:var(--gold); border-radius:2px; }
.mx-title { font-size:26px; font-weight:800; color:var(--tx1); letter-spacing:-.5px; line-height:1; }
.mx-sub   { font-size:12.5px; color:var(--tx2); margin-top:5px; }

.mx-btn-add {
    display:inline-flex; align-items:center; gap:8px; padding:10px 20px;
    background:linear-gradient(135deg,var(--gold),var(--gold2));
    color:#1a0f00; font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
    border-radius:10px; border:none; cursor:pointer; text-decoration:none !important;
    transition:all .2s; box-shadow:0 4px 20px rgba(226,185,111,0.25); white-space:nowrap;
}
.mx-btn-add:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(226,185,111,0.4); color:#1a0f00; }

.mx-alert { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:10px; font-size:13px; font-weight:500; margin-bottom:16px; animation:slideDown .3s ease; }
@keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:none} }
.mx-alert-ok  { background:rgba(74,222,128,.1); color:#86efac; border:1px solid rgba(74,222,128,.2); }
.mx-alert-err { background:rgba(248,113,113,.1); color:#fca5a5; border:1px solid rgba(248,113,113,.2); }
.mx-alert-x   { background:none; border:none; font-size:18px; cursor:pointer; color:inherit; opacity:.5; padding:0; margin-left:auto; line-height:1; }
.mx-alert-x:hover { opacity:1; }

.mx-stat-row { display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap; }
.mx-stat-pill {
    display:flex; align-items:center; gap:10px; padding:12px 18px;
    background:var(--bg3); border:1px solid var(--border); border-radius:12px;
    min-width:140px; transition:border-color .2s;
}
.mx-stat-pill:hover { border-color:var(--border2); }
.mx-stat-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.mx-stat-icon.gold   { background:var(--gold-dim); color:var(--gold); }
.mx-stat-icon.blue   { background:rgba(96,165,250,.1); color:var(--blue); }
.mx-stat-icon.teal   { background:rgba(45,212,191,.1); color:var(--teal); }
.mx-stat-num { font-size:20px; font-weight:800; color:var(--tx1); line-height:1; }
.mx-stat-lbl { font-size:11px; color:var(--tx2); margin-top:2px; }

.mx-card { background:var(--bg2); border:1px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
.mx-card-top {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px; border-bottom:1px solid var(--border);
    background:linear-gradient(90deg,var(--gold-dim) 0%,transparent 50%);
    flex-wrap:wrap; gap:10px;
}
.mx-card-top-left { display:flex; align-items:center; gap:10px; }
.mx-card-icon { width:32px; height:32px; border-radius:8px; background:var(--gold-dim); border:1px solid var(--border2); display:flex; align-items:center; justify-content:center; color:var(--gold); }
.mx-card-title { font-size:13.5px; font-weight:700; color:var(--tx1); }
.mx-card-badge { padding:3px 10px; border-radius:20px; background:var(--gold-dim); border:1px solid var(--border2); font-size:11px; font-weight:600; color:var(--gold); font-family:'JetBrains Mono',monospace; }

.mx-search-wrap { position:relative; }
.mx-search {
    padding:7px 12px 7px 34px; background:var(--bg3); border:1px solid var(--border);
    border-radius:8px; font-family:'Outfit',sans-serif; font-size:12.5px; color:var(--tx1);
    outline:none; width:200px; transition:border-color .2s,width .3s;
}
.mx-search::placeholder { color:var(--tx3); }
.mx-search:focus { border-color:var(--border2); width:240px; }
.mx-search-icon { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--tx3); pointer-events:none; }

.mx-tbl { width:100%; border-collapse:collapse; }
.mx-tbl thead tr { background:rgba(0,0,0,.25); }
.mx-tbl thead th {
    padding:10px 18px; text-align:left; font-size:10px; font-weight:700;
    letter-spacing:.1em; text-transform:uppercase; color:var(--tx3);
    border-bottom:1px solid var(--border); white-space:nowrap;
}
.mx-tbl thead th.thc { text-align:center; }
.mx-tbl tbody tr {
    border-bottom:1px solid rgba(255,255,255,.04);
    transition:background .15s;
    animation:rowIn .3s ease both;
}
@keyframes rowIn { from{opacity:0;transform:translateX(-6px)} to{opacity:1;transform:none} }
.mx-tbl tbody tr:nth-child(even)       { background:rgba(255,255,255,.015); }
.mx-tbl tbody tr:hover,
.mx-tbl tbody tr:nth-child(even):hover { background:rgba(255,255,255,.04); }
.mx-tbl tbody tr:last-child { border-bottom:none; }
.mx-tbl td { padding:13px 18px; vertical-align:middle; }
.mx-tbl td.tdc { text-align:center; }

.mx-no { font-family:'JetBrains Mono',monospace; font-size:11px; color:var(--tx3); font-weight:500; }
.mx-name { font-size:14px; font-weight:600; color:var(--tx1); }
.mx-name-sub { font-size:11.5px; color:var(--tx3); margin-top:2px; }

/* Jenis badge — warna per jenis */
.mx-badge {
    display:inline-block; padding:3px 11px; border-radius:20px;
    font-size:11.5px; font-weight:600; letter-spacing:.02em; white-space:nowrap;
}
.mx-badge-blue   { background:rgba(96,165,250,.12); color:#93c5fd; border:1px solid rgba(96,165,250,.2); }
.mx-badge-teal   { background:rgba(45,212,191,.12); color:#5eead4; border:1px solid rgba(45,212,191,.2); }
.mx-badge-purple { background:rgba(167,139,250,.12); color:#c4b5fd; border:1px solid rgba(167,139,250,.2); }
.mx-badge-gold   { background:var(--gold-dim); color:var(--gold); border:1px solid var(--border2); }
.mx-badge-green  { background:rgba(74,222,128,.12); color:#86efac; border:1px solid rgba(74,222,128,.2); }

.mx-count-chip {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:28px; height:22px; padding:0 9px; border-radius:20px;
    font-size:11.5px; font-weight:700; font-family:'JetBrains Mono',monospace;
    background:rgba(96,165,250,.12); color:var(--blue); border:1px solid rgba(96,165,250,.2);
    transition:all .15s;
}
.mx-tbl tbody tr:hover .mx-count-chip { background:rgba(96,165,250,.2); border-color:rgba(96,165,250,.4); }

.mx-actions { display:flex; gap:6px; justify-content:center; }
.mx-btn-edit,.mx-btn-del {
    padding:5px 14px; border-radius:7px; font-size:12px; font-weight:600;
    font-family:'Outfit',sans-serif; cursor:pointer; text-decoration:none !important;
    display:inline-flex; align-items:center; gap:5px; border:1px solid;
    transition:all .15s; line-height:1; background:none;
}
.mx-btn-edit { color:var(--gold); border-color:rgba(226,185,111,.2); }
.mx-btn-edit:hover { background:var(--gold-dim); border-color:var(--border2); color:var(--gold); transform:translateY(-1px); }
.mx-btn-del  { color:var(--red); border-color:rgba(248,113,113,.2); }
.mx-btn-del:hover  { background:rgba(248,113,113,.1); border-color:rgba(248,113,113,.4); color:var(--red); transform:translateY(-1px); }

.mx-empty { padding:60px 20px; text-align:center; }
.mx-empty-ring { width:64px; height:64px; border-radius:50%; border:2px dashed rgba(255,255,255,.1); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--tx3); }
.mx-empty-title { font-size:15px; font-weight:700; color:var(--tx2); margin-bottom:5px; }
.mx-empty-sub   { font-size:12.5px; color:var(--tx3); }

.mx-pager { padding:14px 22px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.mx-pager-info { font-size:12px; color:var(--tx3); }
.mx-pager .pagination { display:flex; gap:4px; list-style:none; padding:0; margin:0; }
.mx-pager .page-item .page-link { padding:5px 11px; border-radius:7px; border:1px solid var(--border); background:none; font-size:12px; font-family:'Outfit',sans-serif; color:var(--tx2); text-decoration:none; display:inline-block; line-height:1.4; transition:all .15s; }
.mx-pager .page-item.active .page-link { background:var(--gold); border-color:var(--gold); color:#1a0f00; font-weight:700; }
.mx-pager .page-item:not(.active) .page-link:hover { border-color:var(--border2); color:var(--gold); background:var(--gold-dim); }
.mx-pager .page-item.disabled .page-link { opacity:.3; cursor:default; }
</style>

<div class="mx">

    @if(session('success'))
    <div class="mx-alert mx-alert-ok">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
        <button class="mx-alert-x" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="mx-alert mx-alert-err">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
        <button class="mx-alert-x" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    <div class="mx-header">
        <div>
            <div class="mx-eyebrow">Master Data</div>
            <div class="mx-title">Data Obat</div>
            <div class="mx-sub">Daftar zat aktif / nama generik obat</div>
        </div>
        <a href="{{ route('master.obat.create') }}" class="mx-btn-add">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Obat
        </a>
    </div>

    <div class="mx-stat-row">
        <div class="mx-stat-pill">
            <div class="mx-stat-icon gold">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
            </div>
            <div>
                <div class="mx-stat-num">{{ $data->total() }}</div>
                <div class="mx-stat-lbl">Total Obat</div>
            </div>
        </div>
    </div>

    <div class="mx-card">
        <div class="mx-card-top">
            <div class="mx-card-top-left">
                <div class="mx-card-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18"/></svg>
                </div>
                <div class="mx-card-title">Daftar Data Obat (Zat Aktif)</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <span class="mx-card-badge">{{ $data->total() }} obat</span>
                <div class="mx-search-wrap">
                    <svg class="mx-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="mx-search" placeholder="Cari obat..." id="mxSearch" oninput="filterRows(this.value)">
                </div>
            </div>
        </div>

        @if($data->isEmpty())
        <div class="mx-empty">
            <div class="mx-empty-ring">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18"/></svg>
            </div>
            <div class="mx-empty-title">Belum ada data obat</div>
            <div class="mx-empty-sub">Tambahkan zat aktif / nama generik obat terlebih dahulu</div>
        </div>
        @else
        <div style="overflow-x:auto;">
            <table class="mx-tbl" id="mxTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Obat</th>
                        <th width="180">Jenis</th>
                        <th class="thc" width="140">Jumlah Varian</th>
                        <th class="thc" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    @php
                        $badgeClass = 'mx-badge-blue';
                        $jenis = strtolower($item->jenisObat->nama_jenis ?? '');
                        if (str_contains($jenis,'sirup') || str_contains($jenis,'cair')) $badgeClass = 'mx-badge-teal';
                        elseif (str_contains($jenis,'kapsul')) $badgeClass = 'mx-badge-purple';
                        elseif (str_contains($jenis,'injeksi') || str_contains($jenis,'infus')) $badgeClass = 'mx-badge-gold';
                        elseif (str_contains($jenis,'salep') || str_contains($jenis,'krim')) $badgeClass = 'mx-badge-green';
                    @endphp
                    <tr style="animation-delay:{{ $loop->index*0.04 }}s">
                        <td><span class="mx-no">{{ ($data->currentPage()-1)*$data->perPage()+$loop->iteration }}</span></td>
                        <td>
                            <div class="mx-name">{{ $item->nama_obat }}</div>
                        </td>
                        <td>
                            <span class="mx-badge {{ $badgeClass }}">{{ $item->jenisObat->nama_jenis ?? '-' }}</span>
                        </td>
                        <td class="tdc">
                            <span class="mx-count-chip">{{ $item->varian_obat_count }}</span>
                        </td>
                        <td class="tdc">
                            <div class="mx-actions">
                                <a href="{{ route('master.obat.edit', $item->id_obat) }}" class="mx-btn-edit">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('master.obat.destroy', $item->id_obat) }}" method="POST" onsubmit="return confirm('Yakin hapus obat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="mx-btn-del">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if($data->hasPages())
        <div class="mx-pager">
            <span class="mx-pager-info">Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}</span>
            {{ $data->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function filterRows(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#mxTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
@endsection
