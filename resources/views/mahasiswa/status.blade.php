@extends('layout.app')

@section('content')
<div class="container mt-4">

<style>
body {
    background-color: #f5f5f5;
    background-image: url('{{ asset("images/logo.png") }}');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 1000px;
    background-attachment: fixed;
}
</style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Status Pengajuan Surat Anda</h2>
        <a href="/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            {{-- KOLOM NAMA MAHASISWA SEBELUM JENIS SURAT --}}
                            <th>Nama / NIM</th>
                            <th>Jenis Surat</th>
                            <th>Keterangan</th>
                            <th width="15%">Status Pengajuan</th>
                            <th width="25%">Unduh Berkas Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            {{-- MENAMPILKAN DATA NAMA DAN NIM --}}
                            <td>
                                <strong>{{ $p->nama ?? 'Nama Tidak Ditemukan' }}</strong><br>
                                <small class="text-muted">NIM: {{ $p->nim ?? '-' }}</small>
                            </td>

                            <td>{{ $p->jenis_surat }}</td>
                            <td>{{ $p->keterangan }}</td>
                            <td class="text-center">
                                @if(isset($p->status) && strtolower($p->status) == 'disetujui')
                                    <span class="badge bg-success text-uppercase">{{ $p->status }}</span>
                                @elseif(isset($p->status) && strtolower($p->status) == 'ditolak')
                                    <span class="badge bg-danger text-uppercase">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase">{{ $p->status ?? 'Diproses' }}</span>
                                @endif
                            </td>

                            {{-- TEMPAT DOWNLOAD BERKAS BALASAN --}}
                            <td class="text-center">
                               @if(isset($p->berkas) && $p->berkas)
                                <a href="{{ route('download.berkas', $p->id) }}"
                                target="_blank"
                                class="btn btn-primary btn-sm font-weight-bold">
                                    ⬇️ Download Berkas
                                </a>
                            @else
                                <span class="text-muted small">Belum ada berkas</span>
                            @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat pengajuan surat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
