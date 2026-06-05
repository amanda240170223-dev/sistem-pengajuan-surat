@extends('layout.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 my-6" style="margin-top: 2rem; margin-bottom: 2rem; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 2rem;">
    
    {{-- Header Panel Atas & Total Counter --}}
    <div class="flex justify-between items-center mb-6 border-b pb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 1rem;">
        <h2 class="text-2xl font-bold text-gray-800" style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0;">
            Daftar Pengajuan Surat Masuk (Admin)
        </h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full" style="background-color: #dbeafe; color: #1e40af; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px;">
            Total: {{ $pengajuans->count() }} Pengajuan
        </span>
    </div>

    {{-- Tabel Monitoring Berkas Mahasiswa --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm" style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs tracking-wider" style="background-color: #f9fafb; color: #374151; border-bottom: 2px solid #e5e7eb;">
                    <th class="px-6 py-4" style="padding: 14px 16px; font-weight: 600;">Nama / NIM</th>
                    <th class="px-6 py-4" style="padding: 14px 16px; font-weight: 600;">Jenis Surat</th>
                    <th class="px-6 py-4" style="padding: 14px 16px; font-weight: 600;">Keterangan / Alasan</th>
                    <th class="px-6 py-4 text-center" style="padding: 14px 16px; font-weight: 600; text-align: center;">Berkas Slip UKT</th>
                    <th class="px-6 py-4 text-center" style="padding: 14px 16px; font-weight: 600; text-align: center;">Berkas KRS</th>
                    <th class="px-6 py-4" style="padding: 14px 16px; font-weight: 600;">Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white" style="background-color: #ffffff;">
                @forelse($pengajuans as $item)
                    <tr class="hover:bg-gray-50 transition duration-150" style="border-bottom: 1px solid #e5e7eb;">
                        
                        {{-- Kolom 1: Nama & NIM --}}
                        <td class="px-6 py-4 whitespace-nowrap" style="padding: 14px 16px;">
                            <div class="font-bold text-gray-900" style="font-weight: 700; color: #111827;">{{ $item->nama }}</div>
                            <div class="text-gray-500 text-xs" style="color: #6b7280; font-size: 0.75rem; margin-top: 2px;">{{ $item->nim }}</div>
                        </td>
                        
                        {{-- Kolom 2: Jenis Surat --}}
                        <td class="px-6 py-4 text-gray-700 font-medium" style="padding: 14px 16px; color: #374151; font-weight: 500;">
                            {{ $item->jenis_surat }}
                        </td>
                        
                        {{-- Kolom 3: Keterangan --}}
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $item->keterangan }}" style="padding: 14px 16px; color: #4b5563; max-w: 240px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $item->keterangan }}
                        </td>
                        
                        {{-- Kolom 4: Dokumen Slip UKT (Tombol Biru) --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap" style="padding: 14px 16px; text-align: center;">
                            <a href="{{ asset('storage/' . $item->slip_ukt) }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md border border-blue-200 transition"
                               style="display: inline-block; background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; padding: 6px 12px; font-size: 0.75rem; font-weight: 600; border-radius: 6px; text-decoration: none;">
                                👁️ Lihat Slip UKT
                            </a>
                        </td>
                        
                        {{-- Kolom 5: Dokumen KRS (Tombol Hijau Emerald) --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap" style="padding: 14px 16px; text-align: center;">
                            <a href="{{ asset('storage/' . $item->krs_terbaru) }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-md border border-emerald-200 transition"
                               style="display: inline-block; background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0; padding: 6px 12px; font-size: 0.75rem; font-weight: 600; border-radius: 6px; text-decoration: none;">
                                👁️ Lihat KRS Terbaru
                            </a>
                        </td>
                        
                        {{-- Kolom 6: Tanggal Masuk --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs" style="padding: 14px 16px; color: #6b7280; font-size: 0.75rem;">
                            <span style="font-weight: 500;">{{ $item->created_at->format('d M Y') }}</span>
                            <div class="text-gray-400 text-[10px]" style="color: #9ca3af; font-size: 0.65rem; margin-top: 1px;">{{ $item->created_at->format('H:i') }} WIB</div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400" style="padding: 48px; text-align: center; color: #9ca3af;">
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                                <span style="font-size: 2rem;">📂</span>
                                <p style="font-size: 0.875rem; margin: 0; font-weight: 500;">Belum ada dokumen atau pengajuan surat yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection