<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MenuController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::get('settings', [SettingController::class, 'index']);
    Route::post('settings', [SettingController::class, 'update']);

    Route::get('profile', [ProfileController::class, 'index']);
    Route::put('profile', [ProfileController::class, 'update']);

    Route::resource('menu', MenuController::class);
    });



Route::post("login",[UserController::class,'login']);
Route::post("register",[UserController::class, 'register']);

