@extends('layout.app')

@section('content')
 <div class="container mt-4">

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

<div class="container mt-4">


    <div class="d-flex justify-content-between mb-3">
        <h2>Riwayat Pengajuan</h2>

        <a href="/admin/dashboard" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Tanggal & Jam</th>
                        <th>Aksi</th>
                        <th>PDF</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengajuan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nim }}</td>
                        <td>{{ $p->jenis_surat }}</td>
                        <td>
                            @if($p->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($p->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @endif
                        </td>

                        <td>{{ $p->keterangan }}</td>

                        <td>{{ $p->created_at }}</td>

                        <td>
                            {{ ucfirst($p->status) }}
                        </td>

                        <td>
    @if($p->berkas)
        <a href="{{ asset('uploads/'.$p->berkas) }}"
           target="_blank"
           class="btn btn-success btn-sm">
           Lihat PDF
        </a>
    @else
        <span class="text-muted">
            Belum Upload
        </span>
    @endif
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            Belum ada data riwayat pengajuan
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
