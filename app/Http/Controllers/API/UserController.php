<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function login(Request $request)
    {

        try {
            $user = User::where('email', $request->email)->first();

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
        } catch (\Exception $e) {
            // Handle the exception here, you can log it or return an error response.
            return response([
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }


    public function register(Request $request){
        // Validate the incoming data
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        // Check if the email already exists in the 'users' table
        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return response([
                'message' => 'The provided email address is already registered.'
            ], 422); // Return a 422 status code for validation errors
        }

        // Continue with user registration
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

        return response($res, 201); // Return a success response
    }


    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Successfully logged out.'
        ]);
    }

}
