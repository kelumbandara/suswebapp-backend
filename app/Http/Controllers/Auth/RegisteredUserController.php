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
            'mobile_number' => ['required', 'digits:30', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Log::info('Validated registration data: ', $validatedData);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'mobile_number' => $validatedData['mobile_number'],
                'password' => Hash::make($validatedData['password']),
            ]);

            Log::info('User created successfully: ', $user->toArray());

            return response()->json(['message' => 'Registration successful', 'user' => $user], 201);

        } catch (\Exception $e) {
            Log::error('Error creating user: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating user'], 500);
        }
    }
}
