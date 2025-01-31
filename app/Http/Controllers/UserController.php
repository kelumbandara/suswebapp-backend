<?php

namespace App\Http\Controllers;

use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

        public function show(Request $request)
    {
        return response()->json($request->user());
    }


    public function index()
{
    $users = $this->userInterface->All()->map(function ($user) {
        return [
            'userId' => $user->id,
            'name' => $user->name,
            'assigneeLevel' => $user->assigneeLevel,
            'responsibleSection' => $user->responsibleSection,
        ];
    });

    return response()->json($users, 201);
}
}
