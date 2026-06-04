@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Status Pengajuan Surat Anda</h2>
        <a href="/dashboard" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Jenis Surat</th>
                            <th>Keterangan</th>
                            <th width="15%" class="text-center">Status Pengajuan</th>
                            <th width="20%" class="text-center">Unduh Berkas Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->jenis_surat }}</td>
                            <td>{{ $p->keterangan }}</td>
                            
                            <td class="text-center">
                                @if(isset($p->status) && strtolower($p->status) == 'disetujui')
                                    <span class="badge bg-success text-uppercase">Disetujui</span>
                                @elseif(isset($p->status) && strtolower($p->status) == 'ditolak')
                                    <span class="badge bg-danger text-uppercase">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase">{{ $p->status ?? 'Diproses' }}</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if(isset($p->berkas) && $p->berkas)
                                    <a href="{{ asset('uploads/' . $p->berkas) }}" class="btn btn-primary btn-sm" download>
                                        ⬇️ Download Berkas
                                    </a>
                                @else
                                    <span class="text-muted small font-italic">Belum ada berkas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Anda belum memiliki riwayat pengajuan surat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection