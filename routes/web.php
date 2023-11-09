<?php

use App\Http\Controllers\DesignationController;
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

Route::get('/', [UserController::class, 'home']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/designation',DesignationController::class);
Route::post('/change_status', [DesignationController::class, 'changeStatus'])->name('change.status');
Route::get('designation/show/{id}', [DesignationController::class, 'show'])->name('designation.show');
Route::post('/designation/edit', [DesignationController::class,'edit'])->name('designation.edit');


Route::get('list_user', [UserController::class, 'index'])->name('list.user');
Route::get('get-designation', [UserController::class, 'index'])->name('get.designation');
Route::get('create_user', [UserController::class,'create_user'])->name('user.create');
Route::post('store_user', [UserController::class,'store_user'])->name('store.user');
Route::get('user/edit/{id}', [UserController::class,'edit_user'])->name('user.edit');
Route::post('edit_user', [UserController::class,'store_editUser'])->name('store.edituser');

Auth::routes();
