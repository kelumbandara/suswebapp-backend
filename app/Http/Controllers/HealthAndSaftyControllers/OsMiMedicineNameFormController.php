<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMnMedicineNameForm\MedicineNameFormRequest;
use App\Repositories\All\MiMedicineNameForm\MedicineFormInterface;
use Illuminate\Http\Request;

class OsMiMedicineNameFormController extends Controller
{
    protected $medicineFormInterface;

    public function __construct(MedicineFormInterface $medicineFormInterface)
    {
        $this->medicineFormInterface = $medicineFormInterface;
    }

    public function index()
    {
        $medicineForm = $this->medicineFormInterface->All();
        if ($medicineForm->isEmpty()) {
            return response()->json([
                'message' => 'Medicine form not found.',
            ]);
        }
        return response()->json($medicineForm, 200);
    }

    public function store(MedicineNameFormRequest $request)
    {
        $medicineForm = $this->medicineFormInterface->create($request->validated());

        return response()->json([
            'message' => 'Medicine form created successfully.',
            'data'    => $medicineForm,
        ], 201);
    }

    public function update(MedicineNameFormRequest $request, string $id)
    {
        $medicineForm = $this->medicineFormInterface->findById($id);

        if (! $medicineForm) {
            return response()->json([
                'message' => 'Medicine form not found.',
            ]);
        }

        $this->medicineFormInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Medicine form updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicineForm = $this->medicineFormInterface->findById($id);

        if (! $medicineForm) {
            return response()->json([
                'message' => 'Medicine form not found.',
            ]);
        }

        $this->medicineFormInterface->deleteById($id);

        return response()->json([
            'message' => 'Medicine form deleted successfully.',
        ], 200);
    }
}
