@extends('layout.app')

@section('content')


<h3>Dashboard Mahasiswa</h3>

<style>
        body {
            background-color: #f5f5f5;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('{{ asset("images/logo.png") }}') center center no-repeat;
            background-size: 1000px;
            opacity: 0.80;
            z-index: -1;
        }
</style>

</head>
<body>

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
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Status Surat</h5>
<a href="/status" class="btn btn-light">Lihat Status</a>
</div>
</div>
</div>

</div>

@endsection
