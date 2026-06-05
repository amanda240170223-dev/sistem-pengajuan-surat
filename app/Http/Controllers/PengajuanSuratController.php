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
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'jenis_surat' => 'required|string',
            'keterangan' => 'required|string',
            'slip_ukt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'krs_terbaru' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Menyimpan file fisik ke folder storage/app/public/dokumen
        $slipPath = $request->file('slip_ukt')->store('dokumen', 'public');
        $krsPath = $request->file('krs_terbaru')->store('dokumen', 'public');

        // Memasukkan data ke tabel 'pengajuan' (menyesuaikan skema tabel Anda)
        DB::table('pengajuan')->insert([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'slip_ukt' => $slipPath,       // Menyimpan path slip ukt
            'krs_terbaru' => $krsPath,     // Menyimpan path krs terbaru
            'status' => 'Diproses',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
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