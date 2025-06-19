<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrCountryName\RrCountryNameRequest;
use App\Repositories\All\SaRrCountryName\RrCountryNameInterface;
use Illuminate\Http\Request;

class SaRrCountryNameController extends Controller
{
    protected $rrCountryNameInterface;

    public function __construct(RrCountryNameInterface $rrCountryNameInterface)
    {
        $this->rrCountryNameInterface = $rrCountryNameInterface;
    }

    public function index()
    {
        $countryName = $this->rrCountryNameInterface->All();
        if ($countryName->isEmpty()) {
            return response()->json([
                'message' => 'No Country Name found.',
            ]);
        }
        return response()->json($countryName);
    }

    public function store(RrCountryNameRequest $request)
    {
        $countryName = $this->rrCountryNameInterface->create($request->validated());

        return response()->json([
            'message'  => 'Country Name created successfully!',
            'countryName' => $countryName,
        ], 201);
    }
}
