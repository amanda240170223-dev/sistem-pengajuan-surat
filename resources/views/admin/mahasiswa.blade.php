@extends('layout.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">
        Data Mahasiswa
    </h3>

    <div class="card">

        <div class="card-body">

            <form action="/mahasiswa/store" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Nama Mahasiswa</label>

                    <input type="text"
                    name="nama"
                    class="form-control"
                    required>

                </div>

                <div class="mb-3">

                    <label>NIM</label>

                    <input type="text"
                    name="nim"
                    class="form-control"
                    required>

                </div>

                <button type="submit"
                class="btn btn-primary">

                    Tambah Mahasiswa

                </button>

            </form>

            <hr>

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($mahasiswa as $mhs)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $mhs->nama }}</td>

                        <td>{{ $mhs->nim }}</td>

                        <td>

                            <a href="/mahasiswa/edit/{{ $mhs->id }}"
                            class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <a href="/mahasiswa/delete/{{ $mhs->id }}"
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