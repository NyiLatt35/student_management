<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RollCallController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TeacherController;
// use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'home'])->name('home');

// Route::get('/home', [PagesController::class, 'home'])->name('home');
// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');

});

Route::get('/show/information', [PagesController::class, 'userDashboard'])->name('user.dashboard');


// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth'])->group(function () {
    // Route::get('dashboard', [PagesController::class, 'index'])->name('dashboard');
    Route::get('user/dashboard', [PagesController::class, 'userDashboard'])->name('user.dashboard');

    Route::resource('student', StudentController::class)->names('student');
    Route::resource('rollcall', RollCallController::class)->names('rollcall');
    Route::get('attendance/studentAttendanceReport', [RollCallController::class, 'studentAttendanceReport'])
        ->name('rollcall.studentAttendanceReport');

    Route::resource('subject', SubjectController::class)->names('subject');
    Route::resource('teacher', TeacherController::class)->names('teacher');

    // Lessons´
    Route::get('lesson', [ModulesController::class, 'index'])->name('lesson.index');
    Route::post('lesson/store', [ModulesController::class, 'store'])->name('lesson.store');
    Route::get('lesson/edit/{module}', [ModulesController::class, 'edit'])->name('lesson.edit');
    Route::put('lesson/update/{module}', [ModulesController::class, 'update'])->name('lesson.update');

    // Exams
    Route::get('exam', [ExamController::class, 'index'])->name('exam.index');
    Route::get('exam/start', [ExamController::class, 'create'])->name('exam.start');
    Route::post('exam/store', [ExamController::class, 'store'])->name('exam.store');
    Route::get('exam/edit/{id}', [ExamController::class, 'edit'])->name('exam.edit');
    Route::get('exam/detail/{id}', [ExamController::class, 'show'])->name('exam.detail');
    Route::put('exam/update/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::delete('exam/destroy/{id}', [ExamController::class, 'destroy'])->name('exam.destroy');

    // Results
    Route::get('exam/result', [ResultController::class, 'index'])->name('exam.result');
    Route::post('exam/result/store', [ResultController::class, 'store'])->name('exam.result.store');
    Route::get('exam/result/edit/{id}', [ResultController::class, 'edit'])->name('exam.result.edit');
    Route::put('exam/result/update/{id}', [ResultController::class, 'update'])->name('exam.result.update');
    Route::get('exam/result/detail/{id}', [ResultController::class, 'show'])->name('exam.result.details');
    Route::delete('exam/result/destroy/{id}', [ResultController::class, 'destroy'])->name('exam.result.destroy');
});

// =======================
// TEACHER ROUTES
// =======================
// Route::middleware(['auth', 'teacher'])->prefix('teacher')->group(function () {
//     Route::get('dashboard', [PagesController::class, 'teacherDashboard'])->name('teacher.dashboard');
// });

// =======================
// USER ROUTES (students)
// =======================
// Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
//     Route::get('dashboard', [PagesController::class, 'userDashboard'])->name('user.dashboard');
// });

// Default authentication routes
Auth::routes();
