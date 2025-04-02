<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrPillars\PillarsRequest;
use App\Repositories\All\SaSrPillars\PillarsInterface;

class SaSrPillarsController extends Controller
{
    protected $pillarsInterface;

    public function __construct(PillarsInterface $pillarsInterface)
    {
        $this->pillarsInterface = $pillarsInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pillars = $this->pillarsInterface->all();
        return response()->json($pillars);
    }

    public function store(PillarsRequest $request)
    {
        $data    = $request->validated();
        $pillars = $this->pillarsInterface->create($data);
        return response()->json([
            'message' => 'Pillars created successfully',
            'data'    => $pillars,
        ], 201);
    }
}
