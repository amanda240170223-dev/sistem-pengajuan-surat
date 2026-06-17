@extends('layout.app')

@section('content')
<div style="max-width:1200px; margin:2rem auto; padding:0 1rem;">

    {{-- ============================================================ --}}
    {{-- TABEL 1: DAFTAR PENGAJUAN SURAT MASUK --}}
    {{-- ============================================================ --}}
    <div style="background:#fff; border-radius:8px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1); padding:2rem; margin-bottom:2rem;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:2px solid #e5e7eb; padding-bottom:1rem;">
            <h2 style="font-size:1.5rem; font-weight:700; color:#1f2937; margin:0;">
                📋 Daftar Pengajuan Surat Masuk (Admin)
            </h2>
            <span style="background-color:#dbeafe; color:#1e40af; font-size:0.75rem; font-weight:600; padding:0.25rem 0.75rem; border-radius:9999px;">
                Total: {{ $pengajuans->count() }} Pengajuan
            </span>
        </div>

        <div style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:8px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                <thead>
                    <tr style="background-color:#111827; color:#fff;">
                        <th style="padding:14px 16px; font-weight:600; text-align:center;">No</th>
                        <th style="padding:14px 16px; font-weight:600;">Nama / NIM</th>
                        <th style="padding:14px 16px; font-weight:600;">Jenis Surat</th>
                        <th style="padding:14px 16px; font-weight:600;">Keterangan</th>
                        <th style="padding:14px 16px; font-weight:600; text-align:center;">Status Saat Ini</th>
                        <th style="padding:14px 16px; font-weight:600; text-align:center;">Aksi Ubah Status</th>
                        <th style="padding:14px 16px; font-weight:600; text-align:center;">Manajemen Berkas & Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $item)
                    <tr style="border-bottom:1px solid #e5e7eb;">

                        <td style="padding:14px 16px; text-align:center;">{{ $loop->iteration }}</td>

                        <td style="padding:14px 16px;">
                            <div style="font-weight:700; color:#111827;">{{ $item->nama }}</div>
                            <div style="color:#6b7280; font-size:0.75rem;">NIM: {{ $item->nim }}</div>
                        </td>

                        <td style="padding:14px 16px; color:#374151;">{{ $item->jenis_surat }}</td>

                        <td style="padding:14px 16px; color:#4b5563;">{{ $item->keterangan }}</td>

                        <td style="padding:14px 16px; text-align:center;">
                            @if(strtolower($item->status) == 'disetujui')
                                <span style="background:#16a34a; color:#fff; padding:4px 12px; border-radius:9999px; font-size:0.75rem; font-weight:600;">DISETUJUI</span>
                            @elseif(strtolower($item->status) == 'ditolak')
                                <span style="background:#dc2626; color:#fff; padding:4px 12px; border-radius:9999px; font-size:0.75rem; font-weight:600;">DITOLAK</span>
                            @else
                                <span style="background:#d97706; color:#fff; padding:4px 12px; border-radius:9999px; font-size:0.75rem; font-weight:600;">DIPROSES</span>
                            @endif
                        </td>

                        <td style="padding:14px 16px; text-align:center;">
                            <form method="POST" action="/admin/status/{{ $item->id }}/disetujui" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:#16a34a; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer;">Setuju</button>
                            </form>
                            <form method="POST" action="/admin/status/{{ $item->id }}/ditolak" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer;">Tolak</button>
                            </form>
                            <form method="POST" action="/admin/status/{{ $item->id }}/diproses" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:#d97706; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer;">Proses</button>
                            </form>
                        </td>

                        <td style="padding:14px 16px; text-align:center;">
                            {{-- Berkas Mahasiswa --}}
                            <div style="margin-bottom:8px;">
                                <div style="font-size:0.7rem; font-weight:600; color:#92400e; margin-bottom:4px;">📁 Berkas Mahasiswa:</div>
                                <a href="{{ route('dokumen.lihat', basename($item->slip_ukt)) }}" target="_blank"
                                   style="display:block; background-color:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; padding:5px 10px; font-size:0.72rem; font-weight:600; border-radius:6px; text-decoration:none; margin-bottom:4px;">
                                    👁️ Lihat Slip UKT
                                </a>
                                <a href="{{ route('dokumen.lihat', basename($item->khs_terbaru)) }}" target="_blank"
                                   style="display:block; background-color:#d1fae5; color:#047857; border:1px solid #a7f3d0; padding:5px 10px; font-size:0.72rem; font-weight:600; border-radius:6px; text-decoration:none;">
                                    👁️ Lihat KHS Terbaru
                                </a>
                            </div>

                            {{-- Upload Berkas Balasan --}}
                            <div style="border-top:1px dashed #e5e7eb; padding-top:8px;">
                                <div style="font-size:0.7rem; font-weight:600; color:#374151; margin-bottom:4px;">📤 Kirim Surat Hasil Jadi:</div>
                                <form action="{{ route('admin.uploadBerkas', $item->id) }}" method="POST" enctype="multipart/form-data" style="display:flex; align-items:center; gap:4px;">
                                    @csrf
                                    <input type="file" name="berkas" style="font-size:0.7rem; width:160px;">
                                    <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:5px 10px; border-radius:6px; font-size:0.72rem; font-weight:600; cursor:pointer; white-space:nowrap;">Upload</button>
                                </form>
                                @if($item->berkas)
                                    <div style="margin-top:4px;">
                                        <a href="{{ route('download.berkas', $item->id) }}" target="_blank"
                                           style="font-size:0.7rem; color:#7c3aed; text-decoration:none;">
                                            📄 Tersimpan: {{ Str::limit($item->berkas, 20) }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:48px; text-align:center; color:#9ca3af;">
                            <div>📂</div>
                            <p style="margin:0; font-size:0.875rem;">Belum ada pengajuan surat masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL 2: TEMPLATE DOKUMEN SURAT --}}
    {{-- ============================================================ --}}
    <div style="background:#fff; border-radius:8px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1); padding:2rem;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:2px solid #e5e7eb; padding-bottom:1rem;">
            <h2 style="font-size:1.5rem; font-weight:700; color:#1f2937; margin:0;">
                📄 Template Dokumen Surat
            </h2>
            <span style="background-color:#fef3c7; color:#92400e; font-size:0.75rem; font-weight:600; padding:0.25rem 0.75rem; border-radius:9999px;">
                8 Template Tersedia
            </span>
        </div>

        <div style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:8px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                <thead>
                    <tr style="background-color:#111827; color:#fff;">
                        <th style="padding:14px 16px; font-weight:600; text-align:center; width:5%;">No</th>
                        <th style="padding:14px 16px; font-weight:600; width:35%;">Nama Template Surat</th>
                        <th style="padding:14px 16px; font-weight:600; width:30%;">Keterangan</th>
                        <th style="padding:14px 16px; font-weight:600; text-align:center; width:30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $templates = [
                        [
                            'no' => 1,
                            'nama' => 'Surat Keterangan',
                            'keterangan' => 'Template surat keterangan resmi mahasiswa dari jurusan',
                            'icon' => '📋',
                            'warna' => '#3b82f6',
                            'file' => 'template_surat_keterangan.pdf',
                        ],
                        [
                            'no' => 2,
                            'nama' => 'Surat Pengantar KP',
                            'keterangan' => 'Template surat pengantar kerja praktik ke instansi/perusahaan',
                            'icon' => '🏢',
                            'warna' => '#8b5cf6',
                            'file' => 'template_pengantar_kp.pdf',
                        ],
                        [
                            'no' => 3,
                            'nama' => 'Surat Pengunduran Diri Mahasiswa',
                            'keterangan' => 'Template surat pengunduran diri dari status kemahasiswaan',
                            'icon' => '🚪',
                            'warna' => '#ef4444',
                            'file' => 'template_pengunduran_diri.pdf',
                        ],
                        [
                            'no' => 4,
                            'nama' => 'Permohonan Izin Perkuliahan',
                            'keterangan' => 'Template surat permohonan izin tidak mengikuti perkuliahan',
                            'icon' => '📅',
                            'warna' => '#f59e0b',
                            'file' => 'template_izin_perkuliahan.pdf',
                        ],
                        [
                            'no' => 5,
                            'nama' => 'Permohonan Cuti Mahasiswa',
                            'keterangan' => 'Template surat permohonan cuti akademik mahasiswa',
                            'icon' => '🗓️',
                            'warna' => '#06b6d4',
                            'file' => 'template_cuti_mahasiswa.pdf',
                        ],
                        [
                            'no' => 6,
                            'nama' => 'Surat Rekomendasi Magang',
                            'keterangan' => 'Template surat rekomendasi untuk program magang mahasiswa',
                            'icon' => '⭐',
                            'warna' => '#10b981',
                            'file' => 'template_rekomendasi_magang.pdf',
                        ],
                        [
                            'no' => 7,
                            'nama' => 'Surat Aktif Mahasiswa',
                            'keterangan' => 'Template surat keterangan masih aktif sebagai mahasiswa',
                            'icon' => '✅',
                            'warna' => '#16a34a',
                            'file' => 'template_surat_aktif.pdf',
                        ],
                        [
                            'no' => 8,
                            'nama' => 'Surat Magang',
                            'keterangan' => 'Template surat keterangan mengikuti program magang',
                            'icon' => '💼',
                            'warna' => '#0ea5e9',
                            'file' => 'template_surat_magang.pdf',
                        ],
                    ];
                    @endphp

                    @foreach($templates as $t)
                    <tr style="border-bottom:1px solid #e5e7eb; {{ $loop->even ? 'background-color:#f9fafb;' : 'background-color:#fff;' }}">
                        <td style="padding:14px 16px; text-align:center; font-weight:600; color:#6b7280;">{{ $t['no'] }}</td>

                        <td style="padding:14px 16px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:1.5rem;">{{ $t['icon'] }}</span>
                                <div>
                                    <div style="font-weight:700; color:#111827; font-size:0.9rem;">{{ $t['nama'] }}</div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:14px 16px; color:#6b7280; font-size:0.82rem;">{{ $t['keterangan'] }}</td>

                        <td style="padding:14px 16px; text-align:center;">
                            <a href="{{ asset('templates/' . $t['file']) }}" target="_blank"
                               style="display:inline-block; background-color:{{ $t['warna'] }}; color:#fff; border:none; padding:7px 16px; border-radius:6px; font-size:0.78rem; font-weight:600; text-decoration:none; margin-right:4px;">
                                👁️ Lihat
                            </a>
                            <a href="{{ asset('templates/' . $t['file']) }}" download
                               style="display:inline-block; background-color:#f3f4f6; color:#374151; border:1px solid #d1d5db; padding:7px 16px; border-radius:6px; font-size:0.78rem; font-weight:600; text-decoration:none;">
                                ⬇️ Unduh
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:1rem; padding:12px 16px; background:#fef9c3; border:1px solid #fde68a; border-radius:8px; font-size:0.8rem; color:#92400e;">
            💡 <strong>Info:</strong> Letakkan file template PDF di folder <code>public/templates/</code> agar tombol Lihat & Unduh berfungsi.
        </div>
    </div>

</div>
@endsection
