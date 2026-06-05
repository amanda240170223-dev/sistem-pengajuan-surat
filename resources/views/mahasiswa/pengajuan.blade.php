@extends('layout.app')

@section('content')
<div style="background-color: #f9fafb; min-height: 100vh; padding: 2rem 1rem; display: flex; justify-content: center; align-items: flex-start;">
    
    <div style="background: #ffffff; width: 100%; max-w: 640px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 2rem;">
        
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem;">
            Form Pengajuan Surat Mahasiswa
        </h2>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div style="margin-bottom: 1rem; padding: 1rem; font-size: 0.875rem; color: #155724; background-color: #d4edda; border-color: #c3e6cb; border-radius: 6px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Input --}}
        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
            @csrf
            
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.875rem; font-weight: 600; color: #374151;">Nama Lengkap</label>
                <input type="text" name="nama" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 0.5rem 0.75rem; background-color: #f9fafb; font-size: 0.875rem; box-sizing: border-box;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.875rem; font-weight: 600; color: #374151;">NIM</label>
                <input type="text" name="nim" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 0.5rem 0.75rem; background-color: #f9fafb; font-size: 0.875rem; box-sizing: border-box;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.875rem; font-weight: 600; color: #374151;">Jenis Surat</label>
                <select name="jenis_surat" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 0.5rem 0.75rem; background-color: #f9fafb; font-size: 0.875rem; box-sizing: border-box; height: 38px;">
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach($jenisSurat as $js)
                        <option value="{{ $js->nama_surat }}">
                            {{ $js->nama_surat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.875rem; font-weight: 600; color: #374151;">Keterangan / Alasan</label>
                <textarea name="keterangan" rows="3" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 0.5rem 0.75rem; background-color: #f9fafb; font-size: 0.875rem; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <div style="border: 1px dashed #cbd5e1; padding: 1rem; border-radius: 6px; background-color: #f8fafc;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                    📄 Upload Slip Pembayaran UKT (PDF/JPG/PNG)
                </label>
                <input type="file" name="slip_ukt" required style="font-size: 0.875rem; color: #64748b;">
            </div>

            <div style="border: 1px dashed #cbd5e1; padding: 1rem; border-radius: 6px; background-color: #f8fafc; margin-bottom: 0.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                    📄 Upload KRS Terbaru (PDF/JPG/PNG)
                </label>
                <input type="file" name="krs_terbaru" required style="font-size: 0.875rem; color: #64748b;">
            </div>

            <button type="submit" style="width: 100%; background-color: #2563eb; color: #ffffff; font-weight: 600; padding: 0.75rem; border: none; border-radius: 6px; font-size: 0.875rem; cursor: pointer; transition: background-color 0.2s; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>
@endsection