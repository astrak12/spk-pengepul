<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\UserController;


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/log-aktivitas', [ActivityLogController::class, 'index'])->name('log.index');
});

// Kumpulan rute untuk fitur SPK kita (Hanya bisa diakses jika sudah login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('alternatif', AlternatifController::class);
    Route::resource('user', UserController::class);
    
    
    // Rute khusus Penilaian
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/input/{id}', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::post('/penilaian/input/{id}', [PenilaianController::class, 'update'])->name('penilaian.update');
Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
Route::get('/hasil/cetak', [App\Http\Controllers\HasilController::class, 'cetak'])->name('hasil.cetak');
Route::match(['get', 'post'], '/hasil/sensitivitas', [App\Http\Controllers\HasilController::class, 'sensitivitas'])->name('hasil.sensitivitas');
    });

require __DIR__.'/auth.php';