<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrSDG\SDGRequest;
use App\Repositories\All\SaSrSDG\SrSdgInterface;

class SaSrSDGController extends Controller
{
    protected $SdgInterface;

    public function __construct(SrSdgInterface $SdgInterface)
    {
        $this->SdgInterface = $SdgInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sdg = $this->SdgInterface->all();
        return response()->json($sdg);
    }

    public function store(SDGRequest $request)
    {
        $data = $request->validated();
        $sdg  = $this->SdgInterface->create($data);
        return response()->json([
            'message' => 'SDG created successfully',
            'data'    => $sdg,
        ], 201);
    }
}
