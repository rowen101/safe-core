<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppUser;
use Illuminate\Http\Request;

class AppController extends Controller
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
    public function index(){
        // Check if the user is authenticated
        if(auth()->check()) {
            $userId = auth()->user()->id;

            $data = AppUser::query()
                ->join('app', 'app.id', '=', 'app_users.app_id')
                ->where('app_users.user_id', $userId)
                ->where('app.is_active', true)
                ->select('app.*') // Select all columns from the 'app' table
                ->get();

            // Return a JSON response with the data
            // return response()->json($data);
            return view('app',compact('data'));
        } else {
            // Handle the case where the user is not authenticated
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}
