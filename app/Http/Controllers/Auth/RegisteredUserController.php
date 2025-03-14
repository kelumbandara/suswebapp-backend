<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Notifications\WelcomeNotification\WelcomeNotification;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function store(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['isCompanyEmployee'] = (bool) $validatedData['isCompanyEmployee'];
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = $this->userInterface->create($validatedData);

        try {
            Notification::send($user, new WelcomeNotification($user->name));
        } catch (\Exception $e) {
            // Handle exception if needed
        }

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }
}
