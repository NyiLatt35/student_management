<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RollCallController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ModulesController;

use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('admin.home');
// });
// This route is for the admin home page
Route::prefix('admin')->group(function () {
   Route::get('home', [PagesController::class, 'index'])->name('admin.home');
    Route::resource('student', (StudentController::class))->names([
        'index' => 'admin.student.index',
        'create' => 'admin.student.create',
        'store' => 'admin.student.store',
        'show' => 'admin.student.show',
        'edit' => 'admin.student.edit',
        'update' => 'admin.student.update',
        'destroy' => 'admin.student.destroy',
    ]);
    Route::resource('rollcall', (RollCallController::class))->names([
        'index' => 'admin.rollcall.index',
        'create' => 'admin.rollcall.create',
        'store' => 'admin.rollcall.store',
        'show' => 'admin.rollcall.show',
        'edit' => 'admin.rollcall.edit',
        'update' => 'admin.rollcall.update',
        'destroy' => 'admin.rollcall.destroy',
    ]);
    Route::get('attendance/studentAttendanceReport', [RollCallController::class, 'studentAttendanceReport'])->name('admin.rollcall.studentAttendanceReport');
    Route::resource('subject', (SubjectController::class))->names([
        'index' => 'admin.subject.index',
        'create' => 'admin.subject.create',
        'store' => 'admin.subject.store',
        'show' => 'admin.subject.show',
        'edit' => 'admin.subject.edit',
        'update' => 'admin.subject.update',
        'destroy' => 'admin.subject.destroy',
    ]);
    Route::resource('teacher', App\Http\Controllers\TeacherController::class)->names([
        'index' => 'admin.teacher.index',
        'create' => 'admin.teacher.create',
        'store' => 'admin.teacher.store',
        'show' => 'admin.teacher.show',
        'edit' => 'admin.teacher.edit',
        'update' => 'admin.teacher.update',
        'destroy' => 'admin.teacher.destroy',
    ]);
    Route::get('lesson', [ModulesController::class, 'index'])->name('admin.lesson.index');
    Route::post('lesson/store', [ModulesController::class, 'store'])->name('admin.lesson.store');
    Route::get('lesson/edit/{module}', [ModulesController::class, 'edit'])->name('admin.lesson.edit');

});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');