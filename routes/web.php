<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;


Route::resource('materials', MaterialController::class);

Route::resource('meetings', MeetingController::class);

Route::resource('attendances', AttendanceController::class);

Route::get('/my-attendance',
    [AttendanceController::class, 'myAttendance']);

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

// Halaman form test
Route::get('/form-pengumpulan-tugas', function () {
    return view('TestKirimEmail');
})->name('form-pengumpulan-tugas');

// Proses submit untuk kirim email
Route::post('/pengumpulan-tugas', [PengumpulanTugasController::class, 'kirimEmailPengumpulanTugas'])->name('pengumpulan_tugas.store'); // nanti bakal ganti function pakai "PengumpulanTugasController.simpanTugas"

// Assignment Routes (Mentor)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('assignment', AssignmentController::class);
});

// Submission Routes (Member)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/submission', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submission/create/{assignmentId}', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submission', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submission/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::get('/submission/{submissionId}/download', [SubmissionController::class, 'download'])->name('submissions.download');
    Route::get('/submission/{submissionId}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submission/{submissionId}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submission/{submissionId}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
});

require __DIR__.'/auth.php';