<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Izinkan 'admin' dan 'pimpinan' untuk melihat log
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'pimpinan'])) {
            abort(403, 'AKSES DITOLAK! Hanya Admin dan Pimpinan yang dapat melihat Log Aktivitas.');
        }

        // Mengambil data log dari yang paling baru (terbaru di atas)
        $logs = \App\Models\ActivityLog::latest()->get(); 
        
        return view('log.index', compact('logs'));
    }
}