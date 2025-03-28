<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiEaAuditType\ExternalAuditTypeRequest;
use App\Repositories\All\SaAiEaAuditType\ExternalAuditTypeInterface;
use Illuminate\Http\Request;

class SaAiExternalAuditTypeController extends Controller
{
    protected $externalAuditTypeInterface;

    public function __construct(ExternalAuditTypeInterface $externalAuditTypeInterface)
    {
        $this->externalAuditTypeInterface = $externalAuditTypeInterface;
    }

    public function index()
    {
        $accidentType = $this->externalAuditTypeInterface->all();
        return response()->json($accidentType);
    }


    public function store(ExternalAuditTypeRequest $request)
    {
        $data = $request->validated();

        $auditType = $this->externalAuditTypeInterface->create($data);

        return response()->json([
            'message' => 'External audit type created successfully',
            'data'    => $auditType,
        ], 201);
    }
}
