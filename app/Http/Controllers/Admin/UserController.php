<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

             $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

             return response($response, 201);
    }

 public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }


    public function index()
    {
        $users = User::query()
            ->when(request('query'), function ($query, $searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(setting('pagination_limit'));

        return $users;
    }

    public function listuser()
    {
        $data = User::where('is_active', 1)
        ->where('name', '!=', 'admin')
        ->get();

        return response()->json($data);
    }
    public function store()
    {
        request()->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required'
        ]);

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'gender' => request('gender')

        ]);
    }

    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required'

        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
            'email' => request('email'),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'gender' => request('gender')

        ]);

        return $user;
    }


    public function destory(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function changesitehead(User $user)
    {
        $user->update([
            'sitehead_user_id' => request('sitehead_user_id'),
        ]);

        return response()->json(['success' => true]);
    }

    public function changeRole(User $user)
    {
        $user->update([
            'role' => request('role'),
        ]);

        return response()->json(['success' => true]);
    }

    public function bulkDelete()
    {
        User::whereIn('id', request('ids'))->delete();

        return response()->json(['message' => 'Users deleted successfully!']);
    }
}
