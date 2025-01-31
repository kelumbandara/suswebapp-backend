<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardandRisk\HazardandRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use Illuminate\Http\Request;

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
            'hazardRisk'   => $hazardRisk,
        ], 201); 
    }
}
