<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['alternatif_id', 'kriteria_id', 'nilai'];

    // Menambahkan kembali relasi balik ke tabel alternatif dan kriteria
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}