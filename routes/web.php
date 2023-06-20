<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentController::class, 'index'])->name('student.index');
Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::get('/student/edit/{id}', [StudentController::class, 'edit']);
Route::put('/student/update', [StudentController::class, 'update'])->name('student.update');
