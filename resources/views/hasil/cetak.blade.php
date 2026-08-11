<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Keputusan SPK - Bank Sampah Japos 09</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background-color: white; color: black; }
        .page-break { page-break-before: always; }
        @media print {
            @page { margin: 1cm; size: A4 portrait; }
            body { background: transparent; }
            #btn-print { display: none; }
        }
        /* Tabel untuk Data */
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 6px; text-align: left; }
        .table-data th { background-color: #f3f4f6; text-align: center; font-weight: bold; }
        
        /* Tabel Khusus Layout Diagram (Tanpa Garis) */
        .table-layout { width: 100%; border: none; border-collapse: collapse; margin-bottom: 20px; }
        .table-layout td { border: none; padding: 0; vertical-align: top; width: 50%; }
    </style>
</head>
<body class="p-8 max-w-5xl mx-auto">

    <button id="btn-print" onclick="window.print()" class="fixed top-5 right-5 bg-blue-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg cursor-pointer">
        🖨️ Cetak PDF Sekarang
    </button>

    <div class="border-b-4 border-black pb-4 mb-6 text-center flex items-center justify-center">
        <div class="w-20 h-20 bg-green-700 text-white flex items-center justify-center font-bold text-3xl rounded-full mr-6 border-4 border-green-900">
            BS
        </div>
        <div>
            <h1 class="text-3xl font-extrabold uppercase">BANK SAMPAH JAPOS 09</h1>
            <p class="text-lg">Jl. Japos Raya No. 99, Tangerang Selatan, Banten</p>
            <p class="text-sm">Telepon: (021) 1234567 | Email: info@japos09.com</p>
        </div>
    </div>

    <div class="text-center mb-6">
        <h2 class="text-xl font-bold uppercase underline">Laporan Keputusan Pemilihan Pengepul Terbaik</h2>
        <p class="text-sm mt-1">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }}</p>
    </div>

    <h3 class="text-lg font-bold mb-2">A. Visualisasi Keputusan & Kriteria</h3>
    
    <table class="table-layout">
        <tr>
            <td style="padding-right: 10px;">
                <div style="border: 1px solid #d1d5db; padding: 10px;">
                    <h4 style="text-align: center; font-weight: bold; font-size: 13px; margin-bottom: 5px;">Rekomendasi 5 Pengepul Terbaik</h4>
                    <div style="height: 200px; width: 100%;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </td>
            
            <td style="padding-left: 10px;">
                <div style="border: 1px solid #d1d5db; padding: 10px;">
                    <h4 style="text-align: center; font-weight: bold; font-size: 13px; margin-bottom: 5px;">Komposisi Bobot Kriteria</h4>
                    <div style="height: 200px; width: 100%;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <h3 class="text-lg font-bold mb-2">B. Hasil Keputusan Akhir (Metode Gabungan)</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Kode</th>
                <th>Nama Pengepul</th>
                <th>Skor Akhir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil_gabungan as $index => $gabungan)
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $gabungan['kode'] }}</td>
                    <td>{{ $gabungan['nama'] }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($gabungan['skor_akhir'], 3) }}</td>
                    <td style="text-align: center;">
                        {{ $index === 0 ? '🏆 DIREKOMENDASIKAN' : 'Alternatif' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div> <h3 class="text-lg font-bold mb-2 mt-4">C. Rincian Perhitungan Per Metode</h3>
    <p class="text-sm mb-4">Berikut adalah rincian nilai preferensi dari masing-masing metode perhitungan yang digunakan sistem.</p>
    
    <h4 class="font-bold mb-1">1. Hasil Metode SAW (Simple Additive Weighting)</h4>
    <table class="table-data">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Pengepul</th>
                <th>Nilai V</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil_saw as $index => $saw)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $saw['nama'] }}</td>
                    <td style="text-align: center;">{{ number_format($saw['skor'], 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="font-bold mt-6 mb-1">2. Hasil Metode TOPSIS</h4>
    <table class="table-data">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Pengepul</th>
                <th>Nilai Kedekatan (Ci)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil_topsis as $index => $topsis)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $topsis['nama'] }}</td>
                    <td style="text-align: center;">{{ number_format($topsis['skor'], 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-end mt-12">
        <div class="text-center">
            <p>Tangerang Selatan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="font-bold mt-2">Pimpinan Bank Sampah,</p>
            <br><br><br><br>
            <p class="font-bold underline">Bpk. Nama Pimpinan</p>
            <p>NIP. 1234567890</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Render Bar Chart
            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Nilai Akhir',
                        data: @json($chartData),
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgb(21, 128, 61)',
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: false,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { beginAtZero: true },
                        x: { ticks: { font: { size: 9 } } } // Perkecil teks nama pengepul di bawah batang
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // 2. Render Pie Chart
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        data: @json($pieData),
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#6366f1', '#ec4899', '#14b8a6'],
                        borderWidth: 1,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    animation: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right', // Pindahkan posisi keterangan ke kanan agar tidak menabrak
                            labels: { boxWidth: 10, font: { size: 9 } } // Perkecil ukuran box warna dan teks
                        }
                    }
                }
            });

            // Waktu tunggu ditambah menjadi 1.5 detik agar browser benar-benar selesai menggambar
            setTimeout(() => { window.print(); }, 1500);
        });
    </script>
</body>
</html>