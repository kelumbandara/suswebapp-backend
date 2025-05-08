<?php

namespace App\Http\Controllers;

use App\Repositories\All\AssigneeLevel\AssigneeLevelInterface;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userInterface;
    protected $comPermissionInterface;
    protected $assigneeLevelInterface;

    public function __construct(UserInterface $userInterface, ComPermissionInterface $comPermissionInterface, AssigneeLevelInterface $assigneeLevelInterface)
    {
        $this->userInterface = $userInterface;
        $this->comPermissionInterface = $comPermissionInterface;
        $this->assigneeLevelInterface = $assigneeLevelInterface;
    }

    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->availability != 1) {
            return response()->json(['message' => 'User not available'], 403);
        }

        $userData = $user->toArray();

        $permission = $this->comPermissionInterface->getById($user->userType);
        $userData['userType'] = $permission ? [
            'id'          => $permission->id,
            'userType'    => $permission->userType,
            'description' => $permission->description,
            'permissionObject' => $permission->permissionObject,
        ] : null;


        $assigneeLevel = $this->assigneeLevelInterface->getById($user->assigneeLevel);
        $userData['userLevel'] = $assigneeLevel ? [
            'id'        => $assigneeLevel->id,
            'levelId'   => $assigneeLevel->levelId,
            'levelName' => $assigneeLevel->levelName,
        ] : null;

        return response()->json($userData, 200);
    }



    public function index()
    {
        $users = $this->userInterface->All();

        $userData = $users->map(function ($user) {
            $permission = $this->comPermissionInterface->getById($user->userType);

            $assigneeLevel = $this->assigneeLevelInterface->getById($user->assigneeLevel);

            $userArray = $user->toArray();

            $userArray['userType'] = [
                'id'          => $permission->id ?? null,
                'userType'    => $permission->userType ?? null,
                'description' => $permission->description ?? null,
            ];

            $userArray['userLevel'] = $assigneeLevel ? [
                'id'        => $assigneeLevel->id,
                'levelId'   => $assigneeLevel->levelId,
                'levelName' => $assigneeLevel->levelName,
            ] : null;

            return $userArray;
        });

        return response()->json($userData, 200);
    }


}
