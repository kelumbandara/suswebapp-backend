<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HRCategory\HRCategoryRequest;
use App\Repositories\All\HRCategory\HRCategoryInterface;

class HrCategoryController extends Controller
{
    protected $hrCategoryInterface;

    public function __construct(HRCategoryInterface $hrCategoryInterface)
    {
        $this->hrCategoryInterface = $hrCategoryInterface;
    }

    public function index()
    {
        $category = $this->hrCategoryInterface->All();
        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ], 404);
        }
        return response()->json($category);
    }

    public function store(HRCategoryRequest $request)
    {
        $category = $this->hrCategoryInterface->create($request->validated());

        return response()->json([
            'message'  => 'category created successfully!',
            'category' => $category,
        ], 201);
    }

    public function getcategories()
    {
        $categories = $this->hrCategoryInterface->all()->pluck('categoryName');

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ], 404);
        }

        return response()->json($categories);
    }

    public function getSubcategories($categoryName)
    {
        $subcategories = $this->hrCategoryInterface->getByColumn(['categoryName' => $categoryName]);

        if ($subcategories->isEmpty()) {
            return response()->json([
                'message' => 'No subcategories found.',
            ], 404);
        }

        // Extract unique subCategory names
        $uniqueSubcategories = $subcategories->pluck('subCategory')->unique()->values();

        return response()->json($uniqueSubcategories);
    }


    public function getObservations($subcategories)
    {
        $observations = $this->hrCategoryInterface->getByColumn(['subCategory' => $subcategories]);

        if ($observations->isEmpty()) {
            return response()->json([
                'message' => 'No observations found.',
            ], 404);
        }

        // Extract unique observation types
        $uniqueObservations = $observations->pluck('observationType')->unique()->values();

        return response()->json($uniqueObservations);
    }

}
