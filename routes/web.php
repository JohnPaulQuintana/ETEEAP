<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckingDocumentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
})->name('welcome');

// Route::get('/', [GuessController::class, 'index'])->name('index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['checkUserRole:0','auth','verified'])->group(function(){
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user-dashboard');

    Route::post('/store', [DocumentController::class, 'store'])->name('store');

    Route::get('/history/{id}', [UserController::class, 'ajaxCallHistory'])->name('ajax.history');
});

Route::middleware(['checkUserRole:1','auth','verified'])->group(function(){
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::get('/admin-dashboard/accepted', [AdminController::class, 'accepted'])->name('admin-dashboard.accepted');
    Route::get('/admin-dashboard/declined', [AdminController::class, 'declined'])->name('admin-dashboard.declined');

    Route::get('/department', [AdminController::class, 'department'])->name('department');
    Route::post('/department-add', [DepartmentController::class, 'index'])->name('department.store');
    Route::post('/department-user', [DepartmentController::class, 'user'])->name('department.user');

    Route::get('/documents/{id}', [AdminController::class, 'ajaxCall'])->name('ajax');
    Route::get('/documents-update/{id}', [AdminController::class, 'ajaxCallUpdate'])->name('ajax.update');

    Route::post('/accept', [AdminController::class, 'acceptDocs'])->name('acceptDocs');
    Route::post('/checkedDocument', [CheckingDocumentController::class, 'checkedDocument'])->name('checkedDocument');

    Route::post('/interview', [InterviewController::class, 'setUpInterview'])->name('interview');
});

Route::middleware(['checkUserRole:2','auth','verified'])->group(function(){
    Route::get('/department-dashboard',[DepartmentController::class, 'dashboard'])->name('department.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
