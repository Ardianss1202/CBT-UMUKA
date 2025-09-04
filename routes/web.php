<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;   
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\IkutUjianController;
use App\Http\Controllers\UjianController;

// Menampilkan halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Dashboard hanya bisa diakses setelah login
Route::middleware(['authadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-camaba', [SiswaController::class, 'index'])->name('siswa.index');
    Route::resource('Guru', GuruController::class);
    
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');


    Route::get('/data-mapel', [MapelController::class, 'index'])->name('mapel.index');
    Route::get('/data-mapel-create', [MapelController::class, 'create'])->name('mapel.create');
    Route::post('/data-mapel-store', [MapelController::class, 'store'])->name('mapel.store');
    Route::get('/mapel/{id}/edit', [MapelController::class, 'edit'])->name('mapel.edit');
    Route::delete('/mapel/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    Route::put('/mapel/{id}', [MapelController::class, 'update'])->name('mapel.update');

    Route::get('/data-soal', [SoalController::class, 'index'])->name('soal.index');       // Menampilkan daftar soal
    Route::get('/soal/create', [SoalController::class, 'create'])->name('soal.create'); // Form tambah soal
    Route::post('/tambah-soal', [SoalController::class, 'store'])->name('soal.store');       // Simpan soal baru
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit'); // Form edit soal
    Route::put('/soal/{id}', [SoalController::class, 'update'])->name('soal.update');  // Update soal
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy'); // Hapus soal

    Route::get('/data-ujian', [UjianController::class, 'index'])->name('ujian.index');
    Route::get('/edit-data-ujian/{id}', [UjianController::class, 'edit'])->name('ujian.edit');
    Route::put('/update-data-ujian/{id}', [UjianController::class, 'update'])->name('ujian.update');
    Route::put('/data-ujian/generateToken/{id}', [UjianController::class, 'generateToken'])->name('ujian.generateToken');

    Route::get('/hasil-ujian', [HasilUjianController::class, 'index'])->name('hasil-ujian.index');
    Route::get('/hasil-ujian', [HasilUjianController::class, 'index'])->name('hasil-ujian.index');
    Route::get('/hasil-ujian/{id}', [HasilUjianController::class, 'detail'])->name('hasil-ujian.detail');
    Route::get('/hasil-ujian/data/{id}', [HasilUjianController::class, 'dataDetail'])->name('hasil-ujian.data');
    Route::get('/hasil-ujian/batalkan/{id}/{tes_id}', [HasilUjianController::class, 'batalkan'])->name('hasil-ujian.batalkan');

    Route::prefix('hasil_ujian')->group(function () {
        Route::get('/', [HasilUjianController::class, 'index'])->name('hasil_ujian.index'); // Menampilkan semua hasil ujian
        Route::get('/create', [HasilUjianController::class, 'create'])->name('hasil_ujian.create'); // Form tambah hasil ujian
        Route::post('/store', [HasilUjianController::class, 'store'])->name('hasil_ujian.store'); // Simpan hasil ujian baru
        Route::get('/{id}', [HasilUjianController::class, 'show'])->name('hasil_ujian.show'); // Menampilkan detail hasil ujian
        Route::get('/edit/{id}', [HasilUjianController::class, 'edit'])->name('hasil_ujian.edit'); // Form edit hasil ujian
        Route::put('/update/{id}', [HasilUjianController::class, 'update'])->name('hasil_ujian.update'); // Update hasil ujian
        Route::delete('/delete/{id}', [HasilUjianController::class, 'destroy'])->name('hasil_ujian.destroy'); // Hapus hasil ujian
    });





});

Route::middleware(['authuser'])->group(function () {
    Route::get('/dashboard-user', [DashboardController::class, 'dashboard_user'])->name('dashboard_user');  
    Route::get('/ujian',[UjianController::class, 'daftar_ujian'])->name('daftar_ujian');
    Route::get('/ikut_ujian',[IkutUjianController::class, 'ikuti_ujian'])->name('ikuti-ujian');
    Route::get('/konfirmasi-ujian', [UjianController::class, 'konfirmasi_ujian'])->name('konfirmasi_ujian');
    Route::get('/mulai-ujian', [UjianController::class, 'mulai_ujian'])->name('mulai_ujian');
    Route::post('/cek-token', [UjianController::class, 'cekToken'])->name('cek.token');
    
    Route::post('/ujian/submit', [UjianController::class, 'submitJawaban'])->name('submit_jawaban');
}); 
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




