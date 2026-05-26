@extends('layout.app')

@section('content')

<h3>Form Pengajuan Surat</h3>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="/pengajuan/store">

@csrf

<div class="mb-3">
<label>Nama Mahasiswa</label>
<input type="text" name="nama" class="form-control">
</div>

<div class="mb-3">
<label>NIM</label>
<input type="text" name="nim" class="form-control">
</div>

<div class="mb-3">
<label>Jenis Surat</label>
<select name="jenis_surat" class="form-control">
<option>Surat Aktif Kuliah</option>
<option>Surat Keterangan Mahasiswa</option>
<option>Surat Penelitian</option>
</select>
</div>

<div class="mb-3">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control"></textarea>
</div>

<button class="btn btn-primary">
Kirim Pengajuan
</button>

</form>

@endsection
