<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIIncidentTypeOfNearMiss\NearMissRequest;
use App\Repositories\All\IncidentTypeOfNearMiss\IncidentTypeOfNearMissInterface;
use Illuminate\Http\Request;

class AiIncidentTypeOfNearMissController extends Controller
{
    protected $incidentTypeOfNearMissInterface;

    public function __construct(IncidentTypeOfNearMissInterface $incidentTypeOfNearMissInterface)
    {
        $this->incidentTypeOfNearMissInterface = $incidentTypeOfNearMissInterface;
    }

    public function index()
    {
        $incidentType = $this->incidentTypeOfNearMissInterface->all();
        return response()->json($incidentType);
    }


    public function store(NearMissRequest $request)
    {
        $data = $request->validated();
        $incidentType = $this->incidentTypeOfNearMissInterface->create($data);
        return response()->json([
            'message' => 'Incident type of near miss  created successfully',
            'data' => $incidentType
        ], 201);
    }
}
