<?php
namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComPermission\ComPermissionRequest;
use App\Repositories\All\ComPermission\ComPermissionInterface;

class ComPermissionController extends Controller
{
    protected $comPermissionInterface;

    public function __construct(ComPermissionInterface $comPermissionInterface)
    {
        $this->comPermissionInterface = $comPermissionInterface;
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
        $this->comPermissionInterface->deleteById($id);
        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }
}
