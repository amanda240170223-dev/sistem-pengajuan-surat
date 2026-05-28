@extends('layout.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">
        Data Jenis Surat
    </h3>

    <div class="card">

        <div class="card-body">

            <form action="/jenis-surat/store" method="POST">

                @csrf

                <div class="mb-3">

                    <label>
                        Nama Jenis Surat
                    </label>

                    <input type="text"
                    name="nama_surat"
                    class="form-control"
                    required>

                </div>

                <button type="submit"
                class="btn btn-primary">

                    Tambah Jenis Surat

                </button>

            </form>

            <hr>

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>Nama Surat</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($jenisSurat as $js)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $js->nama_surat }}</td>

                        <td>

                            <a href="/jenis-surat/delete/{{ $js->id }}"
                            class="btn btn-danger btn-sm">

                                Hapus

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