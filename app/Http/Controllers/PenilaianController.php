<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\ActivityLog; // <-- Ditambahkan untuk merekam log aktivitas
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    // Fungsi khusus untuk menolak Pimpinan melakukan pengisian nilai
    private function batasiPimpinan()
    {
        if (auth()->check() && auth()->user()->role === 'pimpinan') {
            abort(403, 'AKSES DITOLAK! Pimpinan tidak diizinkan untuk menginput atau mengubah nilai.');
        }
    }

public function index()
    {
        // Menampilkan daftar pengepul untuk dinilai (Bisa diakses Admin, Operator, dan Pimpinan)
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all(); // <-- TAMBAHKAN BARIS INI agar nama kriteria muncul sebagai header tabel
        
        return view('penilaian.index', compact('alternatifs', 'kriterias'));
    }

    public function edit($id)
    {
        $this->batasiPimpinan(); // Kunci halaman form input nilai dari Pimpinan

        // Membuka form input nilai untuk satu pengepul spesifik
        $alternatif = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('penilaian.edit', compact('alternatif', 'kriterias'));
    }

    public function update(Request $request, $id)
    {
        $this->batasiPimpinan(); // Kunci proses simpan nilai dari Pimpinan

        $alternatif = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();

        // Menyimpan atau memperbarui nilai untuk setiap kriteria
        foreach ($kriterias as $kriteria) {
            $input_name = 'nilai_' . $kriteria->id;
            
            if ($request->has($input_name)) {
                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteria->id
                    ],
                    [
                        'nilai' => $request->input($input_name)
                    ]
                );
            }
        }

        // REKAM LOG AKTIVITAS (Disisipkan tepat setelah semua data kriteria sukses diperbarui)
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Input Penilaian',
            'description' => 'Memperbarui data nilai kriteria untuk pengepul: ' . $alternatif->nama_pengepul . ' (' . $alternatif->kode_alternatif . ')',
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil disimpan!');
    }
}