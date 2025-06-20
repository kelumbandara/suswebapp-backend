<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaArEmploymentClassification\ArEmploymentClassificationRequest;
use App\Repositories\All\SaArEmploymentClassification\ArEmploymentClassificationInterface;
use Illuminate\Http\Request;

class SaArEmploymentClassificationController extends Controller
{
      protected $arEmploymentClassificationInterface;

    public function __construct(ArEmploymentClassificationInterface $arEmploymentClassificationInterface)
    {
        $this->arEmploymentClassificationInterface = $arEmploymentClassificationInterface;
    }

    public function index()
    {
        $classification = $this->arEmploymentClassificationInterface->All();
        if ($classification->isEmpty()) {
            return response()->json([
                'message' => 'No employment classifications found.',
            ]);
        }
        return response()->json($classification);
    }

    public function store(ArEmploymentClassificationRequest $request)
    {
        $classification = $this->arEmploymentClassificationInterface->create($request->validated());

        return response()->json([
            'message'  => 'Employment classification created successfully!',
            'classification' => $classification,
        ], 201);
    }
}
