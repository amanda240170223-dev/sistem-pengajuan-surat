@extends('layout.app')

@section('content')

<h2 class="mb-4">
    Dashboard Admin
</h2>

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

                    <td>

                        <a href="#"
                        class="btn btn-success btn-sm">

                            Selesai

                        </a>

                        <a href="#"
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

@endsection
