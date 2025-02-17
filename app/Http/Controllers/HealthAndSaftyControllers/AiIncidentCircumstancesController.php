<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsAiIncidentCircumstances\IncidentCircumstancesRequest;
use App\Repositories\All\IncidentCircumstances\IncidentCircumstancesInterface;

class AiIncidentCircumstancesController extends Controller
{
    protected $incidentCircumstancesInterface;

    public function __construct(IncidentCircumstancesInterface $incidentCircumstancesInterface)
    {
        $this->incidentCircumstancesInterface = $incidentCircumstancesInterface;
    }

    public function index()
    {
        $supplierName = $this->incidentCircumstancesInterface->All();

        return response()->json($supplierName, 200);
    }

    public function store(IncidentCircumstancesRequest $request)
    {
        $circumstances = $this->incidentCircumstancesInterface->create($request->validated());

        return response()->json([
            'message' => 'Circumstances created successfully.',
            'data'    => $circumstances,
        ], 201);
    }

    public function update(IncidentCircumstancesRequest $request, string $id)
    {
        $circumstances = $this->incidentCircumstancesInterface->findById($id);

        if (! $circumstances) {
            return response()->json([
                'message' => 'Circumstances not found.',
            ], );
        }

        $this->incidentCircumstancesInterface->update($id, $request->validated());

        return response()->json([
            'message' => ' Circumstances updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $circumstances = $this->incidentCircumstancesInterface->findById($id);

        if (! $circumstances) {
            return response()->json([
                'message' => 'Circumstances not found.',
            ], );
        }

        $this->incidentCircumstancesInterface->deleteById($id);

        return response()->json([
            'message' => 'Circumstances deleted successfully.',
        ], 200);
    }
}
