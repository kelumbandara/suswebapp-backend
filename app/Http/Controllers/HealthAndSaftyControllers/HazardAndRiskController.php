<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardandRisk\HazardandRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;

class HazardAndRiskController extends Controller
{

    protected $hazardAndRiskInterface;

    public function __construct(HazardAndRiskInterface $hazardAndRiskInterface)
    {
        $this->hazardAndRiskInterface = $hazardAndRiskInterface;
    }

    public function index()
    {
        $hazardRisks = $this->hazardAndRiskInterface->All();
        if ($hazardRisks->isEmpty()) {
            return response()->json([
                'message' => 'No hazard and risk records found.',
            ], 404);
        }

        return response()->json($hazardRisks, 200);
    }

    public function store(HazardandRiskRequest $request)
    {
        // Validate the request, create the record through the repository
        $validatedData = $request->validated();

        // Call the repository method to create a new hazard and risk record
        $hazardRisk = $this->hazardAndRiskInterface->create($validatedData);

        return response()->json([
            'message'    => 'Hazard and risk record created successfully!',
            'hazardRisk' => $hazardRisk,
        ], 201);
    }

    public function show($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        return response()->json($hazardRisk, 200);
    }

    public function update($id, HazardandRiskRequest $request)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        // Validate and update the record through the repository
        $validatedData = $request->validated();
        $hazardRisk    = $this->hazardAndRiskInterface->update($id, $validatedData);

        return response()->json([
            'message'    => 'Hazard and risk record updated successfully!',
            'hazardRisk' => $hazardRisk,
        ], 200);
    }

    public function destroy($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        $this->hazardAndRiskInterface->deleteById($id);

        return response()->json([
            'message' => 'Hazard and risk record deleted successfully!',
        ], 200);
    }
    public function edit($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        return response()->json($hazardRisk, 200);
    }

}
