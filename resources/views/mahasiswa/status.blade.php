@extends('layout.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">
        Status Pengajuan Surat
    </h3>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Jenis Surat</th>
                        <th>Keterangan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @if(count($pengajuan) > 0)

                        @foreach($pengajuan as $p)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $p->nama }}</td>

                            <td>{{ $p->nim }}</td>

                            <td>{{ $p->jenis_surat }}</td>

                            <td>{{ $p->keterangan }}</td>

                            <td>
                                {{ $p->created_at }}
                            </td>

                            <td>

                                @if($p->status == 'Diproses')

                                    <span class="badge bg-warning text-dark">
                                        Diproses
                                    </span>

                                @elseif($p->status == 'Selesai')

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Ditolak
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="7" class="text-center">

                                Belum ada pengajuan surat

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
