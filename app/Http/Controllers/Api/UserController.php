<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'min:8|confirmed'
        ]);
        $user = User::create($validatedData);
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User Created Successfully',
            'status' => 1
        ]);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        $user = User::where(['name' => $validatedData['name'], 'password' => $validatedData['password']]);
        // $token = $user->createToken("auth_token")->accessToken;
        // return response()->json([
        //     'token' => $token,
        //     'user' => $user,
        //     'message' => 'Logged in Successfully',
        //     'status' => 1
        // ]);

        //dd($user);
        // echo "<pre>";
        print_r($user);
    }
}
