<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_kriteria = Kriteria::count();
        $total_pengepul = Alternatif::count();

        // ==========================================
        // 1. AMBIL DATA ASLI UNTUK PIE CHART
        // ==========================================
        $kriterias = Kriteria::all();
        $pieLabels = $kriterias->pluck('nama_kriteria')->toArray();
        $pieData = $kriterias->pluck('bobot')->toArray();

        // ==========================================
        // 2. HITUNG SKOR RILL SAW UNTUK BAR CHART
        // ==========================================
        $alternatifs = Alternatif::all();
        
        $matrix = [];
        $c_values = [];

        // Menyusun matriks penilaian awal dari database
        foreach ($alternatifs as $a) {
            foreach ($kriterias as $k) {
                $p = Penilaian::where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first();
                $nilai = $p ? $p->nilai : 0;
                $matrix[$a->id][$k->id] = $nilai;
                $c_values[$k->id][] = $nilai; // Menyimpan kumpulan nilai per kriteria untuk mencari max/min
            }
        }

        $hasil_saw = [];
        foreach ($alternatifs as $a) {
            $total_skor = 0;
            foreach ($kriterias as $k) {
                $nilai = $matrix[$a->id][$k->id] ?? 0;
                $max = isset($c_values[$k->id]) && count($c_values[$k->id]) > 0 ? max($c_values[$k->id]) : 0;
                $min = isset($c_values[$k->id]) && count($c_values[$k->id]) > 0 ? min($c_values[$k->id]) : 0;

                // Proses Normalisasi Matriks r_ij
                $r = 0;
                if ($k->jenis == 'benefit' && $max > 0) {
                    $r = $nilai / $max;
                } elseif ($k->jenis == 'cost' && $nilai > 0) {
                    $r = $min / $nilai;
                }

                // Perhitungan Nilai Preferensi (V_i)
                $total_skor += $r * $k->bobot;
            }
            
            $hasil_saw[] = [
                'nama' => $a->nama_pengepul,
                'skor' => round($total_skor, 3)
            ];
        }

        // Urutkan peringkat dari skor tertinggi ke terendah, lalu ambil 5 teratas
        usort($hasil_saw, function($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });
        $top5 = array_slice($hasil_saw, 0, 5);

        $barLabels = array_column($top5, 'nama');
        $barData = array_column($top5, 'skor');

        return view('dashboard', compact(
            'total_kriteria', 
            'total_pengepul', 
            'pieLabels', 
            'pieData', 
            'barLabels', 
            'barData'
        ));
    }
}