<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Incoming registration data: ', $request->all());

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobileNumber' => ['required', 'string', 'max:15', 'unique:users,mobile_number'],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        Log::info('Validated registration data: ', $validatedData);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'mobile_number' => $validatedData['mobileNumber'],
                'password' => Hash::make($validatedData['password']),
            ]);

            Log::info('User created successfully: ', $user->toArray());

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating user: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating user'], 500);
        }
    }
}
