<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Matriks Penilaian Pengepul') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Nilai Kriteria Alternatif</h3>
                    <p class="text-sm text-gray-500">Berikut adalah lembar penilaian matriks keputusan untuk seluruh kriteria pengepul mitra.</p>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border border-collapse">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border text-center w-16">No</th>
                                <th class="px-6 py-3 border">Nama Pengepul</th>
                                
                                @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-3 border text-center">{{ $kriteria->nama_kriteria }} ({{ $kriteria->kode_kriteria }})</th>
                                @endforeach
                                
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                                    <th scope="col" class="px-6 py-3 text-center border">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alternatifs as $key => $alternatif)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 border text-center font-medium text-gray-900">{{ $key + 1 }}</td>
                                    <td class="px-6 py-4 border font-semibold text-gray-900">
                                        {{ $alternatif->nama_pengepul }} <span class="text-xs text-gray-400 font-normal">({{ $alternatif->kode_alternatif }})</span>
                                    </td>
                                    
                                    @foreach($kriterias as $kriteria)
                                        <td class="px-4 py-4 border text-center font-bold text-gray-700">
                                            @php
                                                // Mengambil nilai berdasarkan korelasi alternatif_id dan kriteria_id
                                                $data_nilai = \App\Models\Penilaian::where('alternatif_id', $alternatif->id)
                                                    ->where('kriteria_id', $kriteria->id)
                                                    ->first();
                                            @endphp
                                            {{ $data_nilai ? $data_nilai->nilai : '-' }}
                                        </td>
                                    @endforeach
                                    
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                                        <td class="px-6 py-4 border text-center">
                                            <a href="{{ route('penilaian.edit', $alternatif->id) }}" class="text-green-600 hover:underline font-semibold">
                                                Input/Ubah Nilai
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($kriterias) + ((Auth::user()->role == 'admin' || Auth::user()->role == 'operator') ? 3 : 2) }}" class="px-6 py-4 text-center text-gray-500 border">
                                        Belum ada data pengepul untuk dinilai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>