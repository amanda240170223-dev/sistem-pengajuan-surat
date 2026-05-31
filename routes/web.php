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

Route::get('/status', function () {

    $pengajuan = DB::table('pengajuan')->get();

    return view('mahasiswa.status', compact('pengajuan'));

});

Route::get('/admin', function () {

    if(!session('admin_login')){

        return redirect('/admin/login');

    }

    $pengajuan = DB::table('pengajuan')->get();

    $totalPengajuan = DB::table('pengajuan')->count();

    $totalMahasiswa = DB::table('mahasiswa')->count();

    $totalJenisSurat = DB::table('jenis_surat')->count();

    return view('admin.dashboard', compact(
        'pengajuan',
        'totalPengajuan',
        'totalMahasiswa',
        'totalJenisSurat'
    ));

});

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

        return redirect('/admin');

    }else{

        return back()->with('error', 'Email atau Password salah');

    }

});

Route::get('/status/setujui/{id}', function ($id) {

    DB::table('pengajuan')
    ->where('id', $id)
    ->update([
        'status' => 'Disetujui'
    ]);

    return back();

});

Route::get('/status/tolak/{id}', function ($id) {

    DB::table('pengajuan')
    ->where('id', $id)
    ->update([
        'status' => 'Ditolak'
    ]);

    return back();

});

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
