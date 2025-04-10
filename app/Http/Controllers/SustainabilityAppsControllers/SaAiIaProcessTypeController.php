<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaProcessType\ProcessTypeRequest;
use App\Repositories\All\SaAiIaProcessType\ProcessTypeInterface;

class SaAiIaProcessTypeController extends Controller
{
    protected $processTypeInterface;

    public function __construct(ProcessTypeInterface $processTypeInterface)
    {
        $this->processTypeInterface = $processTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processType = $this->processTypeInterface->all();
        return response()->json($processType);
    }

    public function store(ProcessTypeRequest $request)
    {
        $data = $request->validated();
        $processType  = $this->processTypeInterface->create($data);
        return response()->json([
            'message' => 'Process type created successfully',
            'data'    => $processType,
        ], 201);
       }
}
