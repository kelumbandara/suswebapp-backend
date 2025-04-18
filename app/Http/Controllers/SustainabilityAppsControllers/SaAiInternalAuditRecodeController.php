<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiInternalAuditRecode\InternalAuditRequest;
use App\Repositories\All\SaAiIaActionPlan\ActionPlanInterface;
use App\Repositories\All\SaAiInternalAuditRecode\InternalAuditRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaAiInternalAuditRecodeController extends Controller
{

    protected $internalAuditRecodeInterface;
    protected $userInterface;
    protected $actionPlanInterface;

    public function __construct(InternalAuditRecodeInterface $internalAuditRecodeInterface, UserInterface $userInterface, ActionPlanInterface $actionPlanInterface)
    {
        $this->internalAuditRecodeInterface = $internalAuditRecodeInterface;
        $this->userInterface                = $userInterface;
        $this->actionPlanInterface          = $actionPlanInterface;
    }

    public function index()
    {
        $internalAudit = $this->internalAuditRecodeInterface->All();

        $internalAudit = $internalAudit->map(function ($audit) {
            try {
                $approver        = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $auditee        = $this->userInterface->getById($audit->auditeeId);
                $audit->auditee = $auditee ? ['name' => $auditee->name, 'id' => $auditee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->auditee = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $creator                  = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }

            return $audit;
        });
        foreach ($internalAudit as $internalAudit) {
            $internalAudit->actionPlan = $this->actionPlanInterface->findByIntarnalAuditId($internalAudit->id);
        }

        return response()->json($internalAudit, 200);
    }

    public function store(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to create internal audit record'], 500);
        }
        return response()->json([
            'message'       => 'Internal audit record created successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function saveDraft(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['draftBy'] = $userId;
        $validatedData['status']  = 'draft';

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to save draft'], 500);
        }

        return response()->json([
            'message'       => 'Draft saved successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function saveSchedualed(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['scheduledBy'] = $userId;
        $validatedData['status']      = 'scheduled';

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to save shedualed'], 500);
        }

        return response()->json([
            'message'       => 'Scheduled saved successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function actionPlanUpdate($id, InternalAuditRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $internalAudit = $this->internalAuditRecodeInterface->findById($id);

        if (! $internalAudit) {
            return response()->json(['message' => 'Internal audit record not found.'], 404);
        }

        $data                = $request->validated();
        $data['completedBy'] = $user->id;

        $updated = $internalAudit->update($data);

        if (! $updated) {
            return response()->json(['message' => 'Failed to update internal audit record'], 500);
        }

        $this->actionPlanInterface->deleteByIntarnalAuditId($id);
        if (! empty($data['actionPlans'])) {
            foreach ($data['actionPlans'] as $actionPlan) {
                $actionPlan['internalAuditId'] = $id;
                $this->actionPlanInterface->create($actionPlan);
            }
        }

        return response()->json([
            'message' => 'Internal audit record and action plans updated successfully',
            'record'  => $this->internalAuditRecodeInterface->findById($id),
        ], 200);
    }

    public function update($id, InternalAuditRequest $request)
    {
        $internalAudit = $this->internalAuditRecodeInterface->findById($id);

        if (! $internalAudit) {
            return response()->json(['message' => 'Internal audit record not found.'], 404);
        }

        $validatedData = $request->validated();

        $updated = $internalAudit->update($validatedData);

        if ($updated) {
            return response()->json([
                'message'       => 'Internal audit record updated successfully!',
                'externalAudit' => $this->internalAuditRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the internal audit record.'], 500);
        }
    }

    public function destroy($id)
    {
        $internalAudit = $this->internalAuditRecodeInterface->findById((int) $id);

        $deleted = $this->internalAuditRecodeInterface->deleteById($id);

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

        $internalAudit = $this->internalAuditRecodeInterface->getByApproverId($user->id);

        $internalAudit = $internalAudit->map(function ($audit) {
            try {
                $approver        = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $auditee        = $this->userInterface->getById($audit->auditeeId);
                $audit->auditee = $auditee ? ['name' => $auditee->name, 'id' => $auditee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->auditee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                  = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }
            return $audit;
        });

        return response()->json($internalAudit, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Internal Audit Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }
}
