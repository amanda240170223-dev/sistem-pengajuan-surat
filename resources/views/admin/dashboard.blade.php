@extends('layout.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-4">

        <h2>
            Dashboard Admin
        </h2>

        <div>

    <a href="/jenis-surat"
    class="btn btn-warning">

        Jenis Surat

    </a>

    <a href="/mahasiswa"
    class="btn btn-primary">

        Mahasiswa

    </a>

    <a href="/logout"
    class="btn btn-danger">

        Logout

    </a>

</div>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card bg-primary text-white">

                <div class="card-body">

                    <h5>Total Pengajuan</h5>

                    <h2>{{ $totalPengajuan }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card bg-success text-white">

                <div class="card-body">

                    <h5>Total Mahasiswa</h5>

                    <h2>{{ $totalMahasiswa }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card bg-warning text-dark">

                <div class="card-body">

                    <h5>Total Jenis Surat</h5>

                    <h2>{{ $totalJenisSurat }}</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pengajuan as $p)

                    <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nim }}</td>
                        <td>{{ $p->jenis_surat }}</td>
                        <td>{{ $p->status }}</td>
                        <td>{{ $p->keterangan }}</td>

                        <td>

                            <a href="/status/setujui/{{ $p->id }}"
                            class="btn btn-success btn-sm">

                                Setujui

                            </a>

                            <a href="/status/tolak/{{ $p->id }}"
                            class="btn btn-danger btn-sm">

                                Tolak

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection