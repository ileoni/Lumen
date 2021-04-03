<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if(!$token = Auth::attempt($credentials)) {
            return response()->json(['erro' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }
   
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }


}