<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhCsMedicineStock\MedicineStockRequest;
use App\Repositories\All\CsMedicineStock\MedicineStockInterface;
use Illuminate\Http\Request;

class CsMedicineStockController extends Controller
{
    protected $medicineStockInterface;

    public function __construct(MedicineStockInterface $medicineStockInterface)
    {
        $this->medicineStockInterface = $medicineStockInterface;
    }

    public function index()
    {
        $medicineStock = $this->medicineStockInterface->All();
        if ($medicineStock->isEmpty()) {
            return response()->json([
                'message' => 'Medicine stock not found.',
            ], 404);
        }
        return response()->json($medicineStock, 200);
    }

    public function store(MedicineStockRequest $request)
    {
        $medicineStock = $this->medicineStockInterface->create($request->validated());

        return response()->json([
            'message' => 'Medicine stock created successfully.',
            'data'    => $medicineStock,
        ], 201);
    }

    public function update(MedicineStockRequest $request, string $id)
    {
        $medicineStock = $this->medicineStockInterface->findById($id);

        if (! $medicineStock) {
            return response()->json([
                'message' => 'Medicine stock not found.',
            ], 404);
        }

        $this->medicineStockInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Medicine stock updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicineStock = $this->medicineStockInterface->findById($id);

        if (! $medicineStock) {
            return response()->json([
                'message' => 'Medicine stock not found.',
            ], 404);
        }

        $this->medicineStockInterface->deleteById($id);

        return response()->json([
            'message' => 'Medicine stock deleted successfully.',
        ], 200);
    }
}
