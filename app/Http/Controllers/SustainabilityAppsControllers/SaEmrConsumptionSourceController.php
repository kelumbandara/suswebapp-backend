<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEmrAcConsumpionCategory\ConsumpionCategoryRequest;
use App\Http\Requests\SaEmrAcConsumpionSource\ConsumpionSourceRequest;
use App\Repositories\All\SaEEmrAcSource\ConsumptionSourceInterface;

class SaEmrConsumptionSourceController extends Controller
{
    protected $consumptionSourceInterface;

    public function __construct(ConsumptionSourceInterface $consumptionSourceInterface)
    {
        $this->consumptionSourceInterface = $consumptionSourceInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $source = $this->consumptionSourceInterface->all();
        return response()->json($source);
    }

    public function store(ConsumpionSourceRequest $request)
    {
        $data = $request->validated();
        $source  = $this->consumptionSourceInterface->create($data);
        return response()->json([
            'message' => 'Source created successfully',
            'data'    => $source,
        ], 201);
    }
}
