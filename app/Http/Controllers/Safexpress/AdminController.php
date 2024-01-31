<?php

namespace App\Http\Controllers\Safexpress;
use App\Http\Controllers\Controller;

use App\Models\BDirector;
use App\Models\Menu;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


     private function getAdminMenu()
     {
        $app_id = 2;
        $menu_tag = "SLIADMIN";

        $menu = Menu::with(['submenus' => function ($query) use ($app_id, $menu_tag) {
                $query->where('is_active', 1)
                      ->where('app_id', $app_id)
                      ->where('menu_tag', $menu_tag)
                      ->orderBy('sort_order', 'ASC');
            }])
            ->where('is_active', 1)
            ->where('app_id', $app_id)
            ->where('menu_tag', $menu_tag)
            ->where('parent_id', 0)
            ->orderBy('sort_order', 'ASC')
            ->get();

        return $menu;
     }

    public function index()
    {
        $adminmenu = $this->getAdminMenu();
        $title ="Dasboard";
         return view('admin.safexpress.dashboard',[
            'title'=> $title
         ],compact('adminmenu'));



    }

    public function activity()
    {
        $title ="Activity";
        $adminmenu = $this->getAdminMenu();
        return view('admin.safexpress.activity')->with(['title'=>$title,'adminmenu'=>$adminmenu]);
    }

    public function dashboard()
    {

        $adminmenu = $this->getAdminMenu();
        //dd($adminmenu);
        $title ="Dasboard";
        $user = User::count();
        $mancom = BDirector::count();
        return view('admin.safexpress.dashboard', compact(['title','user','mancom','adminmenu']));
    }

}
