<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pinjam Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1 class="mb-3">Daftar Pinjam Buku</h1>
    @guest
        @if(session('guest'))
            <div class="alert alert-info">Anda sedang melihat sebagai <strong>guest</strong>. Aksi tambah/edit/hapus dibatasi. <form method="POST" action="{{ route('guest.exit') }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-secondary">Keluar Guest</button></form></div>
        @endif
    @endguest

    <div class="mb-3">
        @auth
            <a href="{{ url('/pinjam/add') }}" class="btn btn-primary">Tambah Pinjam</a>
        @endauth
        <a href="{{ url('/') }}" class="btn btn-secondary ms-2">Kembali</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th style="width:60px">No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Kembali</th>
                <th style="width:140px">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php $no = $rows->firstItem() ?? 1; @endphp
            @forelse($rows as $r)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ ($r->anggota_nim ? $r->anggota_nim . ' - ' : '') . ($r->anggota_nama ?? 'Anggota '.$r->ID_Anggota) }}</td>
                    <td>{{ $r->buku_judul ?? 'Buku '.$r->ID_Buku }}</td>
                    <td>{{ $r->tgl_pinjam }}</td>
                    <td>{{ $r->tgl_kembali ? $r->tgl_kembali : 'Belum Dikembalikan' }}</td>
                    <td>
                        @auth
                            <a href="{{ url('pinjam/delete/'.$r->ID_Pinjam) }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                            <a href="{{ url('pinjam/edit/'.$r->ID_Pinjam) }}" class="btn btn-sm btn-secondary">Edit</a>
                        @endauth
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data peminjaman.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            @if(method_exists($rows, 'firstItem'))
                <small>Showing {{ $rows->firstItem() }} to {{ $rows->lastItem() }} of {{ $rows->total() }} results</small>
            @endif
        </div>
        <div>
            {{ $rows->links() }}
        </div>
    </div>
</div>
</body>
</html>
