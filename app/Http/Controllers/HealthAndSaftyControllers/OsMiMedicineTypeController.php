<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMedicineType\MedicineTypeRequest;
use App\Repositories\All\MiMedicineType\medicineTypeInterface;
use Illuminate\Http\Request;

class OsMiMedicineTypeController extends Controller
{
    protected $medicineTypeInterface;

    public function __construct(medicineTypeInterface $medicineTypeInterface)
    {
        $this->medicineTypeInterface = $medicineTypeInterface;
    }

    public function index()
    {
        $medicineType = $this->medicineTypeInterface->All();
        if ($medicineType->isEmpty()) {
            return response()->json([
                'message' => 'Medicine type not found.',
            ]);
        }
        return response()->json($medicineType, 200);
    }

    public function store(MedicineTypeRequest $request)
    {
        $medicineType = $this->medicineTypeInterface->create($request->validated());

        return response()->json([
            'message' => 'Medicine type created successfully.',
            'data'    => $medicineType,
        ], 201);
    }

    public function update(MedicineTypeRequest $request, string $id)
    {
        $medicineType = $this->medicineTypeInterface->findById($id);

        if (! $medicineType) {
            return response()->json([
                'message' => 'Medicine type not found.',
            ]);
        }

        $this->medicineTypeInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Medicine type updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicineType = $this->medicineTypeInterface->findById($id);

        if (! $medicineType) {
            return response()->json([
                'message' => 'Medicine type not found.',
            ]);
        }

        $this->medicineTypeInterface->deleteById($id);

        return response()->json([
            'message' => 'Medicine type deleted successfully.',
        ], 200);
    }
}
