<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Menampilkan Halaman Dashboard Admin beserta Statistik dan Data Pengajuan
    public function dashboard()
    {
        // Memastikan admin sudah login melalui session bawaan Anda
        if (!session('admin_login')) {
            return redirect('/admin/login');
        }

        // Mengambil semua data dari tabel pengajuan surat
        $pengajuan = DB::table('pengajuan')->get();

        // Mengambil data statistik counts sesuai dengan database Anda
        $totalPengajuan = DB::table('pengajuan')->count();
        $totalMahasiswa = DB::table('mahasiswa')->count();
        $totalJenisSurat = DB::table('jenis_surat')->count();

        // Mengirimkan semua data ke view 'admin.dashboard'
        return view('admin.dashboard', compact(
            'pengajuan',
            'totalPengajuan',
            'totalMahasiswa',
            'totalJenisSurat'
        ));
    }

    // 2. Memproses Perubahan Status (Diproses / Disetujui / Ditolak)
    public function updateStatus($id, $status)
    {
        // Update status pengajuan berdasarkan id surat yang dipilih
        DB::table('pengajuan')
            ->where('id', $id)
            ->update([
                'status' => ucfirst($status) // Menjadikan huruf kapital awal (contoh: Disetujui)
            ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui menjadi ' . $status . '!');
    }

    // 3. Memproses Upload Berkas Dokumen Balasan dari Admin untuk Mahasiswa
    public function uploadBerkas(Request $request, $id)
    {
        // Validasi file agar wajib diisi saat tombol upload ditekan
        $request->validate([
            'berkas' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('berkas')) {
            // Membuat nama file unik berdasarkan waktu agar tidak bentrok
            $fileName = time() . '_' . $request->file('berkas')->getClientOriginalName();
            
            // Memindahkan file berkas ke folder public/uploads (sama seperti alur upload pengajuan Anda)
            $request->file('berkas')->move(public_path('uploads'), $fileName);

            // Update nama file berkas ke dalam database tabel pengajuan
            DB::table('pengajuan')
                ->where('id', $id)
                ->update([
                    'berkas' => $fileName
                ]);

            return back()->with('success', 'Berkas dokumen balasan berhasil diunggah!');
        }

        return back()->with('error', 'Gagal mengunggah berkas.');
    }
}