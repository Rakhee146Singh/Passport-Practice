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
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where(['email' => $validatedData['email'], 'password' => $validatedData['password']])->first();
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Logged in Successfully',
            'status' => 1
        ]);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'user' => null,
                'message' => 'User not found',
                'status' => 0
            ]);
        } else {
            return response()->json([
                'user' => $user,
                'message' => 'User found',
                'status' => 1
            ]);
        }
    }
}
