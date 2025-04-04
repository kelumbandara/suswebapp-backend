<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaInternalAuditee\InternalAuditeeRequest;
use App\Http\Requests\SaAiInternalAuditRecode\InternalAuditRequest;
use App\Repositories\All\SaAiIaInternalAuditee\InternalAuditeeInterface;

class SaAiIaInternalAuditeeController extends Controller
{
    protected $internalAuditeeInterface;

    public function __construct(InternalAuditeeInterface $internalAuditeeInterface)
    {
        $this->internalAuditeeInterface = $internalAuditeeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditee = $this->internalAuditeeInterface->all();
        return response()->json($auditee);
    }

    public function store(InternalAuditeeRequest $request)
    {
        $data = $request->validated();
        $auditee  = $this->internalAuditeeInterface->create($data);
        return response()->json([
            'message' => 'Internal Auditee created successfully',
            'data'    => $auditee,
        ], 201);
    }
}
