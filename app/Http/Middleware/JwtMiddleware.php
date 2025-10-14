<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
      {
          try {
            $token = JWTAuth::getToken();
            if (! $token) {
                return response()->json(['status' => 'Token not found in request'], 401);
            }

            $user = JWTAuth::parseToken()->authenticate();
            if (! $user) {
                return response()->json(['status' => 'User not found'], 401);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'Token Expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'Token Invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'Token not provided'], 401);
        }

        return $next($request);
      }
}
