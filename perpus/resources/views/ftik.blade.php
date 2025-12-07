<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Perpustakaan FTIK USM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .menu-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }
        .menu-card .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
        }
        .menu-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar with Logo -->
    <nav class="navbar navbar-light bg-white shadow-sm" style="border-bottom: 2px solid #667eea; padding: 15px 0;">
        <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                @php
                    // prefer PNG file provided by user; fallback to packaged SVG if PNG missing
                    $pngPath = public_path('images/LOGO-USMJAYA.png');
                    $svgAsset = asset('images/logo-usm.svg');
                    $imgAsset = file_exists($pngPath) ? asset('images/LOGO-USMJAYA.png') : $svgAsset;
                @endphp
                <img src="{{ $imgAsset }}" alt="Logo USM" width="80" height="80" class="me-4" style="object-fit: contain;">
                <div>
                    <h5 class="mb-1" style="color: #667eea; font-weight: bold; font-size: 1.5rem;">FTIK USM</h5>
                    <p class="text-muted mb-0" style="font-size: 1rem;">Aplikasi Perpustakaan</p>
                </div>
            </a>
            <div>
                <span class="me-3">{{ Auth::user()->username ?? 'Guest' }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <h1 class="mb-2">Aplikasi Perpustakaan FTIK USM</h1>
        <p class="lead">Selamat Datang di Sistem Manajemen Perpustakaan</p>
    </div>

    <div class="container py-5">
        <h2 class="text-center mb-5">Pilihan Menu:</h2>
        <div class="row g-4">
            <!-- Kelola Data Buku -->
            <div class="col-md-6 col-lg-4">
                <div class="card menu-card">
                    <div class="card-body">
                        <div class="menu-icon">📚</div>
                        <h5 class="card-title">Kelola Data Buku</h5>
                        <p class="card-text text-muted">Manajemen koleksi buku perpustakaan</p>
                        <a href="{{ url('/buku') }}" class="btn btn-primary mt-3">Buka</a>
                    </div>
                </div>
            </div>

            <!-- Kelola Data Anggota -->
            <div class="col-md-6 col-lg-4">
                <div class="card menu-card">
                    <div class="card-body">
                        <div class="menu-icon">👥</div>
                        <h5 class="card-title">Kelola Data Anggota</h5>
                        <p class="card-text text-muted">Manajemen anggota perpustakaan</p>
                        <a href="{{ url('/anggota') }}" class="btn btn-info mt-3">Buka</a>
                    </div>
                </div>
            </div>

            <!-- Kelola Transaksi Pinjam -->
            <div class="col-md-6 col-lg-4">
                <div class="card menu-card">
                    <div class="card-body">
                        <div class="menu-icon">📋</div>
                        <h5 class="card-title">Kelola Transaksi Pinjam</h5>
                        <p class="card-text text-muted">Manajemen peminjaman buku</p>
                        <a href="{{ url('/pinjam') }}" class="btn btn-success mt-3">Buka</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p class="text-muted mb-0">&copy; 2025 Aplikasi Perpustakaan FTIK USM. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
