<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaCmChemicalManagementRecode\ChemicalManagementRecodeRequest;
use App\Repositories\All\SaCmChemicalManagementRecode\ChemicalManagementRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaCmChemicalManagementRecodeController extends Controller
{

    protected $chemicalManagementRecodeInterface;
    protected $userInterface;

    public function __construct(ChemicalManagementRecodeInterface $chemicalManagementRecodeInterface, UserInterface $userInterface)
    {
        $this->chemicalManagementRecodeInterface = $chemicalManagementRecodeInterface;
        $this->userInterface          = $userInterface;
    }

    public function index()
    {
        $chemical = $this->chemicalManagementRecodeInterface->All();

        $chemical = $chemical->map(function ($chemical) {
            try {
                $reviewer        = $this->userInterface->getById($chemical->reviewerId);
                $chemical->reviewer = $reviewer ? ['name' => $reviewer->name, 'id' => $reviewer->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $chemical->reviewer = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                  = $this->userInterface->getById($chemical->createdByUser);
                $chemical->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $chemical->createdByUserName = 'Unknown';
            }
            return $chemical;
        });

        return response()->json($chemical, 200);
    }

    public function store(ChemicalManagementRecodeRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

        $chemical = $this->chemicalManagementRecodeInterface->create($validatedData);

        if (! $chemical) {
            return response()->json(['message' => 'Failed to create Chemical Management Recode'], 500);
        }
        return response()->json([
            'message'    => 'Chemical Management Recode created successfully!',
            'externalAudit' => $chemical,
        ], 201);
    }

    public function update($id, ChemicalManagementRecodeRequest $request)
    {
        $chemical = $this->chemicalManagementRecodeInterface->findById($id);

        if (! $chemical) {
            return response()->json(['message' => 'Chemical Management Recode not found.'], 404);
        }

        $validatedData = $request->validated();

        $updated = $chemical->update($validatedData);

        if ($updated) {
            return response()->json([
                'message'       => 'Chemical Management Recode updated successfully!',
                'chemical' => $this->chemicalManagementRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the Chemical Management Recode.'], 500);
        }
    }



    public function destroy($id)
    {
        $chemical = $this->chemicalManagementRecodeInterface->findById((int) $id);

        $deleted = $this->chemicalManagementRecodeInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $chemical = $this->chemicalManagementRecodeInterface->getByReviewerId($user->id);

        $chemical = $chemical->map(function ($chemical) {
            try {
                $reviewer        = $this->userInterface->getById($chemical->reviewerId);
                $chemical->reviewer = $reviewer ? ['name' => $reviewer->name, 'id' => $reviewer->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $chemical->reviewer = ['name' => 'Unknown', 'id' => null];
            }


            try {
                $creator                  = $this->userInterface->getById($chemical->createdByUser);
                $chemical->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $chemical->createdByUserName = 'Unknown';
            }
        });

        return response()->json($chemical, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Chemical Management Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }
}
