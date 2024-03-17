<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::group(
    ['middleware' => 'api'
], function ($router){
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('images', [ImageController::class, 'postImage']);
    Route::delete('images/{imageId}', [ImageController::class, 'deleteImage']);
});

Route::get('images', [ImageController::class, 'getImages']);
Route::get('users/{userId}/images', [ImageController::class, 'getImagesByUserId']);
Route::get('images/{imageId}', [ImageController::class, 'getImageById']);

Route::post('/users', [UserController::class, 'createUser']);

