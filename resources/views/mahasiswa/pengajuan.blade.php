@extends('layout.app')

@section('content')

<h3>Form Pengajuan Surat</h3>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="/pengajuan/store" enctype="multipart/form-data">

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

    @foreach($jenisSurat as $js)

        <option>
            {{ $js->nama_surat }}
        </option>

    @endforeach

</select>

</div>

<div class="mb-3">

<label>Keterangan</label>

<textarea name="keterangan"
class="form-control"></textarea>

</div>

    <div class="mb-3">
    <label>Lampiran File</label>
    <input type="file" name="file" class="form-control">
</div>
    
<button class="btn btn-primary">

Kirim Pengajuan

</button>

</form>

@endsection
