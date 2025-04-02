<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrMaterialityIssues\MaterialityIssuesRequest;
use App\Repositories\All\SaSrMaterialityIssues\MaterialityIssuesInterface;

class SaSrMaterialityIssuesController extends Controller
{
    protected $materialityIssuesInterface;

    public function __construct(MaterialityIssuesInterface $materialityIssuesInterface)
    {
        $this->materialityIssuesInterface = $materialityIssuesInterface;
    }

    public function index()
    {
        $materialityIssues = $this->materialityIssuesInterface->all();
        return response()->json($materialityIssues);
    }

    public function store(MaterialityIssuesRequest $request)
    {
        $data              = $request->validated();
        $materialityIssues = $this->materialityIssuesInterface->create($data);
        return response()->json([
            'message' => 'Materiality issues created successfully',
            'data'    => $materialityIssues,
        ], 201);
    }
}
