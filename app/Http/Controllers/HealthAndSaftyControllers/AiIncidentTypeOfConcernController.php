<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIIncidentTypeOfConcern\ConcernRequest;
use App\Repositories\All\IncidentTypeOfConcern\IncidentTypeOfConcernInterface;

class AiIncidentTypeOfConcernController extends Controller
{
    protected $incidentTypeOfConcernInterface;

    public function __construct(IncidentTypeOfConcernInterface $incidentTypeOfConcernInterface)
    {
        $this->incidentTypeOfConcernInterface = $incidentTypeOfConcernInterface;
    }

    public function index()
    {
        $incidentConcern = $this->incidentTypeOfConcernInterface->all();
        return response()->json($incidentConcern);
    }

    public function store(ConcernRequest $request)
    {
        $data            = $request->validated();
        $incidentConcern = $this->incidentTypeOfConcernInterface->create($data);
        return response()->json([
            'message' => 'Incident type of concern created successfully',
            'data'    => $incidentConcern,
        ], 201);
    }
}
