<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded shadow">
                        <p class="font-bold mb-1">Gagal menyimpan! Periksa kesalahan berikut:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kriteria</label>
                        <select name="jenis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="benefit" {{ old('jenis', $kriteria->jenis) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('jenis', $kriteria->jenis) == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Bobot</label>
                        <input type="number" step="any" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Data
                        </button>
                        <a href="{{ route('kriteria.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>