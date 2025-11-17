<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[AuthController::class ,'login'])->name('login');

Route::middleware('auth:api')->group(function(){

    Route::resource('user',UserController::class);
    Route::resource('booking',BookingController::class);
    Route::resource('serviceType',ServiceTypeController::class);

    Route::post('assign-role-to-user',[UserController::class, 'assignRoleToUser']);
    Route::post('remove-role-from-user',[UserController::class, 'removeRoleFromUser']);
});
