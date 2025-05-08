<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ComAssigneeLevel;
use App\Repositories\All\AssigneeLevel\AssigneeLevelInterface;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userInterface;
    protected $comPermissionInterface;
    protected $assigneeLevelInterface;

    public function __construct(UserInterface $userInterface, ComPermissionInterface $comPermissionInterface, AssigneeLevelInterface $assigneeLevelInterface)
    {
        $this->userInterface          = $userInterface;
        $this->comPermissionInterface = $comPermissionInterface;
        $this->assigneeLevelInterface = $assigneeLevelInterface;
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
            ] : [];

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

        $userData['assigneeLevel'] = collect($user->assigneeLevel)->map(function ($level) {
        return [
            'id'        => $level->id ?? null,
            'levelId'   => $level->levelId ?? null,
            'levelName' => $level->levelName ?? null,
        ];
    });

        return response()->json($userData, 200);
    }

    public function update(Request $request, string $id)
    {
        $user = $this->userInterface->findById($id);

        $rules = [
            'availability' => 'nullable|boolean',
        ];

        // Apply these rules only when availability is 1
        if ($request->input('availability', $user->availability) == 1) {
            $rules = array_merge($rules, [
                'userType'         => 'required|numeric',
                'department'       => 'nullable|string',
                'assignedFactory'  => 'nullable|array',
                'assigneeLevel'    => 'required|string',
                'responsibleSection' => 'required|array',
                'jobPosition'      => 'nullable|string',
            ]);
        }

        $request->validate($rules);

        $user->userType         = $request->input('userType', $user->userType);
        $user->department       = $request->input('department', $user->department);
        $user->assignedFactory  = $request->input('assignedFactory', $user->assignedFactory);
        $user->assigneeLevel    = $request->input('assigneeLevel', $user->assigneeLevel);
        $user->responsibleSection = $request->input('responsibleSection', $user->responsibleSection);
        $user->jobPosition      = $request->input('jobPosition', $user->jobPosition);
        $user->availability     = $request->input('availability', $user->availability);

        $user->save();

        return response()->json($user->toArray(), 200);
    }


    public function assigneeLevel()
    {
        $sections = ComAssigneeLevel::all();

        return response()->json([
            'assigneeLevels' => $sections,
        ], 200);
    }

}
