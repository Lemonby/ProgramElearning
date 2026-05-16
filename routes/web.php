<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumpulanTugasController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman form test
Route::get('/test-pengumpulan-tugas', function () {
    return view('TestKirimEmail');
});

// Proses submit untuk kirim email
Route::post('/test-pengumpulan-tugas', [PengumpulanTugasController::class, 'kirimEmailPengumpulanTugas'])->name('pengumpulan_tugas.store');

// name('pengumpulan_tugas.store'); adalah nama route yang bisa digunakan untuk generate URL atau redirect ke route ini, misalnya: route('pengumpulan_tugas.store') atau redirect()->route('pengumpulan_tugas.store')