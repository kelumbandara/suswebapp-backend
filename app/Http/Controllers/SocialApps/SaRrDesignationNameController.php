<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrDesignationName\RrDesignationNameRequest;
use App\Repositories\All\SaRrDesignationName\RrDesignationNameInterface;
use Illuminate\Http\Request;

class SaRrDesignationNameController extends Controller
{
    protected $rrDesignationNameInterface;

    public function __construct(RrDesignationNameInterface $rrDesignationNameInterface)
    {
        $this->rrDesignationNameInterface = $rrDesignationNameInterface;
    }

    public function index()
    {
        $designationName = $this->rrDesignationNameInterface->All();
        if ($designationName->isEmpty()) {
            return response()->json([
                'message' => 'No Designation Name found.',
            ]);
        }
        return response()->json($designationName);
    }

    public function store(RrDesignationNameRequest $request)
    {
        $designationName = $this->rrDesignationNameInterface->create($request->validated());

        return response()->json([
            'message'  => 'Designation Name created successfully!',
            'designationName' => $designationName,
        ], 201);
    }
}
