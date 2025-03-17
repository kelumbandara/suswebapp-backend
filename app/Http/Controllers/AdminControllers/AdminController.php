<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ComAssigneeLevel;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userInterface;
    protected $comPermissionInterface;

    public function __construct(UserInterface $userInterface, ComPermissionInterface $comPermissionInterface)
    {
        $this->userInterface          = $userInterface;
        $this->comPermissionInterface = $comPermissionInterface;
    }
    
    public function index()
    {
        $users = $this->userInterface->All();

        $userData = $users->map(function ($user) {
            $permission = $this->comPermissionInterface->getById($user->userType);
            $userArray  = $user->toArray();

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
        $user     = $request->user();
        $userType = $user->userType;

        $permission = $this->comPermissionInterface->getById($userType);

        $userData = $user->toArray();

        $userData['userType'] = [
            'id'          => $permission->id ?? null,
            'userType'    => $permission->userType ?? null,
            'description' => $permission->description ?? null,
        ];

        $userData['permissionObject'] = $permission ? (array) $permission->permissionObject : [];

        return response()->json($userData, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'userType'         => 'required|string',
            'department'       => 'nullable|string',
            'assignedFactory'  => 'nullable|email',
            'assigneeLevel'    => 'required|string',
            'permissionObject' => 'required|array',
            'jobPosition'      => 'nullable|string',
            'availability'     => 'nullable|boolean',
        ]);

        $user = $this->userInterface->findById($id);

        $user->userType         = $request->input('userType');
        $user->department       = $request->input('department');
        $user->assignedFactory  = $request->input('assignedFactory');
        $user->assigneeLevel    = $request->input('assigneeLevel');
        $user->permissionObject = $request->input('permissionObject');
        $user->jobPosition      = $request->input('jobPosition');
        $user->availability     = $request->input('availability', $user->availability);

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user'    => $user,
        ], 200);
    }

    public function assigneeLevel()
    {
        $sections = ComAssigneeLevel::all();

        return response()->json([
            'assigneeLevels' => $sections,
        ], 200);
    }

}
