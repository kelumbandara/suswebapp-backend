<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardAndRisk\HazardAndRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use App\Repositories\All\HRDivision\HRDivisionInterface;
use App\Repositories\All\User\UserInterface;
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
                $assignee = $this->userInterface->getById($risk->assigneeId);
                $risk->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->assignee = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        return response()->json($hazardRisks, 200);
    }

    public function store(HazardAndRiskRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $userId = $user->id;

        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

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
            ]);
        }

        return response()->json($hazardRisk, 200);
    }

    public function update($id, HazardAndRiskRequest $request)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ]);
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
            ]);
        }

        $this->hazardAndRiskInterface->deleteById($id);

        return response()->json([
            'message' => 'Hazard and risk record deleted successfully!',
        ], 200);
    }
    public function assignTask()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Fetch only the hazard risks assigned to the authenticated user
    $hazardRisks = $this->hazardAndRiskInterface->getByAssigneeId($user->id);

    // Process data to add assignee and creator details
    $hazardRisks = $hazardRisks->map(function ($risk) {
        try {
            $assignee = $this->userInterface->getById($risk->assigneeId);
            $risk->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
        } catch (\Exception $e) {
            $risk->assignee = ['name' => 'Unknown', 'id' => null];
        }

        try {
            $creator = $this->userInterface->getById($risk->createdByUser);
            $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->createdByUserName = 'Unknown';
        }

        return $risk;
    });

    return response()->json($hazardRisks, 200);
}



    public function dashboardStats()
    {
        try {
            $total     = $this->hazardAndRiskInterface->countAll();
            $completed = $this->hazardAndRiskInterface->countByStatus('Completed');
            $pending   = $this->hazardAndRiskInterface->countByStatus('Pending');
            $amount    = $this->hazardAndRiskInterface->sumField('amount'); // Assuming an amount field exists

            return response()->json([
                'total'     => $total,
                'completed' => $completed,
                'pending'   => $pending,
                'amount'    => $amount,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching dashboard stats.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function dashboardStatsByDivision()
    {
        try {
            $divisions = $this->hazardAndRiskInterface->getDistinctDivisions();

            $divisionStats = [];

            foreach ($divisions as $division) {
                $totalCount = $this->hazardAndRiskInterface->countByDivision($division->division);

                $divisionStats[] = [
                    'division' => $division->division,
                    'total'    => $totalCount,
                ];
            }

            return response()->json($divisionStats, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching division-wise stats.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
