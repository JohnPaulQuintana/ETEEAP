<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckingDocumentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EvaluatedController;
use App\Http\Controllers\ForwardToDeptController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReuploadDocumentController;
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

    Route::get('/timeline/{id}', [UserController::class, 'timeline'])->name('timeline');

    Route::post('/reupload', [ReuploadDocumentController::class, 'reupload'])->name('reupload');

    Route::post('/notify', [NotifyController::class, 'notify'])->name('notify');
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

    Route::post('/delete-department', [AdminController::class, 'delete'])->name('admin.delete');
    Route::get('/user-info', [AdminController::class, 'info'])->name('info');
    Route::post('/user-update', [AdminController::class, 'update'])->name('user.update');
    Route::post('/user-delete', [AdminController::class, 'deleteUser'])->name('user.delete');

    Route::get('/admin-update-status/{id}', [AdminController::class, 'ajaxCallUpdate'])->name('update');
    Route::get('/admin-forward',[AdminController::class, 'departmentUser'])->name('departmentUser');
    Route::post('/admin-outgoing',[AdminController::class, 'outgoing'])->name('admin.outgoing');
});

Route::middleware(['checkUserRole:2','auth','verified'])->group(function(){
    Route::get('/department-dashboard',[DepartmentController::class, 'dashboard'])->name('department.dashboard');
    Route::post('/evaluate', [CheckingDocumentController::class, 'checkedDocument'])->name('evaluate');   
    Route::get('/update-status/{id}', [DepartmentController::class, 'ajaxCallUpdate'])->name('update');

    Route::get('/forward',[DepartmentController::class, 'departmentUser'])->name('departmentUser');
    Route::post('/outgoing',[DepartmentController::class, 'outgoing'])->name('outgoing');

    Route::get('/evaluated', [EvaluatedController::class, 'evaluated'])->name('evaluated');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');  
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
