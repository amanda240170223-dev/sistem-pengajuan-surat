<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanSuratController extends Controller
{
    // Menampilkan form pengajuan (Mahasiswa) dengan data opsi Jenis Surat
    public function create()
    {
        $jenisSurat = DB::table('jenis_surat')->get();
        return view('mahasiswa.pengajuan', compact('jenisSurat'));
    }

    // Menyimpan data pengajuan ke dalam tabel database
    public function store(Request $request)
{
    // Validasi field utama
    $request->validate([
        'nama'        => 'required|string|max:255',
        'nim'         => 'required|string|max:20',
        'jenis_surat' => 'required|string',
        'keterangan'  => 'required|string',
    ]);

    // Field upload yang mungkin ada
    $uploadFields = [
        'krs_terbaru', 'khs_terbaru', 'slip_ukt', 'surat_perusahaan',
        'surat_pernyataan', 'dok_pendukung', 'surat_cuti',
        'cv', 'surat_penerimaan',
    ];

    // Validasi file yang dikirim
    foreach ($uploadFields as $field) {
        if ($request->hasFile($field)) {
            $request->validate([
                $field => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }
    }

    // Validasi 3 dokumen wajib utama
    foreach (['krs_terbaru', 'khs_terbaru', 'slip_ukt'] as $wajib) {
        if (!$request->hasFile($wajib)) {
            return redirect()->back()
                ->withErrors([$wajib => ucfirst(str_replace('_', ' ', $wajib)) . ' wajib diupload.'])
                ->withInput();
        }
    }

    // Simpan semua file yang diupload
    $paths = [];
    foreach ($uploadFields as $field) {
        if ($request->hasFile($field)) {
            $paths[$field] = $request->file($field)->store('dokumen', 'public');
        }
    }

    DB::table('pengajuan')->insert([
        'nama'             => $request->nama,
        'nim'              => $request->nim,
        'jenis_surat'      => $request->jenis_surat,
        'keterangan'       => $request->keterangan,
        'slip_ukt'         => $paths['slip_ukt'] ?? null,
        'krs_terbaru'      => $paths['krs_terbaru'] ?? null,
        'khs_terbaru'      => $paths['khs_terbaru'] ?? null,
        'dokumen_tambahan' => json_encode(array_diff_key($paths, array_flip(['slip_ukt', 'krs_terbaru', 'khs_terbaru']))),
        'status'           => 'Diproses',
        'created_at'       => Carbon::now(),
        'updated_at'       => Carbon::now(),
    ]);

    return redirect()->back()->with('success', 'Pengajuan surat berhasil dikirim dan sedang direkap admin.');
}
    // Menampilkan halaman verifikasi berkas (Admin)
    public function adminIndex()
    {
        $pengajuans = DB::table('pengajuan')->latest()->get();
        return view('admin.pengajuan_surat', compact('pengajuans'));
    }
}
