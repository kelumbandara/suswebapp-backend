<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaGrCategory\GrCategoryRequest;
use App\Repositories\All\SaGrCategory\GrCategoryInterface;

class SaGrCategoryController extends Controller
{
    protected $grCategoryInterface;

    public function __construct(GrCategoryInterface $grCategoryInterface)
    {
        $this->grCategoryInterface = $grCategoryInterface;
    }

    public function index()
    {
        $category = $this->grCategoryInterface->All();
        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'No category found.',
            ]);
        }
        return response()->json($category);
    }

    public function store(GrCategoryRequest $request)
    {
        $category = $this->grCategoryInterface->create($request->validated());

        return response()->json([
            'message'  => 'Category created successfully!',
            'category' => $category,
        ], 201);
    }
}
