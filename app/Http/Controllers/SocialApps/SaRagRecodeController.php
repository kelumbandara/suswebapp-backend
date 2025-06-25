<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRagRecord\RagRecordRequest;
use App\Repositories\All\SaRagRecode\RagRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaRagRecodeController extends Controller
{
    protected $ragRecodeInterface;
    protected $userInterface;

    public function __construct(RagRecodeInterface $ragRecodeInterface, UserInterface $userInterface)
    {
        $this->ragRecodeInterface = $ragRecodeInterface;
        $this->userInterface      = $userInterface;
    }

    public function index()
    {
        $record = $this->ragRecodeInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $record = $record->map(function ($risk) {

            try {
                $creator             = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUser = $creator ?? (object) ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->createdByUser = 'Unknown';
            }

            return $risk;
        });

        return response()->json($record, 200);
    }

    public function store(RagRecordRequest $request)
    {

        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

        $record = $this->ragRecodeInterface->create($validatedData);

        return response()->json([
            'message' => 'RAG record created successfully!',
            'record'  => $record,
        ], 201);
    }

    public function update($id, RagRecordRequest $request)
    {
        $record = $this->ragRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'RAG record not found.'], 404);
        }

        $validatedData = $request->validated();
        $updated       = $this->ragRecodeInterface->update($id, $validatedData);

        if ($updated) {
            return response()->json([
                'message' => 'RAG record updated successfully!',
                'record'  => $this->ragRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the RAG record.'], 500);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->ragRecodeInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }

    public function getRagTotalRecord($startDate, $endDate)
    {
        $allRecords       = $this->ragRecodeInterface->filterByParams($startDate, $endDate);
        $filledRagRecords = $allRecords->whereNotNull('rag');

        $totalAll    = $allRecords->count();
        $totalFilled = $filledRagRecords->count();

        $ragCounts = $filledRagRecords->groupBy('rag')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            'totalRecords'  => $totalAll,
            'totalRag'      => $totalFilled,
            'ragPercentage' => $totalAll > 0 ? round(($totalFilled / $totalAll) * 100, 2) : 0,
            'red'           => $ragCounts['red'] ?? ['count' => 0, 'percentage' => 0],
            'amber'         => $ragCounts['amber'] ?? ['count' => 0, 'percentage' => 0],
            'green'         => $ragCounts['green'] ?? ['count' => 0, 'percentage' => 0],
        ]);
    }

    public function getCategoryTotalRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledCategoryRecords = $allRecords->whereNotNull('category');

        $totalFilled = $filledCategoryRecords->count();

        $categoryCounts = $filledCategoryRecords->groupBy('category')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            $categoryCounts,
        ]);
    }

    public function getGenderTotalRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledGenderRecords = $allRecords->whereNotNull('gender');

        $totalFilled = $filledGenderRecords->count();

        $GenderCounts = $filledGenderRecords->groupBy('gender')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            $GenderCounts,
        ]);
    }
    public function getStatusTotalRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledStatusRecords = $allRecords->whereNotNull('status');

        $totalFilled = $filledStatusRecords->count();

        $StatusCounts = $filledStatusRecords->groupBy('status')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            $StatusCounts,
        ]);
    }

    public function getEmployeeTypeRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledEmployeeTypeRecords = $allRecords->whereNotNull('employeeType');

        $totalFilled = $filledEmployeeTypeRecords->count();

        $employeeTypeCounts = $filledEmployeeTypeRecords->groupBy('employeeType')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            $employeeTypeCounts,
        ]);
    }

    public function getStateTotalRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledEmployeeTypeRecords = $allRecords->whereNotNull('state');

        $totalFilled = $filledEmployeeTypeRecords->count();

        $employeeTypeCounts = $filledEmployeeTypeRecords->groupBy('state')->map(function ($group) use ($totalFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalFilled > 0 ? round(($group->count() / $totalFilled) * 100, 2) : 0,
            ];
        });

        return response()->json([
            $employeeTypeCounts,
        ]);
    }

    public function getAgeTotalRecord($startDate, $endDate)
    {
        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filtered = $allRecords->whereNotNull('age')->filter(function ($item) {
            return is_numeric($item->age);
        });

        $total = $filtered->count();

        $ageGroups = [
            '18-28' => 0,
            '29-39' => 0,
            '40-50' => 0,
            '51-61' => 0,
            '62-72' => 0,
            '73-83' => 0,
            '84-94' => 0,
        ];

        foreach ($filtered as $record) {
            $age = (int) $record->age;

            if ($age >= 18 && $age <= 28) {
                $ageGroups['18-28']++;
            } elseif ($age >= 29 && $age <= 39) {
                $ageGroups['29-39']++;
            } elseif ($age >= 40 && $age <= 50) {
                $ageGroups['40-50']++;
            } elseif ($age >= 51 && $age <= 61) {
                $ageGroups['51-61']++;
            } elseif ($age >= 62 && $age <= 72) {
                $ageGroups['62-72']++;
            } elseif ($age >= 73 && $age <= 83) {
                $ageGroups['73-83']++;
            } elseif ($age >= 84 && $age <= 94) {
                $ageGroups['84-94']++;
            }
        }

        $formatted = [];
        foreach ($ageGroups as $range => $count) {
            $formatted[$range] = [
                'count'      => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 2) : 0,
            ];
        }

        return response()->json([
            'totalAge'        => $total,
            'ageGroupSummary' => $formatted,
        ]);
    }

    public function getAllSummary($year)
    {
        $startDate = \Carbon\Carbon::parse("$year-01-01");
        $endDate   = \Carbon\Carbon::parse("$year-12-31");

        $allRecords = $this->ragRecodeInterface->filterByParams($startDate, $endDate);

        $filledRagRecords = $allRecords->whereNotNull('rag');
        $totalRagAll      = $allRecords->count();
        $totalRagFilled   = $filledRagRecords->count();
        $ragCounts        = $filledRagRecords->groupBy('rag')->map(function ($group) use ($totalRagFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalRagFilled > 0 ? round(($group->count() / $totalRagFilled) * 100, 2) : 0,
            ];
        });

        $filledCategoryRecords = $allRecords->whereNotNull('category');
        $totalCategoryFilled   = $filledCategoryRecords->count();
        $categoryCounts        = $filledCategoryRecords->groupBy('category')->map(function ($group) use ($totalCategoryFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalCategoryFilled > 0 ? round(($group->count() / $totalCategoryFilled) * 100, 2) : 0,
            ];
        });

        $filledGenderRecords = $allRecords->whereNotNull('gender');
        $totalGenderFilled   = $filledGenderRecords->count();
        $genderCounts        = $filledGenderRecords->groupBy('gender')->map(function ($group) use ($totalGenderFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalGenderFilled > 0 ? round(($group->count() / $totalGenderFilled) * 100, 2) : 0,
            ];
        });

        $filledStatusRecords = $allRecords->whereNotNull('status');
        $totalStatusFilled   = $filledStatusRecords->count();
        $statusCounts        = $filledStatusRecords->groupBy('status')->map(function ($group) use ($totalStatusFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalStatusFilled > 0 ? round(($group->count() / $totalStatusFilled) * 100, 2) : 0,
            ];
        });

        $filledEmpTypeRecords = $allRecords->whereNotNull('employeeType');
        $totalEmpTypeFilled   = $filledEmpTypeRecords->count();
        $empTypeCounts        = $filledEmpTypeRecords->groupBy('employeeType')->map(function ($group) use ($totalEmpTypeFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalEmpTypeFilled > 0 ? round(($group->count() / $totalEmpTypeFilled) * 100, 2) : 0,
            ];
        });

        $filledStateRecords = $allRecords->whereNotNull('state');
        $totalStateFilled   = $filledStateRecords->count();
        $stateCounts        = $filledStateRecords->groupBy('state')->map(function ($group) use ($totalStateFilled) {
            return [
                'count'      => $group->count(),
                'percentage' => $totalStateFilled > 0 ? round(($group->count() / $totalStateFilled) * 100, 2) : 0,
            ];
        });

        $filteredAgeRecords = $allRecords->whereNotNull('age')->filter(function ($item) {
            return is_numeric($item->age);
        });
        $totalAgeFilled = $filteredAgeRecords->count();

        $ageGroups = [
            '18-28' => 0,
            '29-39' => 0,
            '40-50' => 0,
            '51-61' => 0,
            '62-72' => 0,
            '73-83' => 0,
            '84-94' => 0,
        ];
        foreach ($filteredAgeRecords as $record) {
            $age = (int) $record->age;
            if ($age >= 18 && $age <= 28) {
                $ageGroups['18-28']++;
            } elseif ($age >= 29 && $age <= 39) {
                $ageGroups['29-39']++;
            } elseif ($age >= 40 && $age <= 50) {
                $ageGroups['40-50']++;
            } elseif ($age >= 51 && $age <= 61) {
                $ageGroups['51-61']++;
            } elseif ($age >= 62 && $age <= 72) {
                $ageGroups['62-72']++;
            } elseif ($age >= 73 && $age <= 83) {
                $ageGroups['73-83']++;
            } elseif ($age >= 84 && $age <= 94) {
                $ageGroups['84-94']++;
            }
        }
        $ageCounts = [];
        foreach ($ageGroups as $range => $count) {
            $ageCounts[$range] = [
                'count'      => $count,
                'percentage' => $totalAgeFilled > 0 ? round(($count / $totalAgeFilled) * 100, 2) : 0,
            ];
        }

        return response()->json([
            'year'                => $year,
            'ragSummary'          => [
                'totalRecords'  => $totalRagAll,
                'totalRag'      => $totalRagFilled,
                'ragPercentage' => $totalRagAll > 0 ? round(($totalRagFilled / $totalRagAll) * 100, 2) : 0,
                'red'           => $ragCounts['red'] ?? ['count' => 0, 'percentage' => 0],
                'amber'         => $ragCounts['amber'] ?? ['count' => 0, 'percentage' => 0],
                'green'         => $ragCounts['green'] ?? ['count' => 0, 'percentage' => 0],
            ],
            'categorySummary'     => $categoryCounts,
            'genderSummary'       => $genderCounts,
            'statusSummary'       => $statusCounts,
            'employeeTypeSummary' => $empTypeCounts,
            'stateSummary'        => $stateCounts,
            'ageGroupSummary'     => [
                'totalAge' => $totalAgeFilled,
                'groups'   => $ageCounts,
            ],
        ]);
    }

}
