<?php

use App\Models\ClassRooms;
use Illuminate\Http\Request;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\UserController;
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


// Route::get('classRoom', [ClassRoomController::class, 'index']);

Route::get('classRoom', [ClassroomController::class, 'index']);
Route::get('User', [UserController::class, 'index']);
