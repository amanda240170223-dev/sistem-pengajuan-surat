<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    // Mengizinkan penyimpanan massal untuk kolom form pengajuan
    protected $fillable = [
        'nama', 
        'nim', 
        'jenis_surat', 
        'keterangan', 
        'slip_ukt', 
        'krs_terbaru'
    ];

    // Relasi bawaan Anda yang sebelumnya (tetap dipertahankan)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}