<?php

namespace App\Http\Controllers\SustainabilityApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SustainabilityApps\SDGReportingRequest;
use App\Repositories\All\SDGReporting\SDGReportingInterface;
use Illuminate\Http\Request;

class SDGReportingController extends Controller
{
    protected $sdgReportingInterface;

    public function __construct(SDGReportingInterface $sdgReportingInterface)
    {
        $this->sdgReportingInterface = $sdgReportingInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = $this->sdgReportingInterface->All();

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SDGReportingRequest $request)
    {
        $data = $request->validated();
        $report = $this->sdgReportingInterface->create($data);

        return response()->json([
            'success' => true,
            'message' => 'SDG Reporting created successfully.',
            'data' => $report,
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = $this->sdgReportingInterface->getById($id);

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(SDGReportingRequest  $request, string $id)
    {
        $data = $request->validated();
        $report = $this->sdgReportingInterface->update($id, $data);

        return response()->json([
            'success' => true,
            'message' => 'SDG Reporting updated successfully.',
            'data' => $report,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sdgReportingInterface->deleteById($id);

        return response()->json([
            'success' => true,
            'message' => 'SDG Reporting deleted successfully.',
        ]);
    }
}
