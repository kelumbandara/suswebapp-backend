<?php

namespace App\Http\Controllers;

use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

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
        $userType = $user->userType;
    
        $permission = $this->comPermissionInterface->getById($userType);
    
        $userData = $user->toArray();
    
        if ($permission) {
            $userData = array_merge($userData, (array) $permission->permissionObject);
        }
    
        return response()->json($userData, 200);
    }
    

    public function index()
    {
        $user = $this->userInterface->All();
        if ($user->isEmpty()) {
            return response()->json([
                'message' => 'No users found.',
            ], 404);
        }
        return response()->json($user);
    }

}
