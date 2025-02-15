<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMedicineRequest\MedicineRequestRequest;
use App\Repositories\All\MiMedicineRequest\MedicineRequestInterface;

class OsMiMedicineRequestController extends Controller
{
    protected $medicineRequestInterface;

    public function __construct(MedicineRequestInterface $medicineRequestInterface)
    {
        $this->medicineRequestInterface = $medicineRequestInterface;
    }

    public function index()
    {
        $medicineStock = $this->medicineRequestInterface->All();

        return response()->json($medicineStock, 200);
    }

    public function store(MedicineRequestRequest $request)
    {
        $medicine = $this->medicineRequestInterface->create($request->validated());

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
}
