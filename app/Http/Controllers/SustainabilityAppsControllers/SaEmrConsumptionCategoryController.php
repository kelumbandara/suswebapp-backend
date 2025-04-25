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

    public function getcategories()
    {
        $categories = $this->consumptionCategoryInterface->all(['id', 'categoryName']);

        $uniqueCategories = $categories->groupBy('categoryName')->map(function ($item) {
            return $item->first();
        })->values();

        if ($uniqueCategories->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ]);
        }

        return response()->json($uniqueCategories);
    }

    public function getUnit($categoryName)
    {
        $unit = $this->consumptionCategoryInterface->getByColumn(['categoryName' => $categoryName], ['id', 'unitName']);

        if ($unit->isEmpty()) {
            return response()->json([
                'message' => 'No unit found.',
            ]);
        }

        $uniqueUnit = $unit->unique('unit')->values()->map(function ($item) {
            return [
                'id'          => (int) $item->id,
                'unit' => $item->unit,
            ];
        });

        return response()->json($uniqueUnit);
    }


}
