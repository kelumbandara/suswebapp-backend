<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardAndRisk\HazardAndRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use App\Repositories\All\HRDivision\HRDivisionInterface;
use App\Repositories\All\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HazardAndRiskController extends Controller
{

    protected $hazardAndRiskInterface;
    protected $userInterface;
    protected $HRDivisionInterface;

    public function __construct(HazardAndRiskInterface $hazardAndRiskInterface, UserInterface $userInterface, HRDivisionInterface $HRDivisionInterface)
    {
        $this->hazardAndRiskInterface = $hazardAndRiskInterface;
        $this->userInterface          = $userInterface;
        $this->HRDivisionInterface    = $HRDivisionInterface;
    }

    public function index()
{
    $hazardRisks = $this->hazardAndRiskInterface->All();

    $hazardRisks = $hazardRisks->map(function ($risk) {
        try {
            $assignee = $this->userInterface->getById($risk->assignee);
            $risk->assigneeName = $assignee ? $assignee->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->assigneeName = 'Unknown';
        }

        try {
            $creator = $this->userInterface->getById($risk->createdByUser);
            $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->createdByUserName = 'Unknown';
        }

        return $risk;
    });

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

        if (!$hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ], 404);
        }

        $validatedData = $request->validated();

        $updated = $this->hazardAndRiskInterface->update($id, $validatedData);

        if ($updated) {
            $hazardRisk = $this->hazardAndRiskInterface->findById($id);

            return response()->json([
                'message'    => 'Hazard and risk record updated successfully!',
                'hazardRisk' => $hazardRisk,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed to update the hazard and risk record.',
            ], 500);
        }
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
