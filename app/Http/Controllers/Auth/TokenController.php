<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{

    /**
     * Create and return a token if the user is logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(\Tymon\JWTAuth\JWTAuth $auth)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'not_logged_in'], 401);
        }
        // Claims will be sent with the token
        $user = Auth::user();
        $claims = ['name' => $user->name, 'email' => $user->email];
        // Create token from user + add claims data
        $token = $auth->fromUser($user, $claims);
        return response()->json(['token' => $token]);
    }

}
