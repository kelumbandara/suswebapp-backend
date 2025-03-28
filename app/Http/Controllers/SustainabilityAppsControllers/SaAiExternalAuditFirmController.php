<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiEaAuditFirm\ExternalAuditFirmRequest;
use App\Repositories\All\SaAiEaAuditFirm\ExternalAuditFirmInterface;
use Illuminate\Http\Request;

class SaAiExternalAuditFirmController extends Controller
{
    protected $externalAuditFirmInterface;

    public function __construct(ExternalAuditFirmInterface $externalAuditFirmInterface)
    {
        $this->externalAuditFirmInterface = $externalAuditFirmInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accidentType = $this->externalAuditFirmInterface->all();
        return response()->json($accidentType);
    }

    public function store(ExternalAuditFirmRequest $request)
    {
        $data         = $request->validated();
        $accidentType = $this->externalAuditFirmInterface->create($data);
        return response()->json([
            'message' => 'External audit firm created successfully',
            'data'    => $accidentType,
        ], 201);
    }
}
