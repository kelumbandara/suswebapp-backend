<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentCategory\AccidentCategoryRequest;
use App\Repositories\All\AccidentCategory\AccidentCategoryInterface;

class AiAccidentCategoryController extends Controller
{
    protected $accidentCategoryInterface;

    public function __construct(AccidentCategoryInterface $accidentCategoryInterface)
    {
        $this->accidentCategoryInterface = $accidentCategoryInterface;
    }

    public function store(AccidentCategoryRequest $request)
    {
        $data     = $request->validated();
        $category = $this->accidentCategoryInterface->create($data);
        return response()->json([
            'message' => 'Accident category created successfully',
            'data'    => $category,
        ], 201);
    }

    public function getCategories()
    {
        $categories = $this->accidentCategoryInterface->all(['id', 'categoryName']);

        $uniqueCategories = $categories->groupBy('categoryName')->map(function ($item) {
            return $item->first();
        })->values();

        if ($uniqueCategories->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ], 404);
        }

        return response()->json($uniqueCategories);
    }

    public function getSubcategories($categoryName)
    {
        $subcategories = $this->accidentCategoryInterface->getByColumn(['categoryName' => $categoryName], ['id', 'subCategoryName']);

        if ($subcategories->isEmpty()) {
            return response()->json([
                'message' => 'No subcategories found for this category.',
            ], 404);
        }

        return response()->json($subcategories);
    }

}
