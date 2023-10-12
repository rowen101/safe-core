<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TechRecomController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ClassesController;
use App\Http\Controllers\API\SectionController;

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
Route::group(['prefix' => 'books', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\API\BookController::class, 'index']);
    Route::post('add', [App\Http\Controllers\API\BookController::class, 'add']);
    Route::get('edit/{id}', [App\Http\Controllers\API\BookController::class, 'edit']);
    Route::post('update/{id}', [App\Http\Controllers\API\BookController::class, 'update']);
    Route::delete('delete/{id}', [App\Http\Controllers\API\BookController::class, 'delete']);
});

Route::group(['prefix' => 'tech', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('recomm',TechRecomController::class);
});

Route::group(['prefix' => 'school', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/students', [App\Http\Controllers\API\StudentController::class, 'index']);

    Route::get('/classes', [App\Http\Controllers\API\ClassesController::class, 'index']);
    Route::get('/sections', [App\Http\Controllers\API\SectionController::class, 'index']);

    Route::delete('student/delete/{student}', [App\Http\Controllers\API\StudentController::class, 'destroy']);
    Route::delete('students/massDestroy/{students}', [App\Http\Controllers\API\StudentController::class, 'massDestroy']);

    Route::get('students/export/{students}', [App\Http\Controllers\API\StudentController::class, 'export']);

});
