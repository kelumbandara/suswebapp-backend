<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEnvirementManagementRecode\EnvirementManagementRecodeRequest;
use App\Repositories\All\SaEmrAddConcumption\AddConcumptionInterface;
use App\Repositories\All\SaEnvirementManagementRecode\EnvirementManagementRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SaEnvirementManagementRecodeController extends Controller
{
    protected $envirementManagementRecodeInterface;
    protected $addConcumptionInterface;
    protected $userInterface;

    public function __construct(EnvirementManagementRecodeInterface $envirementManagementRecodeInterface, AddConcumptionInterface $addConcumptionInterface, UserInterface $userInterface)
    {
        $this->envirementManagementRecodeInterface = $envirementManagementRecodeInterface;
        $this->addConcumptionInterface             = $addConcumptionInterface;
        $this->userInterface                       = $userInterface;
    }

    public function index()
    {
        $records = $this->envirementManagementRecodeInterface->All()->sortByDesc('updated_at')->values();
        $records = $records->map(function ($risk) {
            try {
                $approver = $this->userInterface->getById($risk->approverId);
                if ($approver) {
                    $risk->approver = ['name' => $approver->name, 'id' => $approver->id];
                } else {
                    $risk->approver = ['name' => 'Unknown', 'id' => null];
                }
            } catch (\Exception $e) {
                $risk->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $reviewer = $this->userInterface->getById($risk->reviewerId);
                if ($reviewer) {
                    $risk->reviewer = ['name' => $reviewer->name, 'id' => $reviewer->id];
                } else {
                    $risk->reviewer = ['name' => 'Unknown', 'id' => null];
                }
            } catch (\Exception $e) {
                $risk->reviewer = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        foreach ($records as $record) {
            $record->impactConsumption = $this->addConcumptionInterface->findByEnvirementId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(EnvirementManagementRecodeRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;

        $record = $this->envirementManagementRecodeInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create enviroment management report'], 500);
        }

        if (! empty($data['impactConsumption'])) {
            foreach ($data['impactConsumption'] as $impactConsumption) {
                $impactConsumption['envirementId'] = $record->id;
                $this->addConcumptionInterface->create($impactConsumption);
            }
        }

        return response()->json([
            'message' => 'Enviroment management report created successfully',
            'record'  => $record,
        ], 201);
    }

    public function update(EnvirementManagementRecodeRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->envirementManagementRecodeInterface->findById($id);

        $updateSuccess = $record->update($data);
        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update envirement management report'], 500);
        }

        $this->addConcumptionInterface->deleteByEnvirementId($id);

        if (! empty($data['impactConsumption'])) {
            foreach ($data['impactConsumption'] as $impactConsumption) {
                $impactConsumption['envirementId'] = $id;
                $this->addConcumptionInterface->create($impactConsumption);
            }
        }

        $updatedRecord                = $this->envirementManagementRecodeInterface->findById($id);
        $updatedRecord->impactDetails = $this->addConcumptionInterface->findByEnvirementId($id);

        return response()->json([
            'message' => 'Enviroment management report updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->envirementManagementRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Enviroment management record not found'], 404);
        }

        $this->addConcumptionInterface->deleteByEnvirementId($id);

        $this->envirementManagementRecodeInterface->deleteById($id);

        return response()->json(['message' => 'Enviroment management report deleted successfully'], 200);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $record = $this->envirementManagementRecodeInterface->getByApproverId($user->id)->sortByDesc('updated_at')->values();
        $record = $this->envirementManagementRecodeInterface->getByReviewerId($user->id)->sortByDesc('updated_at')->values();

        $record = $record->map(function ($impactConsumption) {
            try {
                $approver                    = $this->userInterface->getById($impactConsumption->approverId);
                $impactConsumption->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $impactConsumption->approver = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $reviewer                    = $this->userInterface->getById($impactConsumption->reviewerId);
                $impactConsumption->reviewer = $reviewer ? ['name' => $reviewer->name, 'id' => $reviewer->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $impactConsumption->reviewer = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                              = $this->userInterface->getById($impactConsumption->createdByUser);
                $impactConsumption->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $impactConsumption->createdByUserName = 'Unknown';
            }

            return $impactConsumption;
        });

        return response()->json($record, 200);
    }

    public function assignee()
    {
        $user = Auth::user();

        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Environment Management Section')
            ->where('availability', 1)
            ->values();
        return response()->json($assignees);
    }

    public function monthlyCategorySum($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $categorySums = [
            'wasteWater'  => 0,
            'energy'      => 0,
            'water'       => 0,
            'waste'       => 0,
            'ghgEmission' => 0,
        ];

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);

                switch ($category) {
                    case 'wastewater':
                        $categorySums['wasteWater'] += (float) $impact->amount;
                        break;
                    case 'energy':
                        $categorySums['energy'] += (float) $impact->amount;
                        break;
                    case 'water':
                        $categorySums['water'] += (float) $impact->amount;
                        break;
                    case 'waste':
                        $categorySums['waste'] += (float) $impact->amount;
                        break;
                    case 'ghg':
                    case 'ghg emission':
                        $categorySums['ghgEmission'] += (float) $impact->amount;
                        break;
                }
            }
        }

        return response()->json([
            'year'        => $year,
            'month'       => $month,
            'division'    => $division,
            'categorySum' => $categorySums,
        ]);
    }

}
