<?php

use App\Http\Controllers\ChangeprofileController;
use App\Models\ClassRooms;
use Illuminate\Http\Request;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\UserController as V1UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('classRoom', [ClassRoomController::class, 'index' ]);

Route::get('classroom', [ClassroomController::class, 'index']);
// Route::get('User', [UserController::class, 'index']);

Route::post('classRoomID/{id}', [ClassroomController::class, 'store']);


Route::prefix('v1')->group(function () {
    Route::post('user-login', [UserController::class, 'store']);
    Route::post('user-register', [UserController::class, 'register']);
    Route::put('user-profile/{id}', [UserController::class, 'update']);
    Route::post('user-ResetPassword', [UserController::class, 'ResetPassword']);

    // Route::post('login', [LoginController::class, 'store'])->name('login.store');
    // Route::post('register', [RegisterController::class, 'store']);
    // Route::put('change-profile/{id}', [ChangeprofileController::class, 'update']);
});


    // Route::post('login', [LoginController::class, 'store'])->name('login.store');





// Route::get('', [Controller::class, '']);
