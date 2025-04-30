<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEnvirementManagementRecode\EnvirementManagementRecodeRequest;
use App\Repositories\All\SaEmrAddConcumption\AddConcumptionInterface;
use App\Repositories\All\SaEnvirementManagementRecode\EnvirementManagementRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

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
        $records = $this->envirementManagementRecodeInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();
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

        $record = $this->envirementManagementRecodeInterface->getByApproverId($user->id)->sortByDesc('created_at')->sortByDesc('updated_at')->values();
        $record = $this->envirementManagementRecodeInterface->getByReviewerId($user->id)->sortByDesc('created_at')->sortByDesc('updated_at')->values();

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

    public function monthlyCategoryQuantitySum($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $categorySums = [
            'wasteWater'  => 0,
            'energy'      => 0,
            'water'       => 0,
            'waste'       => 0,
            'ghgEmission' => 0,
            'amount'      => 0,
        ];

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;
                $amount   = is_numeric($impact->amount) ? (float) $impact->amount : 0;

                switch ($category) {
                    case 'wastewater':
                    case 'waste water':
                        $categorySums['wasteWater'] += $quantity;
                        break;
                    case 'energy':
                        $categorySums['energy'] += $quantity;
                        break;
                    case 'water':
                        $categorySums['water'] += $quantity;
                        break;
                    case 'waste':
                        $categorySums['waste'] += $quantity;
                        break;
                    case 'ghg':
                    case 'ghg emission':
                        $categorySums['ghgEmission'] += $quantity;
                        break;
                }

                $categorySums['amount'] += $amount;
            }
        }

        return response()->json([
            'year'        => $year,
            'month'       => $month,
            'division'    => $division,
            'categorySum' => $categorySums,
        ]);
    }


    public function yearlyCategoryQuantitySum($year, $division)
    {
        $allMonthlyData = [];

        $monthNames = [
        1  => 'January',  2  => 'February', 3  => 'March',
        4  => 'April',    5  => 'May',      6  => 'June',
        7  => 'July',     8  => 'August',   9  => 'September',
        10 => 'October', 11 => 'November', 12 => 'December',
        ];

        for ($month = 1; $month <= 12; $month++) {
            $fullMonthName = $monthNames[$month];
            $shortMonthName = substr($fullMonthName, 0, 3);


            $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $fullMonthName, $division);

            $categorySums = [
                'month'       => $shortMonthName,
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
                    $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                    switch ($category) {
                        case 'wastewater':
                        case 'waste water':
                            $categorySums['wasteWater'] += $quantity;
                            break;
                        case 'energy':
                            $categorySums['energy'] += $quantity;
                            break;
                        case 'water':
                            $categorySums['water'] += $quantity;
                            break;
                        case 'waste':
                            $categorySums['waste'] += $quantity;
                            break;
                        case 'ghg':
                        case 'ghg emission':
                            $categorySums['ghgEmission'] += $quantity;
                            break;
                    }
                }
            }

            $allMonthlyData[] = $categorySums;
        }

        return response()->json([
            'year'        => $year,
            'division'    => $division,
            'monthlyData' => $allMonthlyData,
        ]);
    }

    public function categorySourceQuantitySum($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $result = [];

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = $impact->category;
                $source   = $impact->source;
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                if (! isset($result[$category])) {
                    $result[$category] = [];
                }

                if (! isset($result[$category][$source])) {
                    $result[$category][$source] = 0;
                }

                $result[$category][$source] += $quantity;
            }
        }

        return response()->json([
            'year'     => $year,
            'month'    => $month,
            'division' => $division,
            'data'     => $result,
        ]);
    }

    public function scopeQuantitySumByFilter($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $scopeSums = [];

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $scope    = $impact->scope;
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                if (! isset($scopeSums[$scope])) {
                    $scopeSums[$scope] = 0;
                }

                $scopeSums[$scope] += $quantity;
            }
        }

        return response()->json([
            'year'             => $year,
            'month'            => $month,
            'division'         => $division,
            'scopeQuantitySum' => $scopeSums,
        ]);
    }

    public function yearlyScopeQuantitySum($year, $division)
    {
        $allMonthlyData = [];

        $monthNames = [
            1  => 'January',  2  => 'February', 3  => 'March',
            4  => 'April',    5  => 'May',      6  => 'June',
            7  => 'July',     8  => 'August',   9  => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        for ($month = 1; $month <= 12; $month++) {
            $fullMonthName = $monthNames[$month];
            $shortMonthName = substr($fullMonthName, 0, 3);

            $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $fullMonthName, $division);

            $scopeSums = [];

            foreach ($filteredRecords as $record) {
                $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

                foreach ($impacts as $impact) {
                    $scope    = $impact->scope;
                    $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                    if (! isset($scopeSums[$scope])) {
                        $scopeSums[$scope] = 0;
                    }

                    $scopeSums[$scope] += $quantity;
                }
            }

            $allMonthlyData[] = [
                'month'         => $shortMonthName,
                'scopeQuantity' => $scopeSums,
            ];
        }

        return response()->json([
            'year'         => $year,
            'division'     => $division,
            'monthlyScope' => $allMonthlyData,
        ]);
    }

    public function categoryWaterToWastePercentage($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $totalWater = 0;
        $totalWaste = 0;

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                if ($category === 'water') {
                    $totalWater += $quantity;
                } elseif ($category === 'waste water') {
                    $totalWaste += $quantity;
                }
            }
        }

        $percentage = 0;
        if ($totalWaste > 0) {
            $percentage = ($totalWaste / $totalWater) * 100;
        }

        return response()->json([
            'year'                   => $year,
            'month'                  => $month,
            'division'               => $division,
            'totalWater'             => $totalWater,
            'totalWasteWater'        => $totalWaste,
            'waterToWastePercentage' => $percentage,
        ]);
    }

    public function categoryWasteWaterDetails($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $totalWasteWater = 0;
        $totalReused     = 0;
        $totalRecycled   = 0;

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);
                $source   = strtolower($impact->source);
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                if ($category === 'waste water') {
                    $totalWasteWater += $quantity;

                    if ($source === 'reuse') {
                        $totalReused += $quantity;
                    } elseif ($source === 'recycle') {
                        $totalRecycled += $quantity;
                    }
                }
            }
        }
        $reusePercentage   = $totalWasteWater > 0 ? ($totalReused / $totalWasteWater) * 100 : 0;
        $recyclePercentage = $totalWasteWater > 0 ? ($totalRecycled / $totalWasteWater) * 100 : 0;

        return response()->json([
            'year'              => $year,
            'month'             => $month,
            'division'          => $division,
            'totalWasteWater'   => $totalWasteWater,
            'totalReused'       => $totalReused,
            'totalRecycled'     => $totalRecycled,
            'reusePercentage'   => round($reusePercentage, 2),
            'recyclePercentage' => round($recyclePercentage, 2),
        ]);
    }

    public function categoryEnergyRenewableDetails($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $totalEnergy    = 0;
        $totalRenewable = 0;

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);
                $source   = strtolower($impact->source);
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;

                if ($category === 'energy') {
                    $totalEnergy += $quantity;

                    if ($source === 'renewable energy') {
                        $totalRenewable += $quantity;
                    }
                }
            }
        }

        $renewablePercentage = $totalEnergy > 0 ? ($totalRenewable / $totalEnergy) * 100 : 0;

        return response()->json([
            'year'                 => $year,
            'month'                => $month,
            'division'             => $division,
            'totalEnergy'          => $totalEnergy,
            'totalRenewableEnergy' => $totalRenewable,
            'renewablePercentage'  => round($renewablePercentage, 2),
        ]);
    }

    public function categoryRecordCount($year, $month, $division)
    {
        $filteredRecords = $this->envirementManagementRecodeInterface->filterByYearMonthDivision($year, $month, $division);

        $categoryCounts = [];

        foreach ($filteredRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);

                if (! isset($categoryCounts[$category])) {
                    $categoryCounts[$category] = 0;
                }

                $categoryCounts[$category]++;
            }
        }

        return response()->json([
            'year'           => $year,
            'month'          => $month,
            'division'       => $division,
            'categoryCounts' => $categoryCounts,
        ]);
    }


    public function allSummaryData($year)
    {

        $allRecords = $this->envirementManagementRecodeInterface->filterByYear($year);

        $categorySums = [
            'wasteWater'  => 0,
            'energy'      => 0,
            'water'       => 0,
            'waste'       => 0,
            'ghgEmission' => 0,
            'amount'      => 0,
        ];

        $categoryCounts     = [];
        $scopeSums          = [];
        $result             = [];
        $totalEnergy        = 0;
        $totalRenewable     = 0;
        $totalWater         = 0;
        $totalWaste         = 0;
        $totalWasteWater    = 0;
        $totalReused        = 0;
        $totalRecycled      = 0;

        foreach ($allRecords as $record) {
            $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

            foreach ($impacts as $impact) {
                $category = strtolower($impact->category);
                $source   = strtolower($impact->source);
                $scope    = $impact->scope;
                $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;
                $amount   = is_numeric($impact->amount) ? (float) $impact->amount : 0;

                switch ($category) {
                    case 'wastewater':
                    case 'waste water':
                        $categorySums['wasteWater'] += $quantity;
                        $totalWasteWater += $quantity;
                        if ($source === 'reuse') {
                            $totalReused += $quantity;
                        } elseif ($source === 'recycle') {
                            $totalRecycled += $quantity;
                        }
                        break;
                    case 'energy':
                        $categorySums['energy'] += $quantity;
                        $totalEnergy += $quantity;
                        if ($source === 'renewable energy') {
                            $totalRenewable += $quantity;
                        }
                        break;
                    case 'water':
                        $categorySums['water'] += $quantity;
                        $totalWater += $quantity;
                        break;
                    case 'waste':
                        $categorySums['waste'] += $quantity;
                        $totalWaste += $quantity;
                        break;
                    case 'ghg':
                    case 'ghg emission':
                        $categorySums['ghgEmission'] += $quantity;
                        break;
                }

                $categorySums['amount'] += $amount;

                if (! isset($categoryCounts[$category])) {
                    $categoryCounts[$category] = 0;
                }
                $categoryCounts[$category]++;

                if (! isset($scopeSums[$scope])) {
                    $scopeSums[$scope] = 0;
                }
                $scopeSums[$scope] += $quantity;

                if (! isset($result[$category])) {
                    $result[$category] = [];
                }
                if (! isset($result[$category][$source])) {
                    $result[$category][$source] = 0;
                }
                $result[$category][$source] += $quantity;
            }
        }

        $renewablePercentage = $totalEnergy > 0 ? ($totalRenewable / $totalEnergy) * 100 : 0;
        $reusePercentage     = $totalWasteWater > 0 ? ($totalReused / $totalWasteWater) * 100 : 0;
        $recyclePercentage   = $totalWasteWater > 0 ? ($totalRecycled / $totalWasteWater) * 100 : 0;
        $waterToWastePercent = $totalWater > 0 ? ($totalWasteWater / $totalWater) * 100 : 0;

        $monthNames = [
            1  => 'January',  2  => 'February', 3  => 'March',
            4  => 'April',    5  => 'May',      6  => 'June',
            7  => 'July',     8  => 'August',   9  => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $yearlyScopeMonthly = [];
        $yearlyCategoryMonthly = [];

        for ($month = 1; $month <= 12; $month++) {
            $fullMonthName = $monthNames[$month];
            $shortMonthName = substr($fullMonthName, 0, 3);

            $records = $this->envirementManagementRecodeInterface->filterByYearAndMonth($year, $fullMonthName);

            $scopeSumsPerMonth = [];
            $categorySumsPerMonth = [
                'month'       => $shortMonthName,
                'wasteWater'  => 0,
                'energy'      => 0,
                'water'       => 0,
                'waste'       => 0,
                'ghgEmission' => 0,
                'amount'      => 0,
            ];

            foreach ($records as $record) {
                $impacts = $this->addConcumptionInterface->findByEnvirementId($record->id);

                foreach ($impacts as $impact) {
                    $scope    = $impact->scope;
                    $category = strtolower($impact->category);
                    $quantity = is_numeric($impact->quantity) ? (float) $impact->quantity : 0;
                    $amount   = is_numeric($impact->amount) ? (float) $impact->amount : 0;

                    if (! isset($scopeSumsPerMonth[$scope])) {
                        $scopeSumsPerMonth[$scope] = 0;
                    }
                    $scopeSumsPerMonth[$scope] += $quantity;

                    switch ($category) {
                        case 'wastewater':
                        case 'waste water':
                            $categorySumsPerMonth['wasteWater'] += $quantity;
                            break;
                        case 'energy':
                            $categorySumsPerMonth['energy'] += $quantity;
                            break;
                        case 'water':
                            $categorySumsPerMonth['water'] += $quantity;
                            break;
                        case 'waste':
                            $categorySumsPerMonth['waste'] += $quantity;
                            break;
                        case 'ghg':
                        case 'ghg emission':
                            $categorySumsPerMonth['ghgEmission'] += $quantity;
                            break;
                    }

                    $categorySumsPerMonth['amount'] += $amount;
                }
            }

            $yearlyScopeMonthly[] = [
                'month'         => $shortMonthName,
                'scopeQuantity' => $scopeSumsPerMonth,
            ];

            $yearlyCategoryMonthly[] = $categorySumsPerMonth;
        }

        return response()->json([
            'year'                   => $year,
            'categoryCounts'         => $categoryCounts,
            'categorySum'            => $categorySums,
            'categorySourceSummary'  => $result,
            'scopeQuantitySum'       => $scopeSums,

            'totalEnergy'            => $totalEnergy,
            'totalRenewableEnergy'   => $totalRenewable,
            'renewablePercentage'    => round($renewablePercentage, 2),

            'totalWater'             => $totalWater,
            'totalWasteWater'        => $totalWasteWater,
            'waterToWastePercentage' => round($waterToWastePercent, 2),

            'totalReused'            => $totalReused,
            'totalRecycled'          => $totalRecycled,
            'reusePercentage'        => round($reusePercentage, 2),
            'recyclePercentage'      => round($recyclePercentage, 2),

            'yearlyScopeSummary'     => $yearlyScopeMonthly,
            'yearlyCategorySummary'  => $yearlyCategoryMonthly,
        ]);
    }


}
