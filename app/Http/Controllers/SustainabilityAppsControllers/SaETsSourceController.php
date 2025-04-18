<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaETsSource\TsSourceRequest;
use App\Repositories\All\SaETsSource\TsSourceInterface;
use Illuminate\Http\Request;

class SaETsSourceController extends Controller
{
    protected $sourceInterface;

    public function __construct(TsSourceInterface $sourceInterface)
    {
        $this->sourceInterface = $sourceInterface;
    }

    public function index()
    {
        $source = $this->sourceInterface->all();
        return response()->json($source);
    }

    public function store(TsSourceRequest $request)
    {
        $data    = $request->validated();
        $source = $this->sourceInterface->create($data);
        return response()->json([
            'message' => 'Source created successfully',
            'data'    => $source,
        ], 201);
    }
}
