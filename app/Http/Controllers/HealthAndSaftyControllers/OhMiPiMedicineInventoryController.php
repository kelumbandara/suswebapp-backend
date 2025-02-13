<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiPiMedicineInventory\MedicineInventoryRequest;
use App\Repositories\All\MedicineDisposal\MedicineDisposalInterface;
use App\Repositories\All\MedicineInventory\MedicineInventoryInterface;

class OhMiPiMedicineInventoryController extends Controller
{
    protected $medicineInventoryInterface;
    protected $medicineDisposalInterface;

    public function __construct(MedicineInventoryInterface $medicineInventoryInterface, MedicineDisposalInterface $medicineDisposalInterface)
    {
        $this->medicineInventoryInterface = $medicineInventoryInterface;
        $this->medicineDisposalInterface  = $medicineDisposalInterface;
    }

    public function index()
    {
        $records = $this->medicineInventoryInterface->All();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No inventory records found']);
        }

        foreach ($records as $record) {
            $record->inventory = $this->medicineDisposalInterface->findByInventoryId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(MedicineInventoryRequest $request)
    {

        $data      = $request->validated();
        $inventory = $this->medicineInventoryInterface->create($data);

        if (! $inventory) {
            return response()->json(['message' => 'Failed to create inventory record'], 500);
        }

        if (! empty($data['disposals'])) {
            foreach ($data['disposals'] as $inventory) {
                $inventory['inventoryId'] = $inventory->id;
                $this->medicineDisposalInterface->create($inventory);
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
            return response()->json(['message' => 'Inventory record not found'] );
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
}
