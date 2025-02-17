<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiPiMiSupplierName\SupplierNameRequest;
use App\Repositories\All\OhMiPiSupplierName\SupplierNameInterface;
use Illuminate\Http\Request;

class OhMiPiMiSupplierNameController extends Controller
{
    protected $supplierNameInterface;

    public function __construct(SupplierNameInterface $supplierNameInterface)
    {
        $this->supplierNameInterface = $supplierNameInterface;
    }

    public function index()
    {
        $supplierName = $this->supplierNameInterface->All();

        return response()->json($supplierName, 200);
    }

    public function store(SupplierNameRequest $request)
    {
        $supplierName = $this->supplierNameInterface->create($request->validated());

        return response()->json([
            'message' => 'Supplier name created successfully.',
            'data'    => $supplierName,
        ], 201);
    }

    public function update(SupplierNameRequest $request, string $id)
    {
        $supplierName = $this->supplierNameInterface->findById($id);

        if (! $supplierName) {
            return response()->json([
                'message' => 'Supplier name not found.',
            ], );
        }

        $this->supplierNameInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Supplier name updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $supplierName = $this->supplierNameInterface->findById($id);

        if (! $supplierName) {
            return response()->json([
                'message' => 'Supplier name not found.',
            ], );
        }

        $this->supplierNameInterface->deleteById($id);

        return response()->json([
            'message' => 'Supplier name deleted successfully.',
        ], 200);
    }
}
