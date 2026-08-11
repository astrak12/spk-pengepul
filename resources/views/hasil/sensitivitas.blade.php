<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uji Sensitivitas & Stabilitas SPK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-indigo-50 border border-indigo-200 shadow-sm sm:rounded-lg p-5">
                <h3 class="font-bold text-indigo-900 text-lg mb-1">Analisis Sensitivitas & Akurasi</h3>
                <p class="text-sm text-indigo-700">Simulasikan perubahan prioritas bobot kriteria. Sistem akan secara otomatis menghitung ulang dan menampilkan grafik perbandingan serta persentase stabilitas rekomendasi (keakuratan).</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1 bg-white shadow sm:rounded-lg p-6 h-fit">
                    <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">Input Skenario Bobot Baru</h4>
                    
                    <form action="{{ route('hasil.sensitivitas') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            @foreach($kriterias as $k)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $k->nama_kriteria }} <span class="text-xs text-gray-400">(Asli: {{ $k->bobot }})</span>
                                    </label>
                                    <input type="number" name="bobot[{{ $k->id }}]" 
                                        value="{{ $bobot_simulasi[$k->id] ?? $k->bobot }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex space-x-2">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors text-sm">
                                🚀 Jalankan Simulasi
                            </button>
                            <a href="{{ route('hasil.sensitivitas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    @if($hasil_simulasi)
                    <div class="bg-white shadow sm:rounded-lg p-6 border-l-4 {{ $tingkat_stabilitas >= 50 ? 'border-green-500' : 'border-red-500' }} flex items-center justify-between">
                        <div>
                            <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Tingkat Stabilitas Peringkat</h4>
                            <p class="text-xs text-gray-400 mt-1">Mengukur keakuratan sistem mempertahankan peringkat juara saat bobot diubah.</p>
                        </div>
                        <div class="text-4xl font-black {{ $tingkat_stabilitas >= 50 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $tingkat_stabilitas }}%
                        </div>
                    </div>
                    @endif

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">Grafik Perbandingan Skor</h4>
                        <div class="relative h-64 w-full">
                            <canvas id="sensitivitasChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">Tabel Perubahan Peringkat</h4>
                        
                        <div class="grid grid-cols-1 {{ $hasil_simulasi ? 'md:grid-cols-2' : '' }} gap-4">
                            <div>
                                <div class="bg-gray-100 px-3 py-2 rounded-t font-bold text-sm text-center text-gray-700 border border-b-0">
                                    Kondisi Asli (Database)
                                </div>
                                <table class="w-full text-sm text-left text-gray-600 border">
                                    <thead class="text-xs uppercase bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-3 py-2 text-center w-12">Rank</th>
                                            <th class="px-3 py-2">Pengepul</th>
                                            <th class="px-3 py-2 text-center">Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hasil_asli as $index => $asli)
                                            <tr class="border-b {{ $index === 0 ? 'bg-yellow-50' : 'bg-white' }}">
                                                <td class="px-3 py-2 text-center font-bold">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-900">{{ $asli['nama'] }}</td>
                                                <td class="px-3 py-2 text-center font-bold">{{ number_format($asli['skor_akhir'], 3) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($hasil_simulasi)
                            <div>
                                <div class="bg-indigo-100 px-3 py-2 rounded-t font-bold text-sm text-center text-indigo-800 border border-indigo-200 border-b-0">
                                    Hasil Simulasi Baru
                                </div>
                                <table class="w-full text-sm text-left text-gray-600 border border-indigo-200">
                                    <thead class="text-xs uppercase bg-indigo-50 border-b border-indigo-200">
                                        <tr>
                                            <th class="px-3 py-2 text-center w-12 text-indigo-900">Rank</th>
                                            <th class="px-3 py-2 text-indigo-900">Pengepul</th>
                                            <th class="px-3 py-2 text-center text-indigo-900">Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hasil_simulasi as $index => $simulasi)
                                            @php 
                                                // Cek apakah posisi ini ditempati oleh pengepul yang sama dengan aslinya
                                                $isRankChanged = ($simulasi['kode'] !== $hasil_asli[$index]['kode']);
                                            @endphp
                                            <tr class="border-b {{ $isRankChanged ? 'bg-red-50' : 'bg-green-50' }}">
                                                <td class="px-3 py-2 text-center font-bold">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-900">
                                                    {{ $simulasi['nama'] }}
                                                    @if($isRankChanged) <span class="text-xs text-red-500 block">Status Berubah</span> @endif
                                                </td>
                                                <td class="px-3 py-2 text-center font-bold">{{ number_format($simulasi['skor_akhir'], 3) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('sensitivitasChart').getContext('2d');
            
            // Ambil data dari PHP
            const labels = @json($chart_labels);
            const dataAsli = @json($chart_data_asli);
            
            // Cek apakah ada data simulasi (jika form sudah disubmit)
            const hasSimulasi = {{ $hasil_simulasi ? 'true' : 'false' }};
            const dataSimulasi = @json($chart_data_simulasi);

            let datasets = [
                {
                    label: 'Skor Asli',
                    data: dataAsli,
                    backgroundColor: 'rgba(75, 85, 99, 0.7)', // Warna abu-abu
                    borderColor: 'rgba(75, 85, 99, 1)',
                    borderWidth: 1
                }
            ];

            // Jika sedang dalam mode simulasi, tambahkan batang grafik baru di sampingnya
            if (hasSimulasi) {
                datasets.push({
                    label: 'Skor Simulasi',
                    data: dataSimulasi,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)', // Warna Indigo/Ungu
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                });
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>