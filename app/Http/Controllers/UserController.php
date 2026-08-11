<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog; // <-- WAJIB DITAMBAHKAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function proteksiAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK! Hanya Admin yang diizinkan mengakses halaman ini.');
        }
    }

    public function index()
    {
        $this->proteksiAdmin();
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $this->proteksiAdmin();
        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->proteksiAdmin();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,pimpinan,operator',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // JALANKAN PENCATATAN LOG
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Tambah Akun',
            'description' => 'Mendaftarkan akun baru: ' . $user->name . ' (' . $user->role . ')',
        ]);

        return redirect()->route('user.index')->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $this->proteksiAdmin();
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $this->proteksiAdmin();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role'  => 'required|in:admin,pimpinan,operator',
        ]);

        $user = User::findOrFail($id);
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // JALANKAN PENCATATAN LOG
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Ubah Akun',
            'description' => 'Memperbarui data akun pengguna: ' . $user->name,
        ]);

        return redirect()->route('user.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $this->proteksiAdmin();
        $user = User::findOrFail($id);

        // JALANKAN PENCATATAN LOG
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'Hapus Akun',
            'description' => 'Menghapus akun pengguna bernama: ' . $user->name,
        ]);

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Akun berhasil dihapus!');
    }
}