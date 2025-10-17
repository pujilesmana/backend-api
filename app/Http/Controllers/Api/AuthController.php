<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;

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

        Log::info("Attempting user login: " . $credentials['email']);
        // Validasi password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return ResponseHelper::error('Invalid email or password', 401);
        }

        // Generate token
        $token = JWTAuth::fromUser($user);
        $ttl = config('jwt.ttl') * 60; // detik


        return ResponseHelper::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ], 'Token generated successfully');
    }
}
