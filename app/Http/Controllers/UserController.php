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
        $userType = $request->user()->userType;

        $permission = $this->comPermissionInterface->getById($userType);

        if ($permission) {
            return response()->json([
                'user' => $request->user(),
                'permissions' => $permission->permissionObject,
            ], 200);
        }
        return response()->json($request->user(), 200);
    }

    public function index()
    {
        $user = $this->userInterface->All();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
