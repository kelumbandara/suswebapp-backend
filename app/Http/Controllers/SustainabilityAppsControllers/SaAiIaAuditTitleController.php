<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaAuditTitle\AuditTitleRequest;
use App\Repositories\All\SaAiIaAuditTitle\AuditTitleInterface;

class SaAiIaAuditTitleController extends Controller
{
    protected $auditTitleInterface;

    public function __construct(AuditTitleInterface $auditTitleInterface)
    {
        $this->auditTitleInterface = $auditTitleInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = $this->auditTitleInterface->all();
        return response()->json($title);
    }

    public function store(AuditTitleRequest $request)
    {
        $data  = $request->validated();
        $title = $this->auditTitleInterface->create($data);
        return response()->json([
            'message' => 'Audit Title created successfully',
            'data'    => $title,
        ], 201);
    }
}
