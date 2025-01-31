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
            'message'    => 'category created successfully!',
            'category' => $category,
        ], 201);
    }
}
