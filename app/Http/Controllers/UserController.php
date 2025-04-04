<?php

namespace App\Http\Controllers;

use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userInterface;
    protected $comPermissionInterface;

    public function __construct(UserInterface $userInterface, ComPermissionInterface $comPermissionInterface)
    {
        $this->userInterface = $userInterface;
        $this->comPermissionInterface = $comPermissionInterface;
    }

    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->availability != 1) {
            return response()->json(['message' => 'User not available'], 403);
        }

        $userType = $user->userType;
        $permission = $this->comPermissionInterface->getById($userType);
        $userData = $user->toArray();

        if ($permission) {
            $userData['permissionObject'] = (array) $permission->permissionObject;
        }

        return response()->json($userData, 200);
    }







    public function index()
    {
        $user = $this->userInterface->All();
        if ($user->isEmpty()) {
            return response()->json([
                'message' => 'No users found.',
            ]);
        }
        return response()->json($user);
    }


}
