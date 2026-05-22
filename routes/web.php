<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MemberMaterialController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\MemberDashboardController;


Route::resource('materials', MaterialController::class)->middleware(['auth', 'verified', 'is_mentor']);

Route::resource('meetings', MeetingController::class)->middleware(['auth', 'verified', 'is_mentor']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('attendances', AttendanceController::class)->middleware('is_mentor');
    Route::get('/attendances/{meetingId}/members', [AttendanceController::class, 'getMeetingMembers'])->name('attendances.getMeetingMembers');
});

// Member Attendance - View own attendance history
Route::middleware(['auth', 'verified', 'is_member'])->group(function () {
    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendances.myAttendance');
});

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Middleware\RedirectIfRole;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', RedirectIfRole::class])->name('dashboard');

Route::get('/dashboard/member', [MemberDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'is_member'])
    ->name('dashboard.member');

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
Route::middleware(['auth', 'verified', 'is_mentor'])->group(function () {
    Route::resource('assignment', AssignmentController::class);
});

// Submission Routes (Member)
Route::middleware(['auth', 'verified', 'is_member'])->group(function () {
    Route::get('/submission', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submission/create/{assignmentId}', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submission', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submission/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::get('/submission/{submissionId}/download', [SubmissionController::class, 'download'])->name('submissions.download');
    Route::get('/submission/{submissionId}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submission/{submissionId}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submission/{submissionId}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
});

// Member Materials Routes
Route::middleware(['auth', 'verified', 'is_member'])->group(function () {
    Route::get('/materi', [MemberMaterialController::class, 'index'])->name('member-materials.index');
    Route::get('/materi/{material}', [MemberMaterialController::class, 'show'])->name('member-materials.show');
    Route::get('/materi/{material}/download', [MemberMaterialController::class, 'download'])->name('member-materials.download');
});

require __DIR__.'/auth.php';