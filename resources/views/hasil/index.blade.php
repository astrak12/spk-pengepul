<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Keputusan & Peringkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-blue-50 border border-blue-200 shadow-sm sm:rounded-lg p-5 flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <div class="w-full flex justify-between items-center">
                    <div>
                        <p class="text-sm text-blue-900 font-bold">Pemrosesan Komputasi Ganda Berhasil</p>
                        <p class="text-sm text-blue-700 mt-1">
                            Sistem mengkalkulasi <strong>{{ $total_pengepul }} Pengepul</strong> menggunakan algoritma SAW & TOPSIS dalam 
                            <span class="bg-blue-200 text-blue-900 font-mono px-2 py-0.5 rounded text-xs font-bold">{{ $waktuEksekusi }} Detik</span>
                        </p>
                    </div>
                   <a href="{{ route('hasil.cetak') }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-lg transition-colors flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
    </svg>
    <span class="text-sm">Cetak Laporan Lengkap</span>
</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-t-8 border-yellow-500 relative">
                <div class="absolute top-0 right-0 bg-yellow-500 text-white font-extrabold px-4 py-1 rounded-bl-lg text-sm shadow">
                    REKOMENDASI FINAL
                </div>
                
                <h3 class="text-2xl font-extrabold text-gray-800 mb-1">Peringkat Akhir (Gabungan SAW & TOPSIS)</h3>
                <p class="text-sm text-gray-500 mb-5">Diperoleh dari nilai rata-rata persentase kedua metode untuk menghasilkan keputusan paling objektif.</p>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs text-yellow-900 uppercase bg-yellow-100 border-b-2 border-yellow-300">
                            <tr>
                                <th class="px-6 py-4 text-center w-16">Rank</th>
                                <th class="px-6 py-4">Nama Pengepul</th>
                                <th class="px-6 py-4 text-center">Skor SAW</th>
                                <th class="px-6 py-4 text-center">Skor TOPSIS</th>
                                <th class="px-6 py-4 text-center bg-yellow-200">Skor Akhir (Rata-rata)</th>
                                <th class="px-6 py-4 text-center">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hasil_gabungan as $index => $gabungan)
                                <tr class="border-b {{ $index === 0 ? 'bg-yellow-50' : 'bg-white hover:bg-gray-50' }}">
                                    <td class="px-6 py-4 text-center font-extrabold text-lg {{ $index === 0 ? 'text-yellow-600 text-2xl' : 'text-gray-700' }}">
                                        @if($index === 0) 🏆 @else {{ $index + 1 }} @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $gabungan['nama'] }} <span class="text-xs text-gray-400 font-normal">({{ $gabungan['kode'] }})</span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ number_format($gabungan['skor_saw'], 3) }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ number_format($gabungan['skor_topsis'], 3) }}</td>
                                    <td class="px-6 py-4 text-center font-extrabold text-lg {{ $index === 0 ? 'text-yellow-600 bg-yellow-100' : 'text-gray-800 bg-gray-50' }}">
                                        {{ number_format($gabungan['skor_akhir'], 3) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($index === 0)
                                            <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full uppercase shadow">Terpilih</span>
                                        @elseif($index < 3)
                                            <span class="bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Alternatif</span>
                                        @else
                                            <span class="text-gray-400 text-xs font-semibold">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center space-x-4 my-4">
                <hr class="flex-grow border-gray-300">
                <span class="text-gray-400 font-bold text-sm uppercase">Rincian Perhitungan Individu</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Peringkat Metode SAW</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-white uppercase bg-green-600">
                                <tr>
                                    <th class="px-4 py-2 text-center w-12">Rank</th>
                                    <th class="px-4 py-2">Nama Pengepul</th>
                                    <th class="px-4 py-2 text-center">Nilai (V)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil_saw as $index => $saw)
                                    <tr class="border-b {{ $index === 0 ? 'bg-green-50' : 'bg-white' }}">
                                        <td class="px-4 py-2 text-center font-bold">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 font-semibold text-gray-900">{{ $saw['nama'] }}</td>
                                        <td class="px-4 py-2 text-center font-bold text-green-600">{{ number_format($saw['skor'], 3) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-purple-500">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Peringkat Metode TOPSIS</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-white uppercase bg-purple-600">
                                <tr>
                                    <th class="px-4 py-2 text-center w-12">Rank</th>
                                    <th class="px-4 py-2">Nama Pengepul</th>
                                    <th class="px-4 py-2 text-center">Nilai (Ci)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil_topsis as $index => $topsis)
                                    <tr class="border-b {{ $index === 0 ? 'bg-purple-50' : 'bg-white' }}">
                                        <td class="px-4 py-2 text-center font-bold">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 font-semibold text-gray-900">{{ $topsis['nama'] }}</td>
                                        <td class="px-4 py-2 text-center font-bold text-purple-600">{{ number_format($topsis['skor'], 3) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>