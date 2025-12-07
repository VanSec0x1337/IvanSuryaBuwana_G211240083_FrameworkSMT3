<!DOCTYPE html>
<html>
<head>
	<title>Pinjam Buku</title>
	<meta charset="utf-8" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style> .form-card{max-width:700px;margin:30px auto} </style>
</head>
<body>
<div class="container form-card">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3 class="card-title mb-3">@if(!empty($is_update)) Edit Peminjaman @else Form Pinjam Buku @endif</h3>

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

			<form action="{{ !empty($is_update) ? url('pinjam/update') : url('pinjam/save') }}" method="post">
				@csrf
				@if(!empty($is_update))
					<input type="hidden" name="ID_Pinjam" value="{{ $row->ID_Pinjam }}" />
				@endif

			<div class="mb-3">
				<label class="form-label">Buku</label>
				<select name="ID_Buku" class="form-select">
					@if(!array_key_exists('', (array)$optbuku))
						<option value="">-Pilih buku-</option>
					@endif
					@foreach($optbuku as $k => $v)
						<?php $sel = (old('ID_Buku') == $k) || (!old('ID_Buku') && !empty($row) && $row->ID_Buku == $k); ?>
						<option value="{{ $k }}" {{ $sel ? 'selected' : '' }}>{{ $v }}</option>
					@endforeach
				</select>
				@error('ID_Buku') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
			</div>

			<div class="mb-3">
				<label class="form-label">Anggota</label>
				<select name="ID_Anggota" class="form-select">
					@if(!array_key_exists('', (array)$optanggota))
						<option value="">-Pilih anggota-</option>
					@endif
					@foreach($optanggota as $key => $value)
						<?php $sel = (old('ID_Anggota') == $key) || (!old('ID_Anggota') && !empty($row) && $row->ID_Anggota == $key); ?>
						<option value="{{ $key }}" {{ $sel ? 'selected' : '' }}>{{ $value }}</option>
					@endforeach
				</select>
				@error('ID_Anggota') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
			</div>				<div class="row">
					<div class="col-md-6 mb-3">
						<label class="form-label">Tgl. Pinjam</label>
						<input type="date" name="tgl_pinjam" class="form-control" value="{{ old('tgl_pinjam') ?? ($row->tgl_pinjam ?? '') }}" />
						@error('tgl_pinjam') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
					</div>
					<div class="col-md-6 mb-3">
						<label class="form-label">Tgl. Kembali</label>
						<input type="date" name="tgl_kembali" class="form-control" value="{{ old('tgl_kembali') ?? ($row->tgl_kembali ?? '') }}" />
						@error('tgl_kembali') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
					</div>
				</div>

				<div class="d-flex gap-2">
					<button class="btn btn-primary" type="submit">{{ !empty($is_update) ? 'Update' : 'Simpan' }}</button>
					<a class="btn btn-secondary" href="{{ url('pinjam') }}">Batal</a>
					<a class="btn btn-link ms-auto" href="{{ url('pinjam') }}">Kembali</a>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
