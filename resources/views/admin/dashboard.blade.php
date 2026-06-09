@extends('layout.app')

@section('content')
<style>
.admin-logo{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    width:1000px;
    opacity:0.10;
    pointer-events:none;
    z-index:1;
}

.container{
    position:relative;
}
</style>

<div class="container mt-4">

    {{-- Header Dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <img src="{{ asset('images/logo.png') }}"
     class="admin-logo"
     alt="Logo">

        <div>
            <a href="/jenis-surat" class="btn text-white"
   style="background-color: #495057; border-color: #495057;">
   Jenis Surat
</a>

<a href="/riwayat" class="btn text-white"
   style="background-color: #495057; border-color: #495057;">
   Riwayat
</a>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Ruang Ringkasan Informasi Statistik (Card) - DIJAMIN AMAN DARI ERROR --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Pengajuan</h5>
                    <h2>{{ $totalPengajuan ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
    <div class="card bg-primary text-white shadow-sm">
        <div class="card-body">
            <h5>Total Riwayat Pengajuan</h5>
            <h2>{{ $totalRiwayat ?? 0 }}</h2>
        </div>
    </div>
</div>
        <div class="col-md-4">
    <div class="card bg-primary text-white shadow-sm">
        <div class="card-body">
            <h5>Total Jenis Surat</h5>
            <h2>{{ $totalJenisSurat ?? 0 }}</h2>
        </div>
    </div>
</div>

    {{-- Tabel Utama Monitoring Pengajuan --}}
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama / NIM</th>
                            <th>Jenis Surat</th>
                            <th>Keterangan</th>
                            <th width="12%">Status Saat Ini</th>
                            <th width="20%">Aksi Ubah Status</th>
                            <th width="25%">Manajemen Berkas & Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan ?? [] as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $p->nama ?? '-' }}</strong><br>
                                <small class="text-muted">NIM: {{ $p->nim ?? '-' }}</small>
                            </td>
                            <td>{{ $p->jenis_surat ?? '-' }}</td>
                            <td>{{ $p->keterangan ?? '-' }}</td>

                            {{-- Status Saat Ini --}}
                            <td class="text-center">
                                @if(isset($p->status) && strtolower($p->status) == 'disetujui')
                                    <span class="badge bg-success text-uppercase">{{ $p->status }}</span>
                                @elseif(isset($p->status) && strtolower($p->status) == 'ditolak')
                                    <span class="badge bg-danger text-uppercase">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase">{{ $p->status ?? 'Diproses' }}</span>
                                @endif
                            </td>

                            {{-- Form Aksi Ubah Status --}}
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'disetujui']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm font-weight-bold">Setuju</button>
                                    </form>

                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'ditolak']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm font-weight-bold">Tolak</button>
                                    </form>

                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'diproses']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm font-weight-bold text-dark">Proses</button>
                                    </form>
                                </div>
                            </td>

                            {{-- GABUNGAN: MELIHAT BERKAS MAHASISWA & FORM UPLOAD SURAT JADI --}}
                            <td>
                                <div class="d-flex flex-column gap-3">

                                    {{-- 1. Sub-Bagian: Lihat Berkas dari Mahasiswa --}}
                                    <div class="d-flex flex-column gap-1 align-items-center pb-2" style="border-bottom: 1px dashed #dee2e6;">
                                        <span class="text-muted mb-1" style="font-size: 0.75rem; font-weight: 600;">📁 Berkas Mahasiswa:</span>

                                        @if(isset($p->slip_ukt) && $p->slip_ukt)
                                            <a href="{{ asset('storage/' . $p->slip_ukt) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 text-truncate font-weight-bold" style="max-width: 200px; font-size: 0.75rem;">
                                                👁️ Lihat Slip UKT
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 0.72rem;">⚠️ Slip UKT Kosong</span>
                                        @endif

                                        @if(isset($p->krs_terbaru) && $p->krs_terbaru)
                                            <a href="{{ asset('storage/' . $p->krs_terbaru) }}" target="_blank" class="btn btn-sm btn-outline-success w-100 text-truncate font-weight-bold mt-1" style="max-width: 200px; font-size: 0.75rem;">
                                                👁️ Lihat KRS Terbaru
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 0.72rem;">⚠️ KRS Kosong</span>
                                        @endif
                                    </div>

                                    {{-- 2. Sub-Bagian: Form Upload Surat Hasil Jadi untuk Mahasiswa --}}
                                    <div class="d-flex flex-column gap-1">
                                        <span class="text-muted" style="font-size: 0.75rem; font-weight: 600; text-align: center;">📤 Kirim Surat Hasil Jadi:</span>

                                        <form action="{{ route('admin.uploadBerkas', ($p->id ?? 0)) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-1">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="file" name="berkas" class="form-control" required style="font-size: 0.75rem;">
                                                <button class="btn btn-primary" type="submit" style="font-size: 0.75rem;">Upload</button>
                                            </div>
                                        </form>

                                        @if(isset($p->berkas) && $p->berkas)
                                            <div class="mt-1 text-center">
                                                <small class="text-primary d-inline-block text-truncate" style="max-width: 190px;" title="{{ $p->berkas }}">
                                                    📄 Tersimpan: {{ $p->berkas }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>

                                </div>
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
