<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request('query'), function ($query, $searchQuery) {
                $query->where('username', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(setting('pagination_limit'));

        return $users;
    }

    public function listuser()
    {
        $data = User::where('is_active', 1)
        ->where('username', '!=', 'admin')
        ->get();

        return response()->json($data);
    }
    public function store()
    {
        request()->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        return User::create([
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),

        ]);
    }

    public function update(User $user)
    {
        request()->validate([
            'username' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
            'first_name' => 'required',
            'last_name' => 'required',

        ]);

        $user->update([
            'username' => request('username'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
            'email' => request('email'),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),

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
