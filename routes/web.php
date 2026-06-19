<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengajuanSuratController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes - Autentikasi & Halaman Mahasiswa
|--------------------------------------------------------------------------
*/

Route::get('/templates/{file}', function ($file) {
    $path = public_path('templates/' . $file);

    if (!file_exists($path)) {
        abort(404, 'File template "' . $file . '" belum tersedia. Silakan hubungi admin.');
    }

    return response()->file($path);
});

Route::get('/dokumen/{path}', function ($path) {
    $fullPath = storage_path('app/public/dokumen/' . $path);
    if (!file_exists($fullPath)) { abort(404, 'File tidak ditemukan'); }
    $mime = mime_content_type($fullPath);
    return response()->file($fullPath, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="' . $path . '"'
    ]);
})->name('dokumen.show');

Route::get('/lihat-dokumen/{filename}', function ($filename) {
    $path = storage_path('app/public/dokumen/' . $filename);
    if (!file_exists($path)) { abort(404, 'File tidak ditemukan'); }
    $mime = mime_content_type($path);
    return response()->file($path, ['Content-Type' => $mime]);
})->name('dokumen.lihat');

Route::get('/download/{id}', function ($id) {
    $pengajuan = DB::table('pengajuan')->where('id', $id)->first();
    if (!$pengajuan || !$pengajuan->berkas) { abort(404); }
    $path = public_path('uploads/' . $pengajuan->berkas);
    if (!file_exists($path)) { abort(404); }
    return response()->file($path);
})->name('download.berkas');

Route::get('/', function () { return view('welcome'); });

Route::get('/login', function () { return view('auth.login'); })->name('login');

Route::get('/register', function () { return view('auth.register'); });

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'nama' => 'required',
        'nim' => 'required|unique:mahasiswa,nim',
        'password' => 'required|min:6'
    ]);
    DB::table('mahasiswa')->insert([
        'nama' => $request->nama,
        'nim' => $request->nim,
        'password' => $request->password,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
    return redirect('/')->with('success', 'Registrasi berhasil, silakan login');
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    $request->validate(['nim' => 'required', 'password' => 'required']);
    $mahasiswa = DB::table('mahasiswa')
        ->where('nim', $request->nim)
        ->where('password', $request->password)
        ->first();
    if ($mahasiswa) {
        session([
            'mahasiswa_login' => true,
            'mahasiswa_nim' => $mahasiswa->nim,
            'mahasiswa_nama' => $mahasiswa->nama
        ]);
        return redirect('/dashboard');
    }
    return back()->with('error', 'NIM atau Password salah!');
});

Route::get('/dashboard', function () { return view('mahasiswa.dashboard'); });

Route::get('/pengajuan', [PengajuanSuratController::class, 'create'])->name('pengajuan.create');
Route::post('/pengajuan/store', [PengajuanSuratController::class, 'store'])->name('pengajuan.store');

Route::get('/status', function () {
    $nim_mahasiswa = session('mahasiswa_nim') ?? session('nim');
    if ($nim_mahasiswa) {
        $pengajuan = DB::table('pengajuan')->where('nim', $nim_mahasiswa)->get();
    } else {
        $pengajuan = DB::table('pengajuan')->get();
    }
    return view('mahasiswa.status', compact('pengajuan'));
});

/*
|--------------------------------------------------------------------------
| Web Routes - Login Admin & Fungsi Utama Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () { return view('admin.login'); });

Route::post('/admin/login', function () {
    $email = request('email');
    $password = request('password');
    if ($email == 'admin@gmail.com' && $password == 'teknikinformatika') {
        session(['admin_login' => true]);
        return redirect('/admin/dashboard');
    }
    return back()->with('error', 'Email atau Password salah');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/pengajuan-surat', [PengajuanSuratController::class, 'adminIndex'])->name('admin.pengajuan.index');
Route::post('/admin/status/{id}/{status}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
Route::post('/admin/upload/{id}', [AdminController::class, 'uploadBerkas'])->name('admin.uploadBerkas');

/*
|--------------------------------------------------------------------------
| Web Routes - Manajemen Data Admin
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
    DB::table('jenis_surat')->where('id', $id)->delete();
    return redirect('/jenis-surat');
});

Route::get('/riwayat/delete/{id}', function ($id) {
    DB::table('pengajuan')->where('id', $id)->delete();
    return redirect('/riwayat')->with('success', 'Riwayat berhasil dihapus!');
});

Route::get('/riwayat', function () {
    $pengajuan = DB::table('pengajuan')->orderBy('created_at', 'desc')->get();
    return view('admin.riwayat', compact('pengajuan'));
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
    DB::table('mahasiswa')->where('id', $id)->delete();
    return redirect('/mahasiswa');
});

Route::get('/mahasiswa/edit/{id}', function ($id) {
    $mahasiswa = DB::table('mahasiswa')->where('id', $id)->first();
    return view('admin.edit_mahasiswa', compact('mahasiswa'));
});

Route::post('/mahasiswa/update/{id}', function ($id) {
    DB::table('mahasiswa')->where('id', $id)->update([
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
