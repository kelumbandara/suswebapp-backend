<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiPiMiSupplierType\SupplierTypeRequest;
use App\Repositories\All\OhMiPiSupplierType\SupplierTypeInterface;
use Illuminate\Http\Request;

class OhMiPiMiSupplierTypeController extends Controller
{
    protected $supplierTypeInterface;

    public function __construct(SupplierTypeInterface $supplierTypeInterface)
    {
        $this->supplierTypeInterface = $supplierTypeInterface;
    }

    public function index()
    {
        $supplierType = $this->supplierTypeInterface->All();

        return response()->json($supplierType, 200);
    }

    public function store(SupplierTypeRequest $request)
    {
        $supplierType = $this->supplierTypeInterface->create($request->validated());

        return response()->json([
            'message' => 'Supplier type created successfully.',
            'data'    => $supplierType,
        ], 201);
    }

    public function update(SupplierTypeRequest $request, string $id)
    {
        $supplierType = $this->supplierTypeInterface->findById($id);

        if (! $supplierType) {
            return response()->json([
                'message' => 'Supplier type not found.',
            ], );
        }

        $this->supplierTypeInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Supplier type updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $supplierType = $this->supplierTypeInterface->findById($id);

        if (! $supplierType) {
            return response()->json([
                'message' => 'Supplier type not found.',
            ], );
        }

        $this->supplierTypeInterface->deleteById($id);

        return response()->json([
            'message' => 'Supplier type deleted successfully.',
        ], 200);
    }
}
