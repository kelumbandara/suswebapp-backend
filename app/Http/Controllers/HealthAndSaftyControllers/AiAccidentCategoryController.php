<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentCategory\AccidentCategoryRequest;
use App\Repositories\All\AccidentCategory\AccidentCategoryInterface;

class AiAccidentCategoryController extends Controller
{
    protected $accidentCategoryInterface;

    /**
     * Inject the AccidentPeopleInterface dependency.
     */
    public function __construct(AccidentCategoryInterface $accidentCategoryInterface)
    {
        $this->accidentCategoryInterface = $accidentCategoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = $this->accidentCategoryInterface->all();
        return response()->json($category);
    }


    public function store(AccidentCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->accidentCategoryInterface->create($data);
        return response()->json([
            'message' => 'Accident category created successfully',
            'data' => $category
        ], 201);
    }

}
