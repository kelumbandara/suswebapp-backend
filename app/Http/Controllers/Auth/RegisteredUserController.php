<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\All\User\UserInterface;

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

        $user = $this->userInterface->create($validatedData);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }



}
