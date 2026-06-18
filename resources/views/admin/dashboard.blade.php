@extends('layout.app')

@section('content')
<style>
.admin-logo {
    position:fixed; top:50%; left:50%;
    transform:translate(-50%, -50%);
    width:1000px; opacity:0.10;
    pointer-events:none; z-index:1;
}
.container { position:relative; }
</style>

<div class="container mt-4">

    <img src="{{ asset('images/logo.png') }}" class="admin-logo" alt="Logo">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <div>
            <a href="/jenis-surat" class="btn text-white" style="background-color:#495057;">Jenis Surat</a>
            <a href="/riwayat" class="btn text-white" style="background-color:#495057;">Riwayat</a>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik --}}
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
    </div>

    {{-- TABEL 1: MONITORING PENGAJUAN SURAT --}}
    <div class="card shadow mb-4">
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

                            <td class="text-center">
                                @if(isset($p->status) && strtolower($p->status) == 'disetujui')
                                    <span class="badge bg-success text-uppercase">{{ $p->status }}</span>
                                @elseif(isset($p->status) && strtolower($p->status) == 'ditolak')
                                    <span class="badge bg-danger text-uppercase">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase">{{ $p->status ?? 'Diproses' }}</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'disetujui']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'ditolak']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                    <form action="{{ route('admin.updateStatus', [($p->id ?? 0), 'diproses']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm text-dark">Proses</button>
                                    </form>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex flex-column gap-3">
                                    {{-- Berkas Mahasiswa --}}
                                    {{-- Berkas Mahasiswa --}}
                                    <div class="d-flex flex-column gap-1 align-items-center pb-2" style="border-bottom:1px dashed #dee2e6;">
                                        <span class="text-muted mb-1" style="font-size:0.75rem; font-weight:600;">📁 Berkas Mahasiswa:</span>

                                        @if(isset($p->slip_ukt) && $p->slip_ukt)
                                            <a href="{{ route('dokumen.lihat', basename($p->slip_ukt)) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary w-100 font-weight-bold" style="font-size:0.75rem;">
                                                👁️ Lihat Slip UKT
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size:0.72rem;">⚠️ Slip UKT Kosong</span>
                                        @endif

                                        @if(isset($p->khs_terbaru) && $p->khs_terbaru)
                                            <a href="{{ route('dokumen.lihat', basename($p->khs_terbaru)) }}" target="_blank"
                                            class="btn btn-sm btn-outline-warning w-100 font-weight-bold mt-1" style="font-size:0.75rem;">
                                                👁️ Lihat KHS Terbaru
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size:0.72rem;">⚠️ KHS Kosong</span>
                                        @endif

                                        @if(isset($p->krs_terbaru) && $p->krs_terbaru)
                                            <a href="{{ route('dokumen.lihat', basename($p->krs_terbaru)) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success w-100 font-weight-bold mt-1" style="font-size:0.75rem;">
                                                👁️ Lihat KRS Terbaru
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size:0.72rem;">⚠️ KRS Kosong</span>
                                        @endif
                                    </div>

                                    {{-- Upload Berkas Balasan --}}
                                    <div class="d-flex flex-column gap-1">
                                        <span class="text-muted" style="font-size:0.75rem; font-weight:600; text-align:center;">📤 Kirim Surat Hasil Jadi:</span>
                                        <form action="{{ route('admin.uploadBerkas', ($p->id ?? 0)) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="file" name="berkas" class="form-control" style="font-size:0.75rem;">
                                                <button class="btn btn-primary" type="submit" style="font-size:0.75rem;">Upload</button>
                                            </div>
                                        </form>
                                        @if(isset($p->berkas) && $p->berkas)
                                            <div class="mt-1 text-center">
                                                <a href="{{ route('download.berkas', $p->id) }}" target="_blank"
                                                   class="text-primary d-inline-block text-truncate" style="max-width:190px; font-size:0.72rem;" title="{{ $p->berkas }}">
                                                    📄 Tersimpan: {{ Str::limit($p->berkas, 25) }}
                                                </a>
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

    {{-- TABEL 2: TEMPLATE DOKUMEN SURAT --}}
    <div class="card shadow mb-4">
        <div class="card-header" style="background-color:#111827;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">📄 Template Dokumen Surat</h5>
                <span style="background-color:#fef3c7; color:#92400e; font-size:0.75rem; font-weight:600; padding:4px 12px; border-radius:9999px;">
                    8 Template Tersedia
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="text-center" style="background-color:#374151; color:#fff;">
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Nama Template Surat</th>
                            <th width="40%">Keterangan</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $templates = [
                            ['no'=>1, 'nama'=>'Surat Keterangan', 'ket'=>'Template surat keterangan resmi mahasiswa dari jurusan', 'icon'=>'📋', 'warna'=>'#3b82f6', 'file'=>'template_surat_keterangan.pdf'],
                            ['no'=>2, 'nama'=>'Surat Pengantar KP', 'ket'=>'Template surat pengantar kerja praktik ke instansi/perusahaan', 'icon'=>'🏢', 'warna'=>'#8b5cf6', 'file'=>'template_pengantar_kp.pdf'],
                            ['no'=>3, 'nama'=>'Surat Pengunduran Diri Mahasiswa', 'ket'=>'Template surat pengunduran diri dari status kemahasiswaan', 'icon'=>'🚪', 'warna'=>'#ef4444', 'file'=>'template_pengunduran_diri.pdf'],
                            ['no'=>4, 'nama'=>'Permohonan Izin Perkuliahan', 'ket'=>'Template surat permohonan izin tidak mengikuti perkuliahan', 'icon'=>'📅', 'warna'=>'#f59e0b', 'file'=>'template_izin_perkuliahan.pdf'],
                            ['no'=>5, 'nama'=>'Permohonan Cuti Mahasiswa', 'ket'=>'Template surat permohonan cuti akademik mahasiswa', 'icon'=>'🗓️', 'warna'=>'#06b6d4', 'file'=>'template_cuti_mahasiswa.pdf'],
                            ['no'=>6, 'nama'=>'Surat Rekomendasi Magang', 'ket'=>'Template surat rekomendasi untuk program magang mahasiswa', 'icon'=>'⭐', 'warna'=>'#10b981', 'file'=>'template_rekomendasi_magang.pdf'],
                            ['no'=>7, 'nama'=>'Surat Aktif Mahasiswa', 'ket'=>'Template surat keterangan masih aktif sebagai mahasiswa', 'icon'=>'✅', 'warna'=>'#16a34a', 'file'=>'template_surat_aktif.pdf'],
                            ['no'=>8, 'nama'=>'Surat Magang', 'ket'=>'Template surat keterangan mengikuti program magang', 'icon'=>'💼', 'warna'=>'#0ea5e9', 'file'=>'template_surat_magang.pdf'],
                        ];
                        @endphp

                        @foreach($templates as $t)
                        <tr style="{{ $loop->even ? 'background-color:#f9fafb;' : '' }}">
                            <td class="text-center text-muted fw-bold">{{ $t['no'] }}</td>
                            <td>
                                <span style="font-size:1.3rem;">{{ $t['icon'] }}</span>
                                <strong style="margin-left:8px;">{{ $t['nama'] }}</strong>
                            </td>
                            <td class="text-muted" style="font-size:0.85rem;">{{ $t['ket'] }}</td>
                            <td class="text-center">
                                @php $filePath = public_path('templates/' . $t['file']); @endphp
                                @if(file_exists($filePath))
                                    <a href="{{ asset('templates/' . $t['file']) }}" target="_blank"
                                       style="display:inline-block; background-color:{{ $t['warna'] }}; color:#fff; padding:6px 14px; border-radius:6px; font-size:0.78rem; font-weight:600; text-decoration:none; margin-right:4px;">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ asset('templates/' . $t['file']) }}" download
                                       style="display:inline-block; background-color:#f3f4f6; color:#374151; border:1px solid #d1d5db; padding:6px 14px; border-radius:6px; font-size:0.78rem; font-weight:600; text-decoration:none;">
                                        ⬇️ Unduh
                                    </a>
                                @else
                                    <span style="font-size:0.78rem; color:#9ca3af; font-style:italic;">⚠️ Belum tersedia</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer" style="background:#fef9c3; border-top:1px solid #fde68a;">
            <small style="color:#92400e;">
                💡 <strong>Info:</strong> Admin dapat membuat surat sesuai dengan pengajuan
            </small>
        </div>
    </div>

</div>
@endsection
