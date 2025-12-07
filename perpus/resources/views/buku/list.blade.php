<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1 class="mb-3">Daftar Buku</h1>

    @guest
        @if(session('guest'))
            <div class="alert alert-info">Anda sedang melihat sebagai <strong>guest</strong>. Aksi tambah/edit/hapus dibatasi. <form method="POST" action="{{ route('guest.exit') }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-secondary">Keluar Guest</button></form></div>
        @endif
    @endguest

    <div class="mb-3 d-flex align-items-center">
        @auth
            <a href="{{ url('buku/add') }}" class="btn btn-primary">Tambah Buku</a>
        @endauth
        <a href="{{ url('/') }}" class="btn btn-secondary ms-2">Kembali</a>
    </div>

    <div class="table-responsive shadow-sm bg-white rounded p-3">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php $no = $query->firstItem() ?? 1; @endphp
            @foreach($query as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row['Judul'] }}</td>
                    <td>{{ $row['Pengarang'] }}</td>
                    <td>{{ ($opt_kategori[$row['Kategori']] ?? $row['Kategori']) ?? '-' }}</td>
                    <td>
                        @auth
                            <a href="{{ url('buku/edit/'.$row['ID_Buku']) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ url('buku/delete/'.$row['ID_Buku']) }}" class="btn btn-sm btn-danger ms-2" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        @endauth
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            @if(method_exists($query, 'firstItem'))
                <small>Showing {{ $query->firstItem() }} to {{ $query->lastItem() }} of {{ $query->total() }} results</small>
            @endif
        </div>
        <div>
            {{ $query->links() }}
        </div>
    </div>
</div>
</body>
</html>
