@extends('layout.app')

@section('content')

<h3>Dashboard Mahasiswa</h3>

<div class="row mt-4">

<div class="col-md-4">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Ajukan Surat</h5>
<a href="/pengajuan" class="btn btn-light">Buat Pengajuan</a>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Status Surat</h5>
<a href="/status" class="btn btn-light">Lihat Status</a>
</div>
</div>
</div>

</div>

@endsection
