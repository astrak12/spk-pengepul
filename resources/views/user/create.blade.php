<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengguna Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-green-600">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Form Pendaftaran Akun</h3>
                        <p class="text-sm text-gray-500">Mendaftarkan hak akses baru untuk admin, pimpinan, atau operator aplikasi.</p>
                    </div>

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" placeholder="Masukkan nama lengkap..." required>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" placeholder="contoh: nama@gmail.com" required>
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi (Password)</label>
                            <input type="password" name="password" id="password" class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" placeholder="Minimal 8 karakter..." required>
                            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Hak Akses Sistem (Role)</label>
                            <select name="role" id="role" class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Hak Akses --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                                <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Lihat Laporan/Hasil)</option>
                                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator / Karyawan</option>
                            </select>
                            @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 border-t pt-4">
                            <a href="{{ route('user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                                Simpan Akun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>