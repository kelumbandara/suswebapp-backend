<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiEaAuditStandard\ExternalAuditStandardRequest;
use App\Repositories\All\SaAiEaAuditStandard\ExternalAuditStandardInterface;
use Illuminate\Http\Request;

class SaAiExternalAuditStandardController extends Controller
{
    protected $externalAuditStandardInterface;

    public function __construct(ExternalAuditStandardInterface $externalAuditStandardInterface)
    {
        $this->externalAuditStandardInterface = $externalAuditStandardInterface;
    }

    public function index()
    {
        $accidentType = $this->externalAuditStandardInterface->all();
        return response()->json($accidentType);
    }

    public function store(ExternalAuditStandardRequest $request)
    {
        $data         = $request->validated();
        $accidentType = $this->externalAuditStandardInterface->create($data);
        return response()->json([
            'message' => 'External audit standard created successfully',
            'data'    => $accidentType,
        ], 201);
    }
}
