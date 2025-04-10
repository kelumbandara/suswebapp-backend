<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaAuditType\AuditTypeRequest;
use App\Repositories\All\SaAiIaAuditType\AuditTypeInterface;

class SaAiIaAuditTypeController extends Controller
{
    protected $auditTypeInterface;

    public function __construct(AuditTypeInterface $auditTypeInterface)
    {
        $this->auditTypeInterface = $auditTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type = $this->auditTypeInterface->all();
        return response()->json($type);
    }

    public function store(AuditTypeRequest $request)
    {
        $data = $request->validated();
        $type = $this->auditTypeInterface->create($data);
        return response()->json([
            'message' => 'Audit type created successfully',
            'data'    => $type,
        ], 201);
    }
}
