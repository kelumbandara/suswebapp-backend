<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'mobileNumber' => 'nullable|string|unique:users,mobileNumber',
            'password' => 'required|string|min:8',
            'confirmPassword' => 'required|string|min:8',
        ]);

        if ($request->password !== $request->confirmPassword) {
            return response()->json([
                'errors' => [
                    'confirmPassword' => ['The password confirmation does not match.']
                ]
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobileNumber' => $request->mobileNumber,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }
}
