<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrEmploymentType\RrEmploymentTypeRequest;
use App\Repositories\All\SaRrEmploymentType\RrEmploymentTypeInterface;
use Illuminate\Http\Request;

class SaRrEmploymentTypeController extends Controller
{
    protected $rrEmploymentTypeInterface;

    public function __construct(RrEmploymentTypeInterface $rrEmploymentTypeInterface)
    {
        $this->rrEmploymentTypeInterface = $rrEmploymentTypeInterface;
    }

    public function index()
    {
        $employmentType = $this->rrEmploymentTypeInterface->All();
        if ($employmentType->isEmpty()) {
            return response()->json([
                'message' => 'No Employment Type found.',
            ]);
        }
        return response()->json($employmentType);
    }

    public function store(RrEmploymentTypeRequest $request)
    {
        $employmentType = $this->rrEmploymentTypeInterface->create($request->validated());

        return response()->json([
            'message'  => 'Employment Type created successfully!',
            'employmentType' => $employmentType,
        ], 201);
    }
}
