<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrAdditionalSDG\AdditionalSDGRequest;
use App\Repositories\All\SaSrAdditionalSDG\AdditionalSDGInterface;

class SaSrAdditionalSDGController extends Controller
{
    protected $additionalSDGInterface;

    public function __construct(AdditionalSDGInterface $additionalSDGInterface)
    {
        $this->additionalSDGInterface = $additionalSDGInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $additionalSDG = $this->additionalSDGInterface->all();
        return response()->json($additionalSDG);
    }

    public function store(AdditionalSDGRequest $request)
    {
        $data          = $request->validated();
        $additionalSDG = $this->additionalSDGInterface->create($data);
        return response()->json([
            'message' => 'Additional SDG created successfully',
            'data'    => $additionalSDG,
        ], 201);
    }
}
