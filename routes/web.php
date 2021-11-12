<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/roles', [App\Http\Controllers\HomeController::class, 'index'])->name('roles');
Route::get('/userslist', [App\Http\Controllers\HomeController::class, 'index'])->name('userslist');
Route::get('/expense-category', [App\Http\Controllers\HomeController::class, 'index'])->name('expensecategory');
Route::get('/expenses', [App\Http\Controllers\HomeController::class, 'index'])->name('expenses');
Route::get('/reset-password', [App\Http\Controllers\HomeController::class, 'resetPassword'])->name('resetpassword');
Route::post('/store-new-pw', [App\Http\Controllers\HomeController::class, 'storeNewPassword'])->name('store-new-pw');
Route::post('/save-user-expense', [App\Http\Controllers\HomeController::class, 'saveUserExpense'])->name('store-new-pw');
Route::post('/save-roles', [App\Http\Controllers\HomeController::class, 'saveRole']);
Route::post('/save-users', [App\Http\Controllers\HomeController::class, 'saveUsers']);
Route::post('/save-expense-category', [App\Http\Controllers\HomeController::class, 'saveExpenseCategory']);
Route::post('/save-expenses', [App\Http\Controllers\HomeController::class, 'saveExpenses']);
Route::post('/delete-data', [App\Http\Controllers\HomeController::class, 'deleteData']);

