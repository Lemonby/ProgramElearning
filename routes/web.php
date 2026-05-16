<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumpulanTugasController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Middleware\RedirectIfRole;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', RedirectIfRole::class])->name('dashboard');

Route::get('/dashboard/member', function () {
    return view('DashboardMember');
})->middleware(['auth', 'verified'])->name('dashboard.member');

Route::get('/dashboard/mentor', function () {
    return view('DashboardMentor');
})->middleware(['auth', 'verified'])->name('dashboard.mentor');

Route::middleware('auth')->group(function () { 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman form test
Route::get('/form-pengumpulan-tugas', function () {
    return view('TestKirimEmail');
})->name('form-pengumpulan-tugas');

// Proses submit untuk kirim email
Route::post('/pengumpulan-tugas', [PengumpulanTugasController::class, 'kirimEmailPengumpulanTugas'])->name('pengumpulan_tugas.store'); // nanti bakal ganti function pakai "PengumpulanTugasController.simpanTugas"

require __DIR__.'/auth.php';
