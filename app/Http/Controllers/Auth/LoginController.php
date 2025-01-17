<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($request->password === $user->password) {
                $token = $user->createToken('SATTVA')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user
                ], 201);
            }

            return response()->json([
                'message' => 'Invalid password',
            ], 401);
        }

        return response()->json([
            'message' => 'User not found',
        ], 404);
    }
}
