<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrCategory\RrCategoryRequest;
use App\Repositories\All\SaRrCategory\RrCategoryInterface;
use Illuminate\Http\Request;

class SaRrCategoryController extends Controller
{
    protected $rrCategoryInterface;

    public function __construct(RrCategoryInterface $rrCategoryInterface)
    {
        $this->rrCategoryInterface = $rrCategoryInterface;
    }

    public function index()
    {
        $category = $this->rrCategoryInterface->All();
        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'No Category found.',
            ]);
        }
        return response()->json($category);
    }

    public function store(RrCategoryRequest $request)
    {
        $category = $this->rrCategoryInterface->create($request->validated());

        return response()->json([
            'message'  => 'Category created successfully!',
            'category' => $category,
        ], 201);
    }
}
