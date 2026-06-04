<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\AdminController; // Memanggil AdminController untuk aksi status & upload berkas

/*
|--------------------------------------------------------------------------
| Web Routes - Autentikasi & Halaman Mahasiswa
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/pengajuan', function () {
    $jenisSurat = DB::table('jenis_surat')->get();
    return view('mahasiswa.pengajuan', compact('jenisSurat'));
});

Route::post('/pengajuan/store', function () {
    $fileName = null;

    if(request()->hasFile('file')) {
        $fileName = time().'_'.request()->file('file')->getClientOriginalName();
        request()->file('file')->move(
            public_path('uploads'),
            $fileName
        );
    }

    DB::table('pengajuan')->insert([
        'nama' => request('nama'),
        'nim' => request('nim'),
        'jenis_surat' => request('jenis_surat'),
        'keterangan' => request('keterangan'),
        'file' => $fileName,
        'status' => 'Diproses',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    return redirect('/pengajuan')
        ->with('success', 'Pengajuan berhasil dikirim dan sedang direkap admin.');
});

// ==========================================================================
// PERBAIKAN RUTE STATUS: Memfilter data pengajuan berdasarkan NIM milik sendiri
// ==========================================================================
Route::get('/status', function () {
    // 1. Ambil NIM dari session login mahasiswa (Sesuaikan dengan key session login Anda, misal: 'mahasiswa_nim' atau 'nim')
    $nim_mahasiswa = session('mahasiswa_nim') ?? session('nim');

    if ($nim_mahasiswa) {
        // Jika ada session login, filter data pengajuan yang NIM-nya COCOK dengan mahasiswa yang login
        $pengajuan = DB::table('pengajuan')
            ->where('nim', $nim_mahasiswa)
            ->get();
    } else {
        // Fallback / Cadangan: Jika belum menerapkan sistem session login, tampilkan semua data agar tidak kosong saat ditest
        $pengajuan = DB::table('pengajuan')->get();
    }

    return view('mahasiswa.status', compact('pengajuan'));
});

/*
|--------------------------------------------------------------------------
| Web Routes - Login Admin & Fungsi Utama Admin (Menggunakan Controller Baru)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::post('/admin/login', function () {
    $email = request('email');
    $password = request('password');

    if($email == 'admin@gmail.com' && $password == 'amandadantemanteman'){
        session([
            'admin_login' => true
        ]);
        return redirect('/admin/dashboard'); // Diarahkan langsung ke dashboard Controller
    } else {
        return back()->with('error', 'Email atau Password salah');
    }
});

// Rute Dashboard Admin menggunakan Controller
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Rute Dinamis untuk Mengubah Status (Setuju, Tolak, Proses)
Route::post('/admin/status/{id}/{status}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');

// Rute khusus untuk Upload File Berkas Balasan dari Admin
Route::post('/admin/upload/{id}', [AdminController::class, 'uploadBerkas'])->name('admin.uploadBerkas');

/*
|--------------------------------------------------------------------------
| Web Routes - Manajemen Data Admin (CRUD Jenis Surat & Mahasiswa)
|--------------------------------------------------------------------------
*/

Route::get('/jenis-surat', function () {
    $jenisSurat = DB::table('jenis_surat')->get();
    return view('admin.jenis_surat', compact('jenisSurat'));
});

Route::post('/jenis-surat/store', function () {
    DB::table('jenis_surat')->insert([
        'nama_surat' => request('nama_surat'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
    return redirect('/jenis-surat');
});

Route::get('/jenis-surat/delete/{id}', function ($id) {
    DB::table('jenis_surat')
    ->where('id', $id)
    ->delete();
    return redirect('/jenis-surat');
});

Route::get('/mahasiswa', function () {
    $mahasiswa = DB::table('mahasiswa')->get();
    return view('admin.mahasiswa', compact('mahasiswa'));
});

Route::post('/mahasiswa/store', function () {
    DB::table('mahasiswa')->insert([
        'nama' => request('nama'),
        'nim' => request('nim'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
    return redirect('/mahasiswa');
});

Route::get('/mahasiswa/delete/{id}', function ($id) {
    DB::table('mahasiswa')
    ->where('id', $id)
    ->delete();
    return redirect('/mahasiswa');
});

Route::get('/mahasiswa/edit/{id}', function ($id) {
    $mahasiswa = DB::table('mahasiswa')
    ->where('id', $id)
    ->first();
    return view('admin.edit_mahasiswa', compact('mahasiswa'));
});

Route::post('/mahasiswa/update/{id}', function ($id) {
    DB::table('mahasiswa')
    ->where('id', $id)
    ->update([
        'nama' => request('nama'),
        'nim' => request('nim'),
        'updated_at' => Carbon::now()
    ]);
    return redirect('/mahasiswa');
});

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});