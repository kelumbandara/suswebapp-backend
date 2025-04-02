<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrMaterialityType\MaterialityTypeRequest;
use App\Repositories\All\SaSrMaterialityType\MaterialityTypeInterface;

class SaSrMaterialityTypeController extends Controller
{
    protected $materialityTypeInterface;

    public function __construct(MaterialityTypeInterface $materialityTypeInterface)
    {
        $this->materialityTypeInterface = $materialityTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialityType = $this->materialityTypeInterface->all();
        return response()->json($materialityType);
    }

    public function store(MaterialityTypeRequest $request)
    {
        $data            = $request->validated();
        $materialityType = $this->materialityTypeInterface->create($data);
        return response()->json([
            'message' => 'Alignment created successfully',
            'data'    => $materialityType,
        ], 201);
    }
}
