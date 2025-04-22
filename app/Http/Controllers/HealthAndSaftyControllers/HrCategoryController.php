<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HRCategory\HRCategoryRequest;
use App\Repositories\All\HRCategory\HRCategoryInterface;
use Illuminate\Http\Request;

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
            ]);
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
        $categories = $this->hrCategoryInterface->all(['id', 'categoryName']);

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

    public function getSubcategories($categoryName)
    {
        $subcategories = $this->hrCategoryInterface->getByColumn(['categoryName' => $categoryName], ['id', 'subCategory']);

        if ($subcategories->isEmpty()) {
            return response()->json([
                'message' => 'No subcategories found.',
            ]);
        }

        $uniqueSubcategories = $subcategories->unique('subCategory')->values()->map(function ($item) {
            return [
                'id'          => (int) $item->id,
                'subCategory' => $item->subCategory,
            ];
        });

        return response()->json($uniqueSubcategories);
    }


    public function getObservations($subcategories)
    {
        $observations = $this->hrCategoryInterface->getByColumn(['subCategory' => $subcategories], ['id', 'observationType']);

        if ($observations->isEmpty()) {
            return response()->json([
                'message' => 'No observations found.',
            ]);
        }

        $uniqueObservations = $observations->map(function ($item) {
            return [
                'id'              => $item->id,
                'observationType' => $item->observationType,
            ];
        });

        return response()->json($uniqueObservations);
    }

    public function storeObservation(Request $request)
    {
        $validated = $request->validate([
            'categoryName'    => 'required|string',
            'subCategory'     => 'required|string',
            'observationType' => 'required|string|unique:hs_hr_categories,observationType',
        ]);

        $observation = $this->hrCategoryInterface->create([
            'categoryName'    => $validated['categoryName'],
            'subCategory'     => $validated['subCategory'],
            'observationType' => $validated['observationType'],
        ]);

        return response()->json([
            'message'     => 'Observation type created successfully!',
            'observation' => $observation,
        ], 201);
    }


}
