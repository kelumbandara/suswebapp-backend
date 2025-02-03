<?php

namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Repositories\All\ComPermission\ComPermissionInterface;
use App\Http\Requests\ComPermission\ComPermissionRequest;

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

    public function edit(string $id)
    {
    }


    public function update(ComPermissionRequest $request, string $id)
    {
        $data = $request->validated();

        $permission = $this->comPermissionInterface->findById($id, $data);
        return response()->json($permission);
    }


    public function destroy(string $id)
    {
        $this->comPermissionInterface->deleteById($id);
        return response()->json(null, 204);
    }
}
