<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaSupplierType\SupplierTypeRequest;
use App\Repositories\All\SaAiIaSupplierType\SupplierTypeInterface;
use Illuminate\Http\Request;

class SaAiIaSuplierTypeController extends Controller
{
    protected $supplierTypeInterface;

    public function __construct(SupplierTypeInterface $supplierTypeInterface)
    {
        $this->supplierTypeInterface = $supplierTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = $this->supplierTypeInterface->all();
        return response()->json($supplier);
    }

    public function store(SupplierTypeRequest $request)
    {
        $data = $request->validated();
        $supplier  = $this->supplierTypeInterface->create($data);
        return response()->json([
            'message' => 'Supplier type created successfully',
            'data'    => $supplier,
        ], 201);
    }
}
