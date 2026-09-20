{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak — Klinik Yos Benito</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family:'DM Sans',sans-serif; background:#FAF8F4; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
        .box { text-align:center; max-width:420px; padding:48px 32px; background:#fff; border-radius:16px; border:1px solid rgba(11,31,58,0.08); }
        .icon { width:64px; height:64px; background:#FEF2F2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; }
        h1 { font-family:'Playfair Display',serif; font-size:28px; font-weight:600; color:#0B1F3A; margin-bottom:8px; }
        p { font-size:14px; color:#8A97A8; line-height:1.6; margin-bottom:28px; }
        a { display:inline-block; padding:10px 24px; background:#0B1F3A; color:#E8C97A; border-radius:8px; text-decoration:none; font-size:13px; font-weight:500; }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">
            <svg width="28" height="28" viewBox="0 0 20 20" fill="#EF4444">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1>Akses Ditolak</h1>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini. Halaman ini hanya bisa diakses oleh role tertentu.</p>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}">
            ← Kembali
        </a>
    </div>
</body>
</html>
