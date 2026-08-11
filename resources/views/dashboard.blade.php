<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama SPK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Kriteria Penilaian</div>
                    <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $total_kriteria ?? 0 }} Data</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Pengepul Mitra</div>
                    <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $total_pengepul ?? 0 }} Mitra</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-600">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Peringkat 5 Pengepul Terbaik</h3>
                    <p class="text-xs text-gray-500 mb-6 font-medium italic">*Berdasarkan nilai preferensi akhir</p>
                    <div class="relative h-64 w-full">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Komposisi Bobot Kriteria</h3>
                    <p class="text-xs text-gray-500 mb-6 font-medium italic">*Persentase pengaruh setiap kriteria</p>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. LOGIKA DIAGRAM BATANG (Membaca Peringkat Hasil Perhitungan SAW Asli)
            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($barLabels), // <-- Mengambil Nama Pengepul Asli Database
                    datasets: [{
                        label: 'Skor Akhir Preferensi',
                        data: @json($barData), // <-- Mengambil Skor SAW Asli Real-Time
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(21, 128, 61)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { 
                            beginAtZero: true
                        } 
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // 2. LOGIKA DIAGRAM LINGKARAN (Membaca Bobot Kriteria Kuantitatif Asli)
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: @json($pieLabels), // <-- Mengambil Nama Kriteria Asli dari Tabel Kriteria
                    datasets: [{
                        data: @json($pieData), // <-- Mengambil Nilai Bobot Asli dari Tabel Kriteria
                        backgroundColor: [
                            '#10b981', 
                            '#3b82f6', 
                            '#f59e0b', 
                            '#6366f1',
                            '#ec4899',
                            '#14b8a6'
                        ],
                        hoverOffset: 15,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>