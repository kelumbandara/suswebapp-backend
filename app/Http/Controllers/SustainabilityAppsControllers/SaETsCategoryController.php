<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaETsCategory\TsCategoryRequest;
use App\Repositories\All\SaETsCategory\TsCategoryInterface;
use Illuminate\Http\Request;

class SaETsCategoryController extends Controller
{
    protected $categoryInterface;

    public function __construct(TsCategoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }

    public function index()
    {
        $category = $this->categoryInterface->All();
        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ]);
        }
        return response()->json($category);
    }

    public function store(TsCategoryRequest $request)
    {
        $category = $this->categoryInterface->create($request->validated());

        return response()->json([
            'message'  => 'category created successfully!',
            'category' => $category,
        ], 201);
    }

    public function getCategories()
    {
        $categories = $this->categoryInterface->all(['id', 'categoryName']);

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

    public function getPossibleCategories($categoryName)
    {
        $possibilityCategory = $this->categoryInterface->getByColumn(['categoryName' => $categoryName], ['id', 'possibilityCategory']);

        if ($possibilityCategory->isEmpty()) {
            return response()->json([
                'message' => 'No possibilityCategory found.',
            ]);
        }


        $uniquePossibilityCategory = $possibilityCategory->unique('possibilityCategory')->values()->map(function ($item) {
            return [
                'id'          => (int) $item->id,
                'possibilityCategory' => $item->possibilityCategory,
            ];
        });

        return response()->json($uniquePossibilityCategory);
    }


    public function getOppertunities($possibilityCategory)
    {
        $opertunity = $this->categoryInterface->getByColumn(['possibilityCategory' => $possibilityCategory], ['id', 'opertunity']);

        if ($opertunity->isEmpty()) {
            return response()->json([
                'message' => 'No observations found.',
            ]);
        }

        $uniqueOpertunity = $opertunity->map(function ($item) {
            return [
                'id'              => $item->id,
                'opertunity' => $item->opertunity,
            ];
        });

        return response()->json($uniqueOpertunity);
    }

    // public function storeObservation(Request $request)
    // {
    //     $validated = $request->validate([
    //         'categoryName'    => 'required|string|exists:hr_categories,categoryName',
    //         'possibilityCategory'     => 'required|string|exists:hr_categories,possibilityCategory',
    //         'opertunity' => 'required|string|unique:hr_categories,subCategory',
    //     ]);

    //     $existingCategory = $this->categoryInterface->getByColumn([
    //         'categoryName' => $validated['possibilityCategory'],
    //         'subCategory'  => $validated['subCategory'],
    //     ])->first();

    //     if (! $existingCategory) {
    //         return response()->json([
    //             'message' => 'The selected category and subcategory do not match.',
    //         ], 400);
    //     }

    //     $opertunity = $this->categoryInterface->create([
    //         'categoryName'    => $validated['categoryName'],
    //         'subCategory'     => $validated['subCategory'],
    //         'opertunity' => $validated['observationType'],
    //     ]);

    //     return response()->json([
    //         'message'     => 'opertunity type created successfully!',
    //         'opertunity' => $opertunity,
    //     ], 201);
    // }

}
