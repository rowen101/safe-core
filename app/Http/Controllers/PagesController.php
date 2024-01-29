<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Menu;
use App\Models\Posts;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Setting;
use App\Models\Carousel;
use App\Models\BDirector;
use Illuminate\Http\Request;
use App\Models\comimgprofile;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    private function getGuestMenu()
    {
        return Menu::select('menus.*')
            ->where('is_active', 1)
            ->where('app_id', 2)
            ->where('parent_id', 0)
            ->orderBy('sort_order', 'ASC')
            ->get();
    }

    public function index()
    {

        $title = "Home";
        $menuItem = $this->getGuestMenu();
        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        $carousel = Carousel::where('is_active', 1)
        ->get();

        $directors = BDirector::where('is_active',1)
        ->where('org_type','board')
        ->get();

        $clientlogo = Client::where('is_active',1)->get();

        $mancom = BDirector::where('is_active',1)
        ->where('org_type','mancom')
        ->get();

        return view('pages.index',compact('menuItem','directors','mancom','app','clientlogo','carousel'))->with(['title' => $title]);
    }
    public function about()
    {

        $title = Menu::where('menu_code','MENU0014')->pluck('menu_title')->first();

        $menuItem = $this->getGuestMenu();

        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();

        $directors = BDirector::where('is_active',1)
        ->where('org_type','board')
        ->get();

        $companyprofile = comimgprofile::where('is_active',1)->get();

        return view('pages.about',compact('menuItem','directors','app','companyprofile'))->with(['title'=> $title]);
    }

    public function services()
    {
        $title = Menu::where('menu_code','MENU0015')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();

        $setting = Setting::first();
        return view('pages.services', compact('menuItem','setting'))->with('title', $title);
    }
    public function contact()
    {
        $title = Menu::where('menu_code','MENU0021')->pluck('menu_title')->first();
        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        $menuItem = $this->getGuestMenu();

        return view('pages.contact',compact('menuItem','app','title','app'));
    }
    public function teams()
    {
        $menuItem = $this->getGuestMenu();

        $gallery = DB::table('galleries')
            ->select( 'id','foldername')
            ->where('is_active', 1)
            ->get();


        $thumbnail = DB::table('galleries')
            ->select('id', 'gurec', 'foldername', 'is_active', 'parent_id', 'image', 'filename', 'caption')
            ->where('image', '<>', '')
            ->get();
            $title = Menu::where('menu_code','teams')->pluck('menu_title')->first();

            $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        return view('pages.teams',compact('app'))->with(['title' => $title, 'gallery' => $gallery, 'thumbnail' => $thumbnail,'menuItem'=> $menuItem]);
    }

    public function branch(Request $request)
    {
        $title = Menu::where('menu_code','MENU0020')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();
        $regions = Branch::distinct()->pluck('region');
        $selectedRegion = $request->input('region');
        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        $perPage = 10; // Adjust the number of items per page as needed
        $branches = Branch::when($selectedRegion, function ($query) use ($selectedRegion) {
             $query->where('region', $selectedRegion);
        })
        ->where('is_active', 1)
        ->paginate($perPage); // Paginate the results

        return view('pages.branch', compact('app','title','menuItem','regions', 'selectedRegion', 'branches'));
    }

    public function blog()
    {
        $title = Menu::where('menu_code','MENU0016')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();

        $postid = DB::table('posts')
        ->select('id')->get();

        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        //dd($postid);
       $posts = Posts::where('is_active',1)->where('is_publish',1)->get();
    //    $post = Posts::withCount('comments')->find();
    //     $commentCount = $post->comments_count;
        return view('pages.blog',compact('posts', 'title','menuItem','app'));


    }
    public function blogid(string $id)
    {

        $posts = Posts::find($id);
        if($posts && $posts->is_publish){
            $post = Posts::withCount('comments')->find($id);
            $commentCount = $post->comments_count;
            $menuItem = $this->getGuestMenu();
            $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
            $user = Posts::with(['user'])->find($id);
            return view('pages.blog-details',compact('posts','menuItem','commentCount','user','app'));
        }else{
            return view('inactivate');
        }

    }

    public function warehouse()
    {
        $title = Menu::where('menu_code','MENU0017')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();

        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        return view('pages.warehouse-management',compact('title', 'menuItem','app'));
    }
    public function transport()
    {
        $title = Menu::where('menu_code','MENU0018')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();

        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        return view('pages.transport-services',compact('menuItem','title','app'));
    }
    public function other()
    {
        $title = Menu::where('menu_code','MENU0019')->pluck('menu_title')->first();
        $menuItem = $this->getGuestMenu();

        $app = App::where('id', 2)->select('site_email', 'site_phone', 'site_address')->first();
        return view('pages.other-services',compact('menuItem','title','app'));
    }
}
