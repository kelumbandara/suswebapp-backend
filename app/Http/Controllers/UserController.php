<?php

namespace App\Http\Controllers;

use App\Repositories\All\AssigneeLevel\AssigneeLevelInterface;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    $permission = $this->comPermissionInterface->getById($user->userType);
    $userData = $user->toArray(); // keep all original fields, including userType: int

    if ($permission) {
        $userData['permissionObject'] = (array) $permission->permissionObject;

        $userData['userTypeObject'] = [
            'id' => $permission->id,
            'name' => $permission->userType ?? null,
        ];
    }
    $userData['assigneeLevelObject'] = $this->assigneeLevelInterface->getById($user->assigneeLevel);

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

    public function changePassword(Request $request)
    {
        $user = $this->userInterface->getById($request->user()->id);

        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string',
            'newPassword'     => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->newPassword);

        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }





}
