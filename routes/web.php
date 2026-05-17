<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Middleware\RedirectIfRole;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', RedirectIfRole::class])->name('dashboard');

Route::get('/dashboard/member', function () {
    return view('dashboard.member');
})->middleware(['auth', 'verified'])->name('dashboard.member');

Route::get('/dashboard/mentor', function () {
    return view('dashboard.mentor');
})->middleware(['auth', 'verified'])->name('dashboard.mentor');

Route::middleware('auth')->group(function () { 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman form test (legacy - untuk testing saja)
Route::get('/form-pengumpulan-tugas', [PengumpulanTugasController::class, 'index'])
    ->middleware('auth')
    ->name('form-pengumpulan-tugas');

// Halaman pengumpulan tugas (show assignments)
Route::get('/submissions', [PengumpulanTugasController::class, 'show'])
    ->middleware('auth')
    ->name('submissions.index');

// Proses submit untuk kirim email
Route::post('/submissions', [PengumpulanTugasController::class, 'simpanTugas'])
    ->middleware('auth')
    ->name('submissions.store');

// Assignment Routes (Mentor)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('assignment', AssignmentController::class);
});

require __DIR__.'/auth.php';
