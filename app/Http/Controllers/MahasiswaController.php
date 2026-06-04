<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa; // Memanggil model Mahasiswa agar bisa membaca database

class MahasiswaController extends Controller
{
    // Menampilkan halaman utama (index) mahasiswa dengan membawa data status & berkas
    public function index()
    {
        // Ambil data mahasiswa pertama yang ada di database sebagai simulasi.
        // Jika nanti Anda sudah membuat sistem login asli, ganti baris ini dengan: $mahasiswa = auth()->user();
        $mahasiswa = Mahasiswa::first(); 

        // Kirim data $mahasiswa ke file resources/views/index_mahasiswa.blade.php
        return view('index_mahasiswa', compact('mahasiswa'));
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('register');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Memproses data registrasi dan mengarahkan ke login
    public function processRegister(Request $request)
    {
        // Tempat menaruh validasi dan simpan ke database di masa depan
        
        // Setelah sukses register, langsung arahkan ke halaman form login
        return redirect()->route('login');
    }
}