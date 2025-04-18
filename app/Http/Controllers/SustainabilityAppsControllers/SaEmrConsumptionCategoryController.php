<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEmrAcConsumpionCategory\ConsumpionCategoryRequest;
use App\Repositories\All\SaEEmrAcCategory\ConsumptionCategoryInterface;
use Illuminate\Http\Request;

class SaEmrConsumptionCategoryController extends Controller
{
    protected $consumptionCategoryInterface;

    public function __construct(ConsumptionCategoryInterface $consumptionCategoryInterface)
    {
        $this->consumptionCategoryInterface = $consumptionCategoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = $this->consumptionCategoryInterface->all();
        return response()->json($category);
    }

    public function store(ConsumpionCategoryRequest $request)
    {
        $data = $request->validated();
        $category  = $this->consumptionCategoryInterface->create($data);
        return response()->json([
            'message' => 'Category created successfully',
            'data'    => $category,
        ], 201);
    }


}
