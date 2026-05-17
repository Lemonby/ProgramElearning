<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AttendanceController;

//material
Route::resource('materials', MaterialController::class);
Route::resource('meetings', MeetingController::class);
Route::resource('attendances', AttendanceController::class);

//kehadiran
Route::get('/my-attendance',
    [AttendanceController::class, 'myAttendance']);

// Halaman form test
Route::get('/test-pengumpulan-tugas', function () {
    return view('TestKirimEmail');
});

// Proses submit untuk kirim email
Route::post('/test-pengumpulan-tugas', [PengumpulanTugasController::class, 'kirimEmailPengumpulanTugas'])->name('pengumpulan_tugas.store');