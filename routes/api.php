<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("login",[UserController::class,'login']);
Route::post("register",[App\Http\Controllers\API\UserController::class, 'register']);
Route::post('logout', [App\Http\Controllers\API\UserController::class, 'logout'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'api', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('add', [App\Http\Controllers\API\BookController::class, 'add']);
    Route::get('edit/{id}', [App\Http\Controllers\API\BookController::class, 'edit']);
    Route::post('update/{id}', [App\Http\Controllers\API\BookController::class, 'update']);
    Route::delete('delete/{id}', [App\Http\Controllers\API\BookController::class, 'delete']);
});
