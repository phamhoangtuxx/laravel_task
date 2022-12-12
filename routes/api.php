<?php

use App\Http\Controllers\ChangeprofileController;
use App\Models\ClassRooms;
use Illuminate\Http\Request;
use App\Http\Controllers\class_room\ClassroomController;

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
Route::prefix('class_room')->group(function () {
    Route::get('classroom-index', [ClassroomController::class, 'index']);
    Route::get('classroom-user', [ClassroomController::class, 'CreateUserClassroom']);
    Route::put('classroom-update/{id_classroom}', [ClassroomController::class, 'UpdateClassroom']);
    Route::delete('classroom-delete/{id_classroom}', [ClassroomController::class, 'DeleteClassroom']);
    Route::get('classroom-create-user', [ClassroomController::class, 'CreateUserClassroom']);
    Route::get('classroom-member', [ClassroomController::class, 'InviteMember']);

    Route::put('classroom-invite-member', [ClassroomController::class, 'confirmMember']); //đ
});

Route::prefix('v1')->group(function () {
    Route::post('user-login', [UserController::class, 'store']);
    Route::post('user-register', [UserController::class, 'register']);
    Route::put('user-profile/{id}', [UserController::class, 'update']);
    Route::post('user-ResetPassword', [UserController::class, 'ResetPassword']);
    Route::get('user-email-statics', [UserController::class, 'emailStatic']);

    Route::get('user-history-email', [UserController::class, 'historyEmail']);
    Route::get('user-static-sendmail/{id}', [UserController::class, 'staticSendmail']);
    Route::delete('user-remove-history/{user_id}', [UserController::class, 'removeHistory']);
    Route::get('user-total-sendmail', [UserController::class, 'totalSendmail']);
    Route::get('user-delete-user/{id}', [UserController::class, 'deleteUser']);
});


    // Route::post('login', [LoginController::class, 'store'])->name('login.store');





// Route::get('', [Controller::class, '']);
