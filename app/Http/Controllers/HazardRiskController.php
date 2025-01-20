<?php
namespace App\Http\Controllers;

use App\Http\Requests\HealthAndSafety\HazardAndRiskRequest;
use App\Repositories\All\HSHazardRisks\HazardRiskInterface;


class HazardRiskController extends Controller
{
    protected HazardRiskInterface $hazardRiskInterface;

    public function __construct(HazardRiskInterface $hazardRiskInterface)
    {
        $this->hazardRiskInterface = $hazardRiskInterface;
    }

    public function store(HazardAndRiskRequest $request)
{
    $validated = $request->validated();
    $data = $validated;

    if ($request->hasFile('document')) {
        $data['document'] = $request->file('document')->store('documents', 'public');
    }

    $hazardRisk = $this->hazardRiskInterface->create($data);

    return response()->json([
        'message' => 'Hazard/Risk created successfully',
        'data' => $hazardRisk,
        'document_url' => asset('storage/' . $hazardRisk->document)
    ], 201);
}

    public function index()
    {
        $hazardRisks = $this->hazardRiskInterface->all();
        return response()->json($hazardRisks);
    }
    public function update(HazardAndRiskRequest $request, $id)
    {

        $validated = $request->validated();
        $hazardRisk = $this->hazardRiskInterface->update($id, $validated);



        return response()->json([
            'message' => 'Hazard/Risk updated successfully',
            'data' => $hazardRisk,
        ]);
    }
}
