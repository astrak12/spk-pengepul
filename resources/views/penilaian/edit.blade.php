<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Nilai - {{ $alternatif->nama_pengepul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('penilaian.update', $alternatif->id) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($kriterias as $kriteria)
                            @php
                                $nilai_lama = $alternatif->penilaian->where('kriteria_id', $kriteria->id)->first();
                            @endphp

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }} ({{ ucfirst($kriteria->jenis) }})
                                </label>
                                <input type="number" step="any" name="nilai_{{ $kriteria->id }}" 
                                       value="{{ $nilai_lama ? $nilai_lama->nilai : '' }}" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Penilaian
                        </button>
                        <a href="{{ route('penilaian.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>