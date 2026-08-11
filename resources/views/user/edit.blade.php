<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ubah Data Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Edit Akun: {{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">Perbarui informasi profil atau ubah hak akses pengguna ini.</p>
                    </div>

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru (Opsional)</label>
                            <input type="password" name="password" id="password" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Isi hanya jika ingin mengganti password...">
                            <p class="text-xs text-gray-400 mt-1">*Biarkan kosong jika pengguna tidak ingin mengganti kata sandi.</p>
                            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Hak Akses Sistem (Role)</label>
                            <select name="role" id="role" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                                <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Lihat Laporan/Hasil)</option>
                                <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator / Karyawan</option>
                            </select>
                            @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 border-t pt-4">
                            <a href="{{ route('user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                                Perbarui Akun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>