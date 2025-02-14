<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HRDivision\HRDivisionRequest;
use App\Repositories\All\HRDivision\HRDivisionInterface;
use Illuminate\Http\Request;

class HrDivisionController extends Controller
{
    protected $hrDivisionInterface;

    public function __construct(HRDivisionInterface $hrDivisionInterface)
    {
        $this->hrDivisionInterface = $hrDivisionInterface;
    }

    public function index()
    {
        $division = $this->hrDivisionInterface->All();
        if ($division->isEmpty()) {
            return response()->json([
                'message' => 'No division found.',
            ]);
        }
        return response()->json($division);
    }

    public function store(HRDivisionRequest $request)
    {
        $division = $this->hrDivisionInterface->create($request->validated());

        return response()->json([
            'message'    => 'division created successfully!',
            'category' => $division,
        ], 201);
    }
}
