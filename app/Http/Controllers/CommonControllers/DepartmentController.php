<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentRequest;
use App\Repositories\All\ComDepartment\DepartmentInterface;

class DepartmentController extends Controller
{
    protected $departmentInterface;

    public function __construct(DepartmentInterface $departmentInterface)
    {
        $this->departmentInterface = $departmentInterface;
    }


    public function show()
    {
        $departments = $this->departmentInterface->All();

        if ($departments->isEmpty()) {
            return response()->json([
                'message' => 'No departments found.',
            ], 404);
        }

        return response()->json($departments);
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
