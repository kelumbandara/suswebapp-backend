<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrImpactType\ImpactTypeRequest;
use App\Repositories\All\SaSrImpactType\ImpactTypeInterface;

class SaSrIdImpactTypeController extends Controller
{
    protected $impactTypeInterface;

    public function __construct(ImpactTypeInterface $impactTypeInterface)
    {
        $this->impactTypeInterface = $impactTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $impactType = $this->impactTypeInterface->all();
        return response()->json($impactType);
    }

    public function store(ImpactTypeRequest $request)
    {
        $data       = $request->validated();
        $impactType = $this->impactTypeInterface->create($data);
        return response()->json([
            'message' => 'Impact Type created successfully',
            'data'    => $impactType,
        ], 201);
    }
}
