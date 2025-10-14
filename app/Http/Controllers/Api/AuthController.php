<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cari user
        $user = User::where('email', $credentials['email'])->first();

        // Validasi password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Generate token
        $token = JWTAuth::fromUser($user);
        $ttl = config('jwt.ttl') * 60; // detik

        return response()->json([
            'status' => true,
            'accessToken' => $token,
            'exp' => $ttl,
        ]);
    }
}
