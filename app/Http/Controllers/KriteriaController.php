<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\ActivityLog; // <-- Ditambahkan untuk merekam log
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    private function batasiPimpinan()
    {
        if (auth()->check() && auth()->user()->role === 'pimpinan') {
            abort(403, 'AKSES DITOLAK! Pimpinan hanya diizinkan melihat data kriteria, tidak boleh menambah, mengubah, atau menghapusnya.');
        }
    }

    public function index()
    {
        $kriterias = Kriteria::all();
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        $this->batasiPimpinan();
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $this->batasiPimpinan();
        
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias',
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric',
            'jenis'         => 'required|in:benefit,cost',
        ]);

        $kriteria = Kriteria::create($request->all());

        // REKAM LOG AKTIVITAS
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Tambah Kriteria',
            'description' => 'Menambahkan kriteria baru: ' . $kriteria->nama_kriteria . ' (' . $kriteria->kode_kriteria . ')',
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Data kriteria berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $this->batasiPimpinan();
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, string $id)
    {
        $this->batasiPimpinan();
        
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria,' . $id,
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric',
            'jenis'         => 'required|in:benefit,cost',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->all());

        // REKAM LOG AKTIVITAS
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Ubah Kriteria',
            'description' => 'Mengubah data kriteria: ' . $kriteria->nama_kriteria,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Data kriteria berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $this->batasiPimpinan();
        
        $kriteria = Kriteria::findOrFail($id);
        
        // REKAM LOG AKTIVITAS (Wajib sebelum data terhapus)
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Hapus Kriteria',
            'description' => 'Menghapus kriteria bernama: ' . $kriteria->nama_kriteria . ' (' . $kriteria->kode_kriteria . ')',
        ]);

        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Data kriteria berhasil dihapus!');
    }
}