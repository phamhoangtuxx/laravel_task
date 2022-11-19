<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SuccessController;
use GrahamCampbell\ResultType\Success;
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

    // return view('welcome');
});

// Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');
Route::get('success', [SuccessController::class, 'index'])->name('success.index');

    // Route::get('views/users/login', [LoginController::class, 'login'])->name('login');
