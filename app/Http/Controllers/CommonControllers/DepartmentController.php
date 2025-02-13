<?php

namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Repositories\All\ComDepartment\DepartmentInterface;

class DepartmentController extends Controller
{
    protected $departmentInterface;

    public function __construct(DepartmentInterface $departmentInterface)
    {
        $this->departmentInterface = $departmentInterface;
    }


    public function index()
    {
        $department = $this->departmentInterface->All();
        if ($department->isEmpty()) {
            return response()->json([
                'message' => 'No jobPositions found.',
            ]);
        }
        return response()->json($department);
    }


    public function store(DepartmentRequest $request)
    {
        $validatedData = $request->validated();
        $department = $this->departmentInterface->create($validatedData);

        return response()->json([
            'message'    => 'Department created successfully!',
            'department' => $department,
        ], 201);
    }
}
