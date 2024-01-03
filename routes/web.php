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
    Route::get('/api/stats/appointments', [DashboardStatController::class, 'appointments']);
    Route::get('/api/stats/users', [DashboardStatController::class, 'users']);

    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::patch('/api/users/{user}/change-role', [UserController::class, 'changeRole']);
    Route::put('/api/users/{user}', [UserController::class, 'update']);
    Route::delete('/api/users/{user}', [UserController::class, 'destory']);
    Route::delete('/api/users', [UserController::class, 'bulkDelete']);
    Route::get('/api/users/userlist', [UserController::class, 'listuser']);
 Route::patch('/api/users/{user}/change-sitehead', [UserController::class, 'changesitehead']);
    //client
    Route::get('/api/view-clients', [ClientController::class,'viewclient']);
    Route::get('/api/clients', [ClientController::class, 'index']);
    Route::post('/api/clients', [ClientController::class, 'store']);
    Route::put('/api/clients/{client}', [ClientController::class, 'update']);
    Route::delete('/api/clients/{client}', [ClientController::class, 'destory']);
    Route::delete('/api/clients', [ClientController::class, 'bulkDelete']);

    //appointments
    Route::get('/api/appointment-status', [AppointmentStatusController::class, 'getStatusWithCount']);
    Route::get('/api/appointments', [AppointmentController::class, 'index']);
    Route::post('/api/appointments/create', [AppointmentController::class, 'store']);
    Route::get('/api/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::put('/api/appointments/{appointment}/edit', [AppointmentController::class, 'update']);
    Route::delete('/api/appointments/{appointment}', [AppointmentController::class, 'destroy']);
    //setting
    Route::get('/api/settings', [SettingController::class, 'index']);
    Route::post('/api/settings', [SettingController::class, 'update']);

    Route::get('/api/profile', [ProfileController::class, 'index']);
    Route::put('/api/profile', [ProfileController::class, 'update']);
    Route::post('/api/upload-profile-image', [ProfileController::class, 'uploadImage']);
    Route::post('/api/change-user-password', [ProfileController::class, 'changePassword']);

    Route::resource('/api/tech-recommendations', TechController::class);
    Route::delete('/api/tech-recommendations', [TechController::class, 'bulkDelete']);

    //tasks controller
    Route::resource('/api/dailytask', TaskController::class);
    Route::put('/api/dailytask/onhandler/{id}', [TaskController::class, 'onhandler']);
    Route::post('/api/dailytask/addnewTask',[TaskController::class, 'addTask']);
    Route::get('/api/dailytask/{id}/tasks',[TaskController::class, 'getTask']);
    Route::put('/api/dailytask/drop/{id}',[TaskController::class, 'drop']);
    Route::delete('/api/dailytask/deleteTask/{id}',[TaskController::class, 'deleteTask']);
    Route::get('/api/dailytask/filter-taskdate',[TaskController::class,'FilterTaskdate']);
    Route::get('/api/getsite',[TaskController::class,'getSite']);
    //myvsc controller
    Route::post('/api/filter-vsc',[VirtualASController::class,'FilterVSC']);
    Route::resource('/api/myvsc', VirtualASController::class);


    //my close prio
    Route::resource('/api/mycloseprio', MyClosePrioController::class);

    //site name
    Route::resource('/api/site', SiteController::class);

    //menu controller
    Route::resource('/api/menu', MenuController::class);

    //menu username
    Route::resource('/api/usermenu', UserMenuController::class);
    Route::get('/api/usermenu/retrieve/{id}', [UserMenuController::class, 'retrieveUserMenu']);
});

Route::get('{view}', ApplicationController::class)->where('view', '(.*)')->middleware('auth');


// Route::get('/{any?}', function () {
//     return view('welcome');
// })->where('any', '.*');


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
