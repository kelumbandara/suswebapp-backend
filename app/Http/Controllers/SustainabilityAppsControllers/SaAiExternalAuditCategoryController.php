<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiEaAuditCategory\ExternalAuditCategoryRequest;
use App\Repositories\All\SaAiEaAuditCategory\ExternalAuditCategoryInterface;
use Illuminate\Http\Request;

class SaAiExternalAuditCategoryController extends Controller
{

    protected $externalAuditCategoryInterface;

    public function __construct(ExternalAuditCategoryInterface $externalAuditCategoryInterface)
    {
        $this->externalAuditCategoryInterface = $externalAuditCategoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accidentType = $this->externalAuditCategoryInterface->all();
        return response()->json($accidentType);
    }

    public function store(ExternalAuditCategoryRequest $request)
    {
        $data         = $request->validated();
        $accidentType = $this->externalAuditCategoryInterface->create($data);
        return response()->json([
            'message' => 'External audit category created successfully',
            'data'    => $accidentType,
        ], 201);
    }


}
