<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
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

Route::group(['middleware' => 'api'], function () {
    // user login and registger in prefix 'auth'
    Route::group(['prefix' => 'auth'], function () {
        // login
        Route::post('login', [AuthController::class, 'login']);
        // register
        Route::post('register', [AuthController::class, 'register']);
    });

    // authenticate user logout in prefix 'auth'
    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'auth'], function () {
        // logout
        Route::get('logout', [AuthController::class, 'logout']);
    });

    // authenticate user image in prefix 'image'
    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'image'], function () {
        // get user all image
        Route::post('images', [ImageController::class, 'get_images']);
        // upload image
        Route::post('upload-image', [ImageController::class, 'upload_image']);
    });
});
