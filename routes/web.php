<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TechController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SafexpressController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Safexpress\BDController;

use App\Http\Controllers\Admin\MenuListController;
use App\Http\Controllers\Admin\UserMenuController;
use App\Http\Controllers\Safexpres\PageController;
use App\Http\Controllers\Admin\VirtualASController;
use App\Http\Controllers\Safexpress\PostController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\MyClosePrioController;
use App\Http\Controllers\Safexpress\BranchController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Safexpress\GalleryController;
use App\Http\Controllers\Safexpress\WebUserController;
use App\Http\Controllers\Admin\DashboardStatController;
use App\Http\Controllers\Safexpress\CarouselController;
use App\Http\Controllers\Safexpress\SafeMenuController;
use App\Http\Controllers\Safexpress\CategorieController;
use App\Http\Controllers\Admin\AppointmentStatusController;
use App\Http\Controllers\Safexpress\SafeApplicationController;
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

// Route::get('/', function () {
//     return view('safexpress.layouts.app');
// });
Route::get('/app', [App\Http\Controllers\AppController::class, 'index'])->name('app');


Route::get('/', [App\Http\Controllers\Safexpress\PagesController::class, 'index'])->name('pages.index');
Route::get('/about', [App\Http\Controllers\Safexpress\PagesController::class, 'about'])->name('about');
Route::get('/services', [App\Http\Controllers\Safexpress\PagesController::class, 'services'])->name('services');
Route::get('/teams', [App\Http\Controllers\Safexpress\PagesController::class, 'teams'])->name('teams');
Route::get('/contact', [App\Http\Controllers\Safexpress\PagesController::class, 'contact'])->name('contact');
Route::get('/branch', [App\Http\Controllers\Safexpress\PagesController::class, 'branch'])->name('branch');
Route::post('/filter-branches', [App\Http\Controllers\Safexpress\PagesController::class, 'filterBranches'])->name('pages.filtered');
Route::get('/blog', [App\Http\Controllers\Safexpress\PagesController::class, 'blog'])->name('blog');
Route::get('/blog-details/{id}', [App\Http\Controllers\Safexpress\PagesController::class, 'blogid'])->name('blog-select');
Route::get('/warehouse-management', [App\Http\Controllers\Safexpress\PagesController::class, 'warehouse']);
Route::get('/transport-services', [App\Http\Controllers\Safexpress\PagesController::class, 'transport']);
Route::get('/other-services', [App\Http\Controllers\Safexpress\PagesController::class, 'other']);

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });

Route::group(['middleware' => ['web']], function () {
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
    Route::post('/api/tech-getaction', [TechController::class, 'getAction']);

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

     Route::post('/api/changethemes',[VirtualASController::class, 'changethemes']);
     Route::get('/api/filter-vsc',[VirtualASController::class,'vscfilter']);
     Route::resource('/api/myvsc', VirtualASController::class);
    //my close prio
    Route::resource('/api/mycloseprio', MyClosePrioController::class);
    Route::get('/api/filter-closeprio',[ MyClosePrioController::class,'FilterClosePrio']);

    //site name
    Route::resource('/api/site', SiteController::class);

    //menu controller
    Route::resource('/api/menulist',MenuListController::class);
    Route::get('/api/GetParentId',[MenuListController::class,'GetParentId']);

    Route::resource('/api/menu', MenuController::class);

    //menu username
    Route::resource('/api/usermenu', UserMenuController::class);
    Route::get('/api/usermenu/retrieve/{id}', [UserMenuController::class, 'retrieveUserMenu']);


    Route::get('/api/chart',[DashboardStatController::class, 'getChartData']);

    Route::resource('/api/notifications', NotificationController::class);
    Route::put('/api/notifications/{id}/markAsRead',[NotificationController::class, 'markAsRead']);

    Auth::routes();
    //Safexpress
Route::get('/app/SLI', [App\Http\Controllers\Safexpress\AdminController::class, 'index'])->name('admin.safexpress.index');
Route::get('/app/SLI/activity', [App\Http\Controllers\Safexpress\AdminController::class, 'activity'])->name('admin.safexpress.activity');
//Route::get('/app/SLI/dashboard', [App\Http\Controllers\Safexpress\AdminController::class, 'dashboard'])->name('admin.safexpress.dashboard');
Route::resource('/app/SLI/user',WebUserController::class);
Route::resource('/app/SLI/application',SafeApplicationController::class);
Route::resource('/app/SLI/menu',SafeMenuController::class);
Route::resource('/app/SLI/setting',SettingController::class);
Route::resource('/app/SLI/gallery',GalleryController::class);
Route::resource('/app/SLI/post',PostController::class);
Route::put('/app/SLI/post-publish/{id}',[App\Http\Controllers\Safexpress\PostController::class,'publish']);
Route::resource('/SLI/categorie', CategorieController::class);
//Route::get('/admin/gallery/{id}/image', [App\Http\Controllers\GalleryController::class, 'viewimage'])->name('admin.gallery.image');
Route::post('/app/SLI/gallery/image/{id}', [App\Http\Controllers\Safexpress\GalleryController::class, 'addimage']);
Route::resource('/app/SLI/branch', BranchController::class);
Route::get('/file-resize'   , [App\Http\Controllers\Safexpress\ResizeController::class, 'index']);
Route::post('/resize-file', [App\Http\Controllers\Safexpress\ResizeController::class, 'resizeImage'])->name('resizeImage');
Route::post('dropzone/upload', [App\Http\Controllers\Safexpress\GalleryController::class,'upload'])->name('dropzone.upload');
Route::get('dropzone/fetch/{id}/image', [App\Http\Controllers\Safexpress\GalleryController::class,'fetch'])->name('dropzone.fetch');
Route::get('dropzone/delete', [App\Http\Controllers\Safexpress\GalleryController::class,'delete'])->name('dropzone.delete');
Route::get('/app/SLI/menuapp',[App\Http\Controllers\Safexpress\SafeMenuController::class,'menuapp']);
Route::resource('/app/SLI/bdirector',BDController::class);
Route::resource('/app/SLI/usermenu',UserMenuController::class);
Route::resource('/app/SLI/client',ClientController::class);
Route::get('/app/SLI/client/fetch',[App\Http\Controllers\Safexpress\ClientController::class,'fetch'])->name('client.fetch');
Route::post('/app/SLI/client/filename',[App\Http\Controllers\Safexpress\ClientController::class,'clientfilename'])->name('client.filename');
Route::resource('/app/SLI/carousel', CarouselController::class);
Route::post('/app/SLI/carousel/filename',[App\Http\Controllers\Safexpress\CarouselController::class,'carouselfilename'])->name('carousel.filename');
Route::get('/dropzone',[App\Http\Controllers\Safexpress\DropzoneController::class,'index']);
Route::get('dropzone/fetch/image', [App\Http\Controllers\Safexpress\DropzoneController::class,'fetch'])->name('dropzones.fetch');
Route::post('dropzones/upload', [App\Http\Controllers\Safexpress\DropzoneController::class,'upload'])->name('dropzones.upload');

});
Route::get('{view}', ApplicationController::class)->where('view', '(.*)')->middleware('auth');




