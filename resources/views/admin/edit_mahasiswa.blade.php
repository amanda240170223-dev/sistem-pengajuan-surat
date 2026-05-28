@extends('layout.app')

@section('content')

<h3>Edit Mahasiswa</h3>

<form method="POST" action="/mahasiswa/update/{{ $mahasiswa->id }}">

@csrf

<div class="mb-3">

<label>Nama</label>

<input type="text"
name="nama"
class="form-control"
value="{{ $mahasiswa->nama }}">

</div>

<div class="mb-3">

<label>NIM</label>

<input type="text"
name="nim"
class="form-control"
value="{{ $mahasiswa->nim }}">

</div>

<button class="btn btn-primary">

Update

</button>

</form>

@endsection