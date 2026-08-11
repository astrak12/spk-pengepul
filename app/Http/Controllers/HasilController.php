<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    // Fungsi khusus agar mesin SPK bisa dipanggil berulang kali tanpa menulis ulang kode
    // PERUBAHAN 1: Menambahkan parameter $bobotSimulasi = null agar fungsi ini bisa menerima data bobot palsu/sementara
   // Fungsi khusus agar mesin SPK bisa dipanggil berulang kali tanpa menulis ulang kode
    private function hitungSPK($bobotSimulasi = null)
    {
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();
        
        $matrix = [];
        $c_values = [];

        foreach ($alternatifs as $a) {
            foreach ($kriterias as $k) {
                $p = Penilaian::where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first();
                // PERBAIKAN 1: Pastikan nilai diconvert ke float agar presisi desimal terjaga
                $nilai = $p ? (float) $p->nilai : 0.0;
                $matrix[$a->id][$k->id] = $nilai;
                $c_values[$k->id][] = $nilai;
            }
        }

        // 1. HITUNG SAW
        $hasil_saw = [];
        $raw_saw = []; // PERBAIKAN 2: Penampung nilai murni (panjang) untuk perhitungan gabungan
        foreach ($alternatifs as $a) {
            $total_skor_saw = 0.0;
            foreach ($kriterias as $k) {
                $nilai = $matrix[$a->id][$k->id] ?? 0.0;
                $max = count($c_values[$k->id] ?? []) > 0 ? max($c_values[$k->id]) : 0.0;
                $min = count($c_values[$k->id] ?? []) > 0 ? min($c_values[$k->id]) : 0.0;

                $r = 0.0;
                if ($k->jenis == 'benefit' && $max > 0) $r = $nilai / $max;
                elseif ($k->jenis == 'cost' && $nilai > 0) $r = $min / $nilai;
                
                $bobotAktif = (float) ($bobotSimulasi ? ($bobotSimulasi[$k->id] ?? $k->bobot) : $k->bobot);
                
                $total_skor_saw += $r * $bobotAktif;
            }
            $raw_saw[$a->kode_alternatif] = $total_skor_saw; // Simpan angka desimal utuh
            $hasil_saw[] = ['kode' => $a->kode_alternatif, 'nama' => $a->nama_pengepul, 'skor' => round($total_skor_saw, 3)]; // Dibulatkan hanya untuk tabel view
        }

        // 2. HITUNG TOPSIS
        $hasil_topsis = [];
        $raw_topsis = []; // PERBAIKAN 2: Penampung nilai murni untuk TOPSIS
        $pembagi = []; $y = []; $a_plus = []; $a_min = [];

        foreach ($kriterias as $k) {
            $sumSq = 0.0;
            foreach ($alternatifs as $a) $sumSq += pow($matrix[$a->id][$k->id] ?? 0.0, 2);
            $pembagi[$k->id] = sqrt($sumSq);
        }

        foreach ($alternatifs as $a) {
            foreach ($kriterias as $k) {
                $div = $pembagi[$k->id] > 0 ? $pembagi[$k->id] : 1;
                $bobotAktif = (float) ($bobotSimulasi ? ($bobotSimulasi[$k->id] ?? $k->bobot) : $k->bobot);
                $y[$a->id][$k->id] = (($matrix[$a->id][$k->id] ?? 0.0) / $div) * $bobotAktif;
            }
        }

        foreach ($kriterias as $k) {
            $vals = array_column($y, $k->id);
            if ($k->jenis == 'benefit') {
                $a_plus[$k->id] = max($vals ?: [0]); $a_min[$k->id]  = min($vals ?: [0]);
            } else {
                $a_plus[$k->id] = min($vals ?: [0]); $a_min[$k->id]  = max($vals ?: [0]);
            }
        }

        foreach ($alternatifs as $a) {
            $d_plus = 0.0; $d_min = 0.0;
            foreach ($kriterias as $k) {
                $d_plus += pow($y[$a->id][$k->id] - $a_plus[$k->id], 2);
                $d_min  += pow($y[$a->id][$k->id] - $a_min[$k->id], 2);
            }
            $v = ($d_plus + $d_min) > 0 ? sqrt($d_min) / (sqrt($d_plus) + sqrt($d_min)) : 0.0;
            
            $raw_topsis[$a->kode_alternatif] = $v; // Simpan angka desimal utuh
            $hasil_topsis[] = ['kode' => $a->kode_alternatif, 'nama' => $a->nama_pengepul, 'skor' => round($v, 3)]; // Dibulatkan hanya untuk tabel view
        }

        // 3. GABUNGAN & SORTING
        usort($hasil_saw, fn($a, $b) => $b['skor'] <=> $a['skor']);
        usort($hasil_topsis, fn($a, $b) => $b['skor'] <=> $a['skor']);

        $total_bobot_aktif = 0.0;
        foreach ($kriterias as $k) {
            $total_bobot_aktif += (float) ($bobotSimulasi ? ($bobotSimulasi[$k->id] ?? $k->bobot) : $k->bobot);
        }
        if ($total_bobot_aktif == 0) $total_bobot_aktif = 1; 

        $hasil_gabungan = [];
        foreach ($alternatifs as $a) {
            // PERBAIKAN 3: Ambil nilai murni dari variabel $raw untuk perhitungan akhir (Jangan ambil dari array filter yang sudah terpotong round)
            $skor_saw = $raw_saw[$a->kode_alternatif] ?? 0.0;
            $skor_topsis = $raw_topsis[$a->kode_alternatif] ?? 0.0;
            
            // PENYETARAAN SKALA (KEDUANYA DIJADIKAN SKALA 0 - 100)
            $saw_persen = ($skor_saw / $total_bobot_aktif) * 100;
            $topsis_persen = $skor_topsis * 100;

            $hasil_gabungan[] = [
                'kode' => $a->kode_alternatif, 
                'nama' => $a->nama_pengepul,
                'skor_saw' => round($skor_saw, 3), 
                'skor_topsis' => round($skor_topsis, 3),
                'skor_akhir' => round(($saw_persen + $topsis_persen) / 2, 3) // Dibulatkan HANYA di titik paling akhir ini
            ];
        }
        usort($hasil_gabungan, fn($a, $b) => $b['skor_akhir'] <=> $a['skor_akhir']);

        return [
            'saw' => $hasil_saw, 
            'topsis' => $hasil_topsis, 
            'gabungan' => $hasil_gabungan,
            'total_pengepul' => $alternatifs->count(),
            'total_kriteria' => $kriterias->count()
        ];
    }

    public function index()
    {
        $mulai = microtime(true);
        $data = $this->hitungSPK(); // Memanggil mesin hitung
        $waktuEksekusi = round(microtime(true) - $mulai, 4);

        return view('hasil.index', [
            'hasil_saw' => $data['saw'], 
            'hasil_topsis' => $data['topsis'], 
            'hasil_gabungan' => $data['gabungan'], 
            'waktuEksekusi' => $waktuEksekusi,
            'total_pengepul' => $data['total_pengepul'],
            'total_kriteria' => $data['total_kriteria']
        ]);
    }

   public function cetak()
    {
        $data = $this->hitungSPK();
        
        // Memisahkan label dan data untuk Diagram Batang (Top 5)
        $top5 = array_slice($data['gabungan'], 0, 5);
        $chartLabels = array_column($top5, 'nama');
        $chartData = array_column($top5, 'skor_akhir');

        // Mengambil data untuk Diagram Lingkaran (Bobot Kriteria)
        $kriterias = Kriteria::all();
        $pieLabels = $kriterias->pluck('nama_kriteria')->toArray();
        $pieData = $kriterias->pluck('bobot')->toArray();

        return view('hasil.cetak', [
            'hasil_saw' => $data['saw'], 
            'hasil_topsis' => $data['topsis'], 
            'hasil_gabungan' => $data['gabungan'],
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'pieLabels' => $pieLabels, 
            'pieData' => $pieData      
        ]);
    }

    
// 5 FUNGSI BARU UNTUK HALAMAN UJI SENSITIVITAS (SIMULASI)
   
    public function sensitivitas(Request $request)
    {
        $kriterias = Kriteria::all();
        
        // 1. Hitung Kondisi Asli
        $data_asli = $this->hitungSPK();
        $hasil_asli = $data_asli['gabungan']; 
        
        $hasil_simulasi = null;
        $bobot_simulasi = [];
        $tingkat_stabilitas = 0;
        
        // Siapkan Data untuk Diagram (Chart.js)
        $chart_labels = [];
        $chart_data_asli = [];
        $chart_data_simulasi = [];

        // Ambil label (Nama Pengepul) dan Skor Asli untuk grafik
        foreach ($hasil_asli as $asli) {
            $chart_labels[] = $asli['nama'];
            $chart_data_asli[] = $asli['skor_akhir'];
        }

        // 3. Jika pengguna menekan tombol "Jalankan Simulasi"
        if ($request->isMethod('post')) {
            $bobot_simulasi = $request->input('bobot'); 
            $data_simulasi = $this->hitungSPK($bobot_simulasi); 
            $hasil_simulasi = $data_simulasi['gabungan']; 

            // MENGHITUNG TINGKAT STABILITAS (AKURASI)
            $match_count = 0;
            foreach ($hasil_asli as $index => $asli) {
                // Jika posisi rank asli sama dengan posisi rank simulasi
                if (isset($hasil_simulasi[$index]) && $hasil_simulasi[$index]['kode'] == $asli['kode']) {
                    $match_count++;
                }
            }
            // Rumus: (Jumlah rank yang tidak berubah / Total Pengepul) * 100
            $tingkat_stabilitas = count($hasil_asli) > 0 ? round(($match_count / count($hasil_asli)) * 100, 2) : 0;

            // Memasukkan skor simulasi ke dalam grafik (dicocokkan dengan urutan label asli)
            foreach ($chart_labels as $label) {
                $skor = 0;
                foreach ($hasil_simulasi as $sim) {
                    if ($sim['nama'] == $label) {
                        $skor = $sim['skor_akhir'];
                        break;
                    }
                }
                $chart_data_simulasi[] = $skor;
            }
        }

        return view('hasil.sensitivitas', compact(
            'kriterias', 'hasil_asli', 'hasil_simulasi', 'bobot_simulasi', 
            'tingkat_stabilitas', 'chart_labels', 'chart_data_asli', 'chart_data_simulasi'
        ));
    }
}