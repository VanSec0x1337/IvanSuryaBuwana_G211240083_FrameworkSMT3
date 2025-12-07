<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-card { max-width: 700px; margin: 30px auto; }
    </style>
</head>
<body>
<div class="container form-card">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-3">@if(!empty($is_update)) Edit Buku @else Form Tambah Buku @endif</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Mohon perbaiki kesalahan berikut:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('buku/save') }}" method="post" accept-charset="utf-8">
                @csrf
                <input type="hidden" name="id" value="{{ $query->ID_Buku ?? '' }}" />
                <input type="hidden" name="is_update" value="{{ $is_update }}" />

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="Judul" class="form-control" value="{{ old('Judul') ?? ($query->Judul ?? '') }}" />
                    @error('Judul') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="Pengarang" class="form-control" value="{{ old('Pengarang') ?? ($query->Pengarang ?? '') }}" />
                    @error('Pengarang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="Kategori" class="form-select">
                        @foreach ($optkategori as $key => $value)
                            <?php $sel = (old('Kategori') == $key) || (!old('Kategori') && !empty($query) && $query->Kategori == $key); ?>
                            <option value="{{ $key }}" {{ $sel ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('Kategori') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">{{ !empty($is_update) ? 'Update' : 'Simpan' }}</button>
                    <a class="btn btn-secondary" href="{{ url('buku') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
