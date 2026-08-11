<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $fillable = ['kode_alternatif', 'nama_pengepul', 'alamat', 'no_telp'];

    // Menambahkan kembali relasi ke tabel penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}