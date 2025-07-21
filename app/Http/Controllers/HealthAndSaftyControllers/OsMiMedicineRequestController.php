<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMedicineRequest\MedicineRequestRequest;
use App\Repositories\All\MedicineInventory\MedicineInventoryInterface;
use App\Repositories\All\MiMedicineRequest\MedicineRequestInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class OsMiMedicineRequestController extends Controller
{
    protected $medicineRequestInterface;
    protected $userInterface;
    protected $medicineInventoryInterface;

    public function __construct(MedicineRequestInterface $medicineRequestInterface, UserInterface $userInterface, MedicineInventoryInterface $medicineInventoryInterface)
    {
        $this->medicineRequestInterface   = $medicineRequestInterface;
        $this->userInterface              = $userInterface;
        $this->medicineInventoryInterface = $medicineInventoryInterface;
    }

    public function index()
    {
        $medicineStock = $this->medicineRequestInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();
        $medicineStock = $medicineStock->map(function ($medicine) {
            try {
                $approver           = $this->userInterface->getById($medicine->approverId);
                $medicine->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $medicine->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                     = $this->userInterface->getById($medicine->createdByUser);
                $medicine->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $medicine->createdByUserName = 'Unknown';
            }

            return $medicine;
        });

        return response()->json($medicineStock, 200);
    }

    public function store(MedicineRequestRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $user->id;

        $medicine = $this->medicineRequestInterface->create($validatedData);

        return response()->json([
            'message' => 'Medicine request created successfully.',
            'data'    => $medicine,
        ], 201);
    }

    public function update(MedicineRequestRequest $request, string $id)
    {
        $medicine = $this->medicineRequestInterface->findById($id);

        if (! $medicine) {
            return response()->json([
                'message' => 'Medicine  request not found.',
            ]);
        }

        $this->medicineRequestInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Medicine request updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicine = $this->medicineRequestInterface->findById($id);

        if (! $medicine) {
            return response()->json([
                'message' => 'Medicine request not found.',
            ]);
        }

        $this->medicineRequestInterface->deleteById($id);

        return response()->json([
            'message' => 'Medicine request deleted successfully.',
        ], 200);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $medicine = $this->medicineRequestInterface->getByAssigneeId($user->id)
            ->filter(function ($risk) {
                return $risk->status !== 'Approved';
            })
            ->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $medicine = $medicine->map(function ($risk) {
            try {
                $approver       = $this->userInterface->getById($risk->approverId);
                $risk->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        return response()->json($medicine, 200);
    }

    public function assignTaskApproved()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $medicine = $this->medicineRequestInterface
            ->all()
            ->filter(function ($med) {
                return $med->status === 'approved';
            })
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

        $medicine = $medicine->map(function ($risk) {
            try {
                $approver       = $this->userInterface->getById($risk->approverId);
                $risk->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        return response()->json($medicine, 200);
    }

    public function approvedStatus(string $id)
    {
        $medicineRequest = $this->medicineRequestInterface->findById($id);

        $this->medicineRequestInterface->update($id, ['status' => 'approved']);

        $inventoryData = [
            'referenceNumber' => $medicineRequest->referenceNumber,
            'medicineName'    => $medicineRequest->medicineName,
            'requestQuantity' => $medicineRequest->requestQuantity,
            'genericName'     => $medicineRequest->genericName,
            'requestedBy'     => $medicineRequest->requestedBy,
            'division'        => $medicineRequest->division,
            'approverId'      => $medicineRequest->approverId,
            'status'          => 'approved',
            'inventoryNumber' => $medicineRequest->inventoryNumber,
        ];

        $this->medicineInventoryInterface->create($inventoryData);

        return response()->json([
            'message' => 'Medicine request approved and added to inventory.',
        ], 200);
    }

    public function updateStatusToApproved(string $id)
    {
        $user = Auth::user();

        if (! $user || $user->assigneeLevel != 5) {
            return response()->json([
                'message' => 'Unauthorized. Only CEO assignees can approve.',
            ], 403);
        }
        $medicineRequest = $this->medicineRequestInterface->findById($id);

        $this->medicineRequestInterface->update($id, ['status' => 'approved']);

        $inventoryData = [
            'referenceNumber' => $medicineRequest->referenceNumber,
            'medicineName'    => $medicineRequest->medicineName,
            'requestQuantity' => $medicineRequest->requestQuantity,
            'genericName'     => $medicineRequest->genericName,
            'requestedBy'     => $medicineRequest->requestedBy,
            'division'        => $medicineRequest->division,
            'approverId'      => $medicineRequest->approverId,
            'status'          => 'approved',
            'inventoryNumber' => $medicineRequest->inventoryNumber,
        ];

        $this->medicineInventoryInterface->create($inventoryData);

        return response()->json([
            'message' => 'Medicine request approved and added to inventory.',
        ], 200);
    }

    public function assignee()
    {
        $user = Auth::user();

        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Medicine Request Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }

}
