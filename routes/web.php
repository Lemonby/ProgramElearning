<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\MaterialController;

//material
Route::resource('materials', MaterialController::class);

// Halaman form test
Route::get('/test-pengumpulan-tugas', function () {
    return view('TestKirimEmail');
});

// Proses submit untuk kirim email
Route::post('/test-pengumpulan-tugas', [PengumpulanTugasController::class, 'kirimEmailPengumpulanTugas'])->name('pengumpulan_tugas.store');