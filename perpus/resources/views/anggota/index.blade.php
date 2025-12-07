<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1 class="mb-3">Daftar Anggota</h1>
    @guest
        @if(session('guest'))
            <div class="alert alert-info">Anda sedang melihat sebagai <strong>guest</strong>. Aksi tambah/edit/hapus dibatasi. <form method="POST" action="{{ route('guest.exit') }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-secondary">Keluar Guest</button></form></div>
        @endif
    @endguest

    <div class="mb-3">
        @auth
            <a href="{{ url('anggota/add') }}" class="btn btn-primary">Tambah Anggota</a>
        @endauth
        <a href="{{ url('/') }}" class="btn btn-secondary ms-2">Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Prodi</th>
            <th>Aksi</th>
        </tr>

        @php $no = $rows->firstItem() ?? 1; @endphp
        @forelse($rows as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->nim ?? '-' }}</td>
                <td>{{ $row->nama ?? '-' }}</td>
                <td>{{ $row->progdi ?? '-' }}</td>
                <td>
                    @auth
                        <a href="{{ url('anggota/edit/'.$row->ID_Anggota) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ url('anggota/delete/'.$row->ID_Anggota) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    @endauth
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data anggota.</td>
            </tr>
        @endforelse
    </table>
        </table>
        </div>
        <div class="mt-3">
            {{ $rows->links() }}
        </div>
</div>
</body>
</html>
