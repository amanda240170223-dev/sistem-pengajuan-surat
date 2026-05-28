<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}