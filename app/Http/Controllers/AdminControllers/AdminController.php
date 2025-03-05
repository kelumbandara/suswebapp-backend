<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    public function index()
    {
        $user = $this->userInterface->All();

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function update(Request $request, string $id)
{
    $request->validate([
        'userType' => 'required|string',
    ]);

    $user = $this->userInterface->findById($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->userType = $request->input('userType');
    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user,
    ], 200);
}

    public function destroy(string $id)
    {

    }
}
