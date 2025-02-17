<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMedicineName\MedicineNameRequest;
use App\Repositories\All\MiMedicineName\MedicineNameInterface;

class OsMiMedicineNameController extends Controller
{
    protected $medicineNameInterface;

    public function __construct(MedicineNameInterface $medicineNameInterface)
    {
        $this->medicineNameInterface = $medicineNameInterface;
    }

    public function index()
    {
        $medicineName = $this->medicineNameInterface->All();
        if ($medicineName->isEmpty()) {
            return response()->json([
                'message' => 'Medicine name not found.',
            ], );
        }
        return response()->json($medicineName, 200);
    }

    public function store(MedicineNameRequest $request)
    {
        $medicineName = $this->medicineNameInterface->create($request->validated());

        return response()->json([
            'message' => 'Medicine name created successfully.',
            'data'    => $medicineName,
        ], 201);
    }

    public function update(MedicineNameRequest $request, string $id)
    {
        $medicineName = $this->medicineNameInterface->findById($id);

        if (! $medicineName) {
            return response()->json([
                'message' => 'Medicine name not found.',
            ]);
        }

        $this->medicineNameInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Medicine name updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicineName = $this->medicineNameInterface->findById($id);

        if (! $medicineName) {
            return response()->json([
                'message' => 'Medicine name not found.',
            ]);
        }

        $this->medicineNameInterface->deleteById($id);

        return response()->json([
            'message' => 'Medicine name deleted successfully.',
        ], 200);
    }
}
