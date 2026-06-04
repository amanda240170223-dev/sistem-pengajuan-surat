@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-4">
        <h2>Dashboard Admin / TU</h2>
        <div>
            <a href="/jenis-surat" class="btn btn-warning">Jenis Surat</a>
            <a href="/mahasiswa" class="btn btn-primary">Mahasiswa</a>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Pengajuan</h5>
                    <h2>{{ $totalPengajuan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Mahasiswa</h5>
                    <h2>{{ $totalMahasiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body">
                    <h5>Total Jenis Surat</h5>
                    <h2>{{ $totalJenisSurat }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama / NIM</th>
                            <th>Jenis Surat</th>
                            <th>Keterangan</th>
                            <th width="15%">Status Saat Ini</th>
                            <th width="25%">Aksi Ubah Status</th>
                            <th width="25%">Upload Berkas Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $p->nama }}</strong><br>
                                <small class="text-muted">NIM: {{ $p->nim }}</small>
                            </td>
                            <td>{{ $p->jenis_surat }}</td>
                            <td>{{ $p->keterangan }}</td>
                            
                            <td>
                                @if(isset($p->status) && strtolower($p->status) == 'disetujui')
                                    <span class="badge bg-success text-uppercase">{{ $p->status }}</span>
                                @elseif(isset($p->status) && strtolower($p->status) == 'ditolak')
                                    <span class="badge bg-danger text-uppercase">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase">{{ $p->status ?? 'Diproses' }}</span>
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('admin.updateStatus', [$p->id, 'disetujui']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm font-weight-bold">Setuju</button>
                                </form>

                                <form action="{{ route('admin.updateStatus', [$p->id, 'ditolak']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm font-weight-bold">Tolak</button>
                                </form>

                                <form action="{{ route('admin.updateStatus', [$p->id, 'diproses']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm font-weight-bold text-dark">Proses</button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('admin.uploadBerkas', $p->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-1">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="file" name="berkas" class="form-control" required>
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                </form>
                                
                                @if(isset($p->berkas) && $p->berkas)
                                    <div class="mt-1">
                                        <small class="text-primary d-block text-truncate" style="max-width: 200px;">
                                            📄 {{ $p->berkas }}
                                        </small>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada pengajuan surat masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection