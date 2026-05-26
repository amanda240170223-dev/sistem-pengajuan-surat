<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    return view('mahasiswa.pengajuan');
});

Route::post('/pengajuan/store', function () {

    DB::table('pengajuan')->insert([

        'nama' => request('nama'),
        'nim' => request('nim'),
        'jenis_surat' => request('jenis_surat'),
        'keterangan' => request('keterangan'),
        'status' => 'Diproses',

        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()

    ]);

    return redirect('/pengajuan')
    ->with('success', 'Pengajuan berhasil dikirim dan sedang direkap admin.');

});

Route::get('/status', function () {

    $pengajuan = DB::table('pengajuan')->get();

    return view('mahasiswa.status', compact('pengajuan'));

});

Route::get('/admin', function () {

    $pengajuan = DB::table('pengajuan')->get();

    return view('admin.dashboard', compact('pengajuan'));

});

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::post('/admin/login', function () {

    $email = request('email');
    $password = request('password');

    if($email == 'admin@gmail.com' && $password == 'admin123'){

        return redirect('/admin');

    }else{

        return back()->with('error', 'Email atau Password salah');

    }

});
