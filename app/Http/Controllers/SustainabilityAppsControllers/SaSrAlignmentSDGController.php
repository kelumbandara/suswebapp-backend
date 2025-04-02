<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrAlingmentSDGs\AlingmentSDGsRequest;
use App\Repositories\All\SaSrAlignmentSDG\AlignmentSDGInterface;

class SaSrAlignmentSDGController extends Controller
{
    protected $alignmentSDGInterface;

    public function __construct(AlignmentSDGInterface $alignmentSDGInterface)
    {
        $this->alignmentSDGInterface = $alignmentSDGInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alignment = $this->alignmentSDGInterface->all();
        return response()->json($alignment);
    }

    public function store(AlingmentSDGsRequest $request)
    {
        $data      = $request->validated();
        $alignment = $this->alignmentSDGInterface->create($data);
        return response()->json([
            'message' => 'Alignment created successfully',
            'data'    => $alignment,
        ], 201);
    }
}
