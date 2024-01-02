<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TechController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VirtualASController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\MyClosePrioController;

use App\Http\Controllers\Admin\DashboardStatController;
use App\Http\Controllers\Admin\AppointmentStatusController;
use App\Http\Controllers\Admin\UserMenuController;

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
    return view('welcome');
});

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });




Route::middleware('auth')->group(function () {
    Route::get('stats/appointments', [DashboardStatController::class, 'appointments']);
    Route::get('stats/users', [DashboardStatController::class, 'users']);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::patch('users/{user}/change-role', [UserController::class, 'changeRole']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destory']);
    Route::delete('users', [UserController::class, 'bulkDelete']);
    Route::get('users/userlist', [UserController::class, 'listuser']);
 Route::patch('users/{user}/change-sitehead', [UserController::class, 'changesitehead']);
    //client
    Route::get('view-clients', [ClientController::class,'viewclient']);
    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::put('clients/{client}', [ClientController::class, 'update']);
    Route::delete('clients/{client}', [ClientController::class, 'destory']);
    Route::delete('clients', [ClientController::class, 'bulkDelete']);

    //appointments
    Route::get('appointment-status', [AppointmentStatusController::class, 'getStatusWithCount']);
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::post('appointments/create', [AppointmentController::class, 'store']);
    Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::put('appointments/{appointment}/edit', [AppointmentController::class, 'update']);
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy']);
    //setting
    // Route::get('settings', [SettingController::class, 'index']);
    // Route::post('settings', [SettingController::class, 'update']);

    // Route::get('profile', [ProfileController::class, 'index']);
    // Route::put('profile', [ProfileController::class, 'update']);
    Route::post('upload-profile-image', [ProfileController::class, 'uploadImage']);
    Route::post('change-user-password', [ProfileController::class, 'changePassword']);

    Route::resource('tech-recommendations', TechController::class);
    Route::delete('tech-recommendations', [TechController::class, 'bulkDelete']);

    //tasks controller
    Route::resource('dailytask', TaskController::class);
    Route::put('dailytask/onhandler/{id}', [TaskController::class, 'onhandler']);
    Route::post('dailytask/addnewTask',[TaskController::class, 'addTask']);
    Route::get('dailytask/{id}/tasks',[TaskController::class, 'getTask']);
    Route::put('dailytask/drop/{id}',[TaskController::class, 'drop']);
    Route::delete('dailytask/deleteTask/{id}',[TaskController::class, 'deleteTask']);
    Route::get('dailytask/filter-taskdate',[TaskController::class,'FilterTaskdate']);
    Route::get('getsite',[TaskController::class,'getSite']);
    //myvsc controller
    Route::post('filter-vsc',[VirtualASController::class,'FilterVSC']);
    Route::resource('myvsc', VirtualASController::class);


    //my close prio
    Route::resource('mycloseprio', MyClosePrioController::class);

    //site name
    Route::resource('site', SiteController::class);

    //menu controller
    Route::resource('menu', MenuController::class);

    //menu username
    Route::resource('usermenu', UserMenuController::class);
    Route::get('usermenu/retrieve/{id}', [UserMenuController::class, 'retrieveUserMenu']);
});

Route::get('{view}', ApplicationController::class)->where('view', '(.*)')->middleware('auth');


Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
