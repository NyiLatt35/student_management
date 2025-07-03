<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RollCallController;

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
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');