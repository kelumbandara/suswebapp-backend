<?php
namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComPermission\ComPermissionRequest;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Repositories\All\User\UserInterface;

class ComPermissionController extends Controller
{
    protected $comPermissionInterface;
    protected $userInterface;

    public function __construct(ComPermissionInterface $comPermissionInterface, UserInterface $userInterface)
    {
        $this->comPermissionInterface = $comPermissionInterface;
        $this->userInterface          = $userInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->comPermissionInterface->All();
        return response()->json($permissions);
    }

    public function create()
    {
    }

    public function store(ComPermissionRequest $request)
    {
        $data = $request->validated();

        $permission = $this->comPermissionInterface->create($data);
        return response()->json($permission, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = $this->comPermissionInterface->getById($id);
        return response()->json($permission);
    }


    public function update(ComPermissionRequest $request, string $id)
    {
        $data = $request->validated();
        $permission = $this->comPermissionInterface->findById($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        try {
            $permission->update([
                'userType' => $data['userType'] ?? $permission->userType,
                'description' => $data['description'] ?? $permission->description,
                'permissionObject' => $data['permissionObject']
            ]);

            return response()->json([
                'message' => 'Permission updated successfully',
                'data' => $permission
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update permission',
                'error' => $e->getMessage()
            ], 500);
        }
    }





    public function destroy(string $id)
    {
        $permission = $this->comPermissionInterface->getById($id);

        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        $userInUse = $this->userInterface->getByUserType($permission->userType);

        if ($userInUse->isNotEmpty()) {
            return response()->json(['error' => 'Cannot delete: This userType is currently in use by one or more users.'], 400);
        }


        $this->comPermissionInterface->deleteById($id);
        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }

}
