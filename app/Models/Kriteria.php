<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $fillable = ['kode_kriteria', 'nama_kriteria', 'jenis', 'bobot'];

    // Menambahkan kembali relasi ke tabel penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}