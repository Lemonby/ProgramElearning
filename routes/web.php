<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AttendanceController;

Route::resource('materials', MaterialController::class);

Route::resource('meetings', MeetingController::class);

Route::resource('attendances', AttendanceController::class);

Route::get('/my-attendance',
    [AttendanceController::class, 'myAttendance']);