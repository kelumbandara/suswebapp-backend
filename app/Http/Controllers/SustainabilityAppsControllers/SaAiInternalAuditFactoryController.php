<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiInternalAuditFactory\InternalAuditFactoryRequest;
use App\Repositories\All\SaAiInternalAuditFactory\InternalAuditFactoryInterface;

class SaAiInternalAuditFactoryController extends Controller
{
    protected $internalAuditFactoryInterface;

    public function __construct(InternalAuditFactoryInterface $internalAuditFactoryInterface)
    {
        $this->internalAuditFactoryInterface = $internalAuditFactoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factory = $this->internalAuditFactoryInterface->all();
        return response()->json($factory);
    }

    public function store(InternalAuditFactoryRequest $request)
    {
        $data    = $request->validated();
        $factory = $this->internalAuditFactoryInterface->create($data);
        return response()->json([
            'message' => 'Audit Factory created successfully',
            'data'    => $factory,
        ], 201);
    }
}
