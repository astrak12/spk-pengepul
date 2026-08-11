<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_kriteria">
                            Kode Kriteria (Contoh: C1, C2)
                        </label>
                        <input type="text" name="kode_kriteria" id="kode_kriteria" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_kriteria">
                            Nama Kriteria
                        </label>
                        <input type="text" name="nama_kriteria" id="nama_kriteria" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis">
                            Jenis Kriteria
                        </label>
                        <select name="jenis" id="jenis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="benefit">Benefit (Semakin besar nilai semakin baik)</option>
                            <option value="cost">Cost (Semakin kecil nilai semakin baik)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="bobot">
                            Bobot (Gunakan titik untuk desimal, contoh: 0.25 atau 25)
                        </label>
                        <input type="number" step="any" name="bobot" id="bobot" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Data
                        </button>
                        <a href="{{ route('kriteria.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>