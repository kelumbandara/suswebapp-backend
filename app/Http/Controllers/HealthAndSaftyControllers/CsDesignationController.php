<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhCsDesignation\DesignationRequest;
use App\Repositories\All\CsDesignation\DesignationInterface;
use Illuminate\Http\Request;

class CsDesignationController extends Controller
{
    protected $designationInterface;

    public function __construct(DesignationInterface $designationInterface)
    {
        $this->designationInterface = $designationInterface;
    }

    public function index()
    {
        $designation = $this->designationInterface->All();
        if ($designation->isEmpty()) {
            return response()->json([
                'message' => 'Designation not found.',
            ], );
        }
        return response()->json($designation, 200);
    }

    public function store(DesignationRequest $request)
    {
        $designation = $this->designationInterface->create($request->validated());

        return response()->json([
            'message' => 'Designation created successfully.',
            'data'    => $designation,
        ], 201);
    }

    public function update(DesignationRequest $request, string $id)
    {
        $designation = $this->designationInterface->findById($id);

        if (! $designation) {
            return response()->json([
                'message' => 'Designation not found.',
            ]);
        }

        $this->designationInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Designation updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $designation = $this->designationInterface->findById($id);

        if (! $designation) {
            return response()->json([
                'message' => 'Designation not found.',
            ]);
        }

        $this->designationInterface->deleteById($id);

        return response()->json([
            'message' => 'Designation deleted successfully.',
        ], 200);
    }
}
