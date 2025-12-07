<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-card { max-width: 700px; margin: 30px auto; }
    </style>
</head>
<body>
<div class="container form-card">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-3">@if(!empty($is_update)) Edit Anggota @else Form Tambah Anggota @endif</h3>

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
			@endif            <form action="{{ !empty($is_update) ? url('anggota/update') : url('anggota/save') }}" method="post">
                @csrf
                @if(!empty($is_update))
                    <input type="hidden" name="ID_Anggota" value="{{ $row->ID_Anggota }}" />
                @endif

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ old('nim') ?? ($row->nim ?? '') }}" />
                    @error('nim') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') ?? ($row->nama ?? '') }}" />
                    @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Program Studi (Prodi)</label>
                    <input type="text" name="progdi" class="form-control" placeholder="e.g., TI, SI, DKV" value="{{ old('progdi') ?? ($row->progdi ?? '') }}" />
                    @error('progdi') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">{{ !empty($is_update) ? 'Update' : 'Simpan' }}</button>
                    <a class="btn btn-secondary" href="{{ url('anggota') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
