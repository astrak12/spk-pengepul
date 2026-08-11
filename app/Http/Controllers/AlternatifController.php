<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\ActivityLog; // <-- WAJIB DITAMBAHKAN
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    private function batasiPimpinan()
    {
        if (auth()->check() && auth()->user()->role === 'pimpinan') {
            abort(403, 'AKSES DITOLAK! Pimpinan hanya diizinkan melihat data, tidak boleh menambah, mengubah, atau menghapusnya.');
        }
    }

    public function index()
    {
        $alternatifs = Alternatif::all();
        return view('alternatif.index', compact('alternatifs'));
    }

    public function create()
    {
        $this->batasiPimpinan();
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $this->batasiPimpinan();
        
        $request->validate([
            'kode_alternatif' => 'required|unique:alternatifs',
            'nama_pengepul'   => 'required|string|max:255',
            'alamat'          => 'nullable|string',
            'no_telp'         => 'nullable|string',
        ]);

        $alternatif = Alternatif::create($request->all());

        // JALANKAN PENCATATAN LOG
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Tambah Pengepul',
            'description' => 'Menambahkan pengepul baru: ' . $alternatif->nama_pengepul . ' (' . $alternatif->kode_alternatif . ')',
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data pengepul berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $this->batasiPimpinan();
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, string $id)
    {
        $this->batasiPimpinan();
        
        $request->validate([
            'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif,' . $id,
            'nama_pengepul'   => 'required|string|max:255',
            'alamat'          => 'nullable|string',
            'no_telp'         => 'nullable|string',
        ]);

        $alternatif = Alternatif::findOrFail($id);
        $alternatif->update($request->all());

        // JALANKAN PENCATATAN LOG
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Ubah Pengepul',
            'description' => 'Mengubah data pengepul: ' . $alternatif->nama_pengepul,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data pengepul berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $this->batasiPimpinan();
        
        $alternatif = Alternatif::findOrFail($id);
        
        // JALANKAN PENCATATAN LOG (Wajib dicatat SEBELUM data dihapus dari database)
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Hapus Pengepul',
            'description' => 'Menghapus pengepul bernama: ' . $alternatif->nama_pengepul . ' (' . $alternatif->kode_alternatif . ')',
        ]);

        $alternatif->delete();

        return redirect()->route('alternatif.index')->with('success', 'Data pengepul berhasil dihapus!');
    }
}