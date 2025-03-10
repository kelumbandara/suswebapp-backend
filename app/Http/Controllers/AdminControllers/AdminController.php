<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userInterface;
    protected $comPermissionInterface;

    public function __construct(UserInterface $userInterface, ComPermissionInterface $comPermissionInterface)
    {
        $this->userInterface = $userInterface;
        $this->comPermissionInterface = $comPermissionInterface;
    }
    public function index()
{
    $users = $this->userInterface->All(); // Assuming this returns a collection of users

    // Map through each user and retrieve their userType and permissions
    $userData = $users->map(function ($user) {
        // Fetch permission details based on userType ID
        $permission = $this->comPermissionInterface->getById($user->userType);

        // Get user attributes dynamically
        $userArray = $user->toArray();

        // Dynamically set the userType and permissions
        $userArray['userType'] = [
            'id'          => $permission->id ?? null,
            'userType'    => $permission->userType ?? null,
            'description' => $permission->description ?? null,
        ];


        return $userArray;
    });

    return response()->json($userData, 200);
}


    public function show(Request $request)
{
    $user = $request->user();
    $userType = $user->userType; // Assuming this is the ID of the user type

    // Fetch permission details based on userType ID
    $permission = $this->comPermissionInterface->getById($userType);

    // Get all user attributes dynamically (using toArray)
    $userData = $user->toArray();

    // Dynamically set the userType and permissions
    $userData['userType'] = [
        'id'          => $permission->id ?? null,
        'userType'    => $permission->userType ?? null,
        'description' => $permission->description ?? null,
    ];

    // Add permissions dynamically
    $userData['permissionObject'] = $permission ? (array) $permission->permissionObject : [];

    return response()->json($userData, 200);
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
