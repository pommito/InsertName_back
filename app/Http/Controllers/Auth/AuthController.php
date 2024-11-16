<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = User::create($credentials);

        $token = $user->createToken($request->name);

        return response()->json([
            'message' => 'Register',
            'token' => $token->plainTextToken,
        ]);
    }


    public function login(LoginRequest $request)
    {
    $credentials = $request->validated();

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // // Make sure that the session is regenerated
    // if (!$request->hasSession()) {
    //     $request->setLaravelSession(app('session')->driver());
    // }

    // $request->session()->regenerate();

    $token = $user->createToken($user->name);

    $cookie = cookie('access_token', $token->plainTextToken, 60 * 24, '/', null, env('COOKIE_SECURE'), true, false, 'Strict');

    return response()->json([
        'message' => 'Logged in',
        'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        ],
    ])->withCookie($cookie);
    }

    public function logout(Request $request)
    {
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Not authenticated'], 401);
    }

    $user->tokens()->delete();

    $cookie = cookie('access_token', null, -1, '/', null, env('COOKIE_SECURE'), true, false, 'Strict');

    return response()->json(['message' => 'Logged out successfully'])->withCookie($cookie);
    }
}
