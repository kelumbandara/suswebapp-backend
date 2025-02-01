<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardAndRisk\HazardAndRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use Carbon\Carbon;

class HazardAndRiskController extends Controller
{

    protected $hazardAndRiskInterface;

    public function __construct(HazardAndRiskInterface $hazardAndRiskInterface)
    {
        $this->hazardAndRiskInterface = $hazardAndRiskInterface;
    }

    public function index()
    {
        $hazardRisks = $this->hazardAndRiskInterface->All();
        if ($hazardRisks->isEmpty()) {
            return response()->json([
                'message' => 'No hazard and risk records found.',
            ], 404);
        }

        return response()->json($hazardRisks, 200);
    }

    public function store(HazardAndRiskRequest $request)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['dueDate'])) {
            $validatedData['dueDate'] = Carbon::parse($validatedData['dueDate'])->toDateTimeString();
        }

        if (isset($validatedData['serverDateAndTime'])) {
            $validatedData['serverDateAndTime'] = Carbon::parse($validatedData['serverDateAndTime'])->toDateTimeString();
        }

        $hazardRisk = $this->hazardAndRiskInterface->create($validatedData);

        return response()->json([
            'message'    => 'Hazard and risk record created successfully!',
            'hazardRisk' => $hazardRisk,
        ], 201);
    }

    public function show($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        return response()->json($hazardRisk, 200);
    }

    public function update($id, HazardAndRiskRequest $request)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        $validatedData = $request->validated();
        $hazardRisk    = $this->hazardAndRiskInterface->update($id, $validatedData);

        return response()->json([
            'message'    => 'Hazard and risk record updated successfully!',
            'hazardRisk' => $hazardRisk,
        ], 201);
    }

    public function destroy($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        $this->hazardAndRiskInterface->deleteById($id);

        return response()->json([
            'message' => 'Hazard and risk record deleted successfully!',
        ], 200);
    }
    public function edit($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        return response()->json($hazardRisk, 200);
    }

}
