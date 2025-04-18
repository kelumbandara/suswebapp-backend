<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEmrAcConsumpionUnit\ConsumpionUnitRequest;
use App\Repositories\All\SaEEmrAcUnit\ConsumptionUnitInterface;
use App\Repositories\All\SaEEmrAcUnit\ConsumptionUnitRepository;
use Illuminate\Http\Request;

class SaEmrConsumptionUnitController extends Controller
{
    protected $consumptionUnitInterface;

    public function __construct(ConsumptionUnitInterface $consumptionUnitInterface)
    {
        $this->consumptionUnitInterface = $consumptionUnitInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = $this->consumptionUnitInterface->all();
        return response()->json($unit);
    }

    public function store(ConsumpionUnitRequest $request)
    {
        $data = $request->validated();
        $unit  = $this->consumptionUnitInterface->create($data);
        return response()->json([
            'message' => 'Unit created successfully',
            'data'    => $unit,
        ], 201);
    }
}
