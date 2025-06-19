<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrEmployeeType\RrEmployeeTypeRequest;
use App\Repositories\All\SaRrEmployeeType\RrEmployeeTypeInterface;
use Illuminate\Http\Request;

class SaRrEmployeeTypeController extends Controller
{
    protected $rrEmployeeTypeInterface;

    public function __construct(RrEmployeeTypeInterface $rrEmployeeTypeInterface)
    {
        $this->rrEmployeeTypeInterface = $rrEmployeeTypeInterface;
    }

    public function index()
    {
        $employeeType = $this->rrEmployeeTypeInterface->All();
        if ($employeeType->isEmpty()) {
            return response()->json([
                'message' => 'No Employee Type found.',
            ]);
        }
        return response()->json($employeeType);
    }

    public function store(RrEmployeeTypeRequest $request)
    {
        $employeeType = $this->rrEmployeeTypeInterface->create($request->validated());

        return response()->json([
            'message'  => 'Employee Type created successfully!',
            'employeeType' => $employeeType,
        ], 201);
    }
}
