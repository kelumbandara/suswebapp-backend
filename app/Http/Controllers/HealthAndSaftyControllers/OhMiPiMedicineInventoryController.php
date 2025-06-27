<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiPiMedicineInventory\MedicineInventoryRequest;
use App\Repositories\All\CsMedicineStock\MedicineStockInterface;
use App\Repositories\All\MedicineDisposal\MedicineDisposalInterface;
use App\Repositories\All\MedicineInventory\MedicineInventoryInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class OhMiPiMedicineInventoryController extends Controller
{
    protected $medicineInventoryInterface;
    protected $medicineDisposalInterface;
    protected $userInterface;
    protected $medicineStockInterface;

    public function __construct(MedicineInventoryInterface $medicineInventoryInterface, MedicineDisposalInterface $medicineDisposalInterface, UserInterface $userInterface, MedicineStockInterface $medicineStockInterface)
    {
        $this->medicineInventoryInterface = $medicineInventoryInterface;
        $this->medicineDisposalInterface  = $medicineDisposalInterface;
        $this->userInterface              = $userInterface;
        $this->medicineStockInterface     = $medicineStockInterface;
    }

    public function index()
    {
        $records = $this->medicineInventoryInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();
        $records = $records->map(function ($risk) {

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });
        foreach ($records as $record) {
            $record->inventory = $this->medicineDisposalInterface->findByInventoryId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(MedicineInventoryRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;

        $inventory = $this->medicineInventoryInterface->create($data);

        if (! $inventory) {
            return response()->json(['message' => 'Failed to create inventory record'], 500);
        }

        $inventoryId = $inventory->id;

        if (! empty($data['disposals'])) {
            foreach ($data['disposals'] as $disposal) {
                $disposal['inventoryId'] = $inventoryId;
                $this->medicineDisposalInterface->create($disposal);
            }
        }

        return response()->json([
            'message' => 'Inventory record created successfully',
            'record'  => $inventory,
        ], 201);
    }

    public function show(string $id)
    {
        $inventory = $this->medicineInventoryInterface->findById($id);
        if (! $inventory) {
            return response()->json(['message' => 'Inventory record not found']);
        }
        return response()->json($inventory);
    }

    public function update(MedicineInventoryRequest $request, string $id)
    {
        $data      = $request->validated();
        $inventory = $this->medicineInventoryInterface->findById($id);

        if (! $inventory || ! is_object($inventory)) {
            return response()->json(['message' => 'Inventory record not found']);
        }

        $updateSuccess = $this->medicineInventoryInterface->update($id, $data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update inventory record'], 500);
        }

        $updatedInventory = $this->medicineInventoryInterface->findById($id);

        if (! $updatedInventory || ! is_object($updatedInventory)) {
            return response()->json(['message' => 'Error fetching updated inventory record'], 500);
        }

        $this->medicineDisposalInterface->deleteByInventoryId($id);

        if (! empty($data['disposals'])) {
            foreach ($data['disposals'] as $inventory) {
                $inventory['inventoryId'] = $id;
                $this->medicineDisposalInterface->create($inventory);
            }
        }

        $updatedInventory->inventory = $this->medicineDisposalInterface->findByInventoryId($id);

        return response()->json([
            'message' => 'Inventory record updated successfully',
            'record'  => $updatedInventory,
        ], 200);
    }

    public function destroy(string $id)
    {
        $inventory = $this->medicineInventoryInterface->findById($id);

        if (! $inventory) {
            return response()->json(['message' => 'Inventory record not found']);
        }

        $this->medicineDisposalInterface->deleteByInventoryId($id);

        $this->medicineInventoryInterface->deleteById($id);

        return response()->json(['message' => 'Inventory record deleted successfully'], 200);
    }


    public function publishedStatus(MedicineInventoryRequest $request, string $id)
{
    $validatedData = $request->validated();

    $medicineStock = $this->medicineInventoryInterface->findById($id);

    if (!$medicineStock) {
        return response()->json(['message' => 'Medicine stock not found.'], 404);
    }

    $medicineStock->update($validatedData);

    $inventoryData = [
        'medicineName'      => $medicineStock->medicineName,
        'inStock'           => $medicineStock->issuedQuantity ?? 0,  // Default to 0 if null
        'division'          => $medicineStock->division,
        'status'            => $medicineStock->status, // Using updated status
        'responsibleSection'=> $medicineStock->responsibleSection,
        'assigneeLevel'     => $medicineStock->assigneeLevel,
    ];

    $this->medicineStockInterface->create($inventoryData);

    return response()->json([
        'message' => 'Medicine inventory published and added to medicine stock.',
    ], 200);
}

    public function published()
{
    $records = $this->medicineInventoryInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

    $records = $records->filter(function ($record) {
        return $record->status === 'published';
    });

    $records = $records->map(function ($risk) {
        try {
            $creator = $this->userInterface->getById($risk->createdByUser);
            $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->createdByUserName = 'Unknown';
        }
        return $risk;
    });

   

    return response()->json($records, 200);
}

}
