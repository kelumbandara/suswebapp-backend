<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIIncidentFactors\FactorsRequest;
use App\Repositories\All\IncidentFactors\IncidentFactorsInterface;
use Illuminate\Http\Request;

class AiIncidentFactorsController extends Controller
{
    protected $incidentFactorsInterface;

    public function __construct(IncidentFactorsInterface $incidentFactorsInterface)
    {
        $this->incidentFactorsInterface = $incidentFactorsInterface;
    }

    public function index()
    {
        $incidentFactors = $this->incidentFactorsInterface->all();
        return response()->json($incidentFactors);
    }


    public function store(FactorsRequest $request)
    {
        $data = $request->validated();
        $incidentFactors = $this->incidentFactorsInterface->create($data);
        return response()->json([
            'message' => 'Incident factors  created successfully',
            'data' => $incidentFactors
        ], 201);
    }
}
