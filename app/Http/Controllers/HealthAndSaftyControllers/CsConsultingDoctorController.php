<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhCsConsultingDoctor\ConsultingDoctorRequest;
use App\Repositories\All\CsConsultingDoctor\ConsultingInterface;
use Illuminate\Http\Request;

class CsConsultingDoctorController extends Controller
{
    protected $consultingInterface;

    public function __construct(ConsultingInterface $consultingInterface)
    {
        $this->consultingInterface = $consultingInterface;
    }

    public function index()
    {
        $doctor = $this->consultingInterface->All();
        if ($doctor->isEmpty()) {
            return response()->json([
                'message' => 'Consulting Doctor not found.',
            ], );
        }
        return response()->json($doctor, 200);
    }

    public function store(ConsultingDoctorRequest $request)
    {
        $doctor = $this->consultingInterface->create($request->validated());

        return response()->json([
            'message' => 'Consulting Doctor created successfully.',
            'data'    => $doctor,
        ], 201);
    }

    public function update(ConsultingDoctorRequest $request, string $id)
    {
        $doctor = $this->consultingInterface->findById($id);

        if (! $doctor) {
            return response()->json([
                'message' => 'Consulting Doctor not found.',
            ], );
        }

        $this->consultingInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Consulting Doctor updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $doctor = $this->consultingInterface->findById($id);

        if (! $doctor) {
            return response()->json([
                'message' => 'Consulting Doctor not found.',
            ], );
        }

        $this->consultingInterface->deleteById($id);

        return response()->json([
            'message' => 'Consulting Doctor deleted successfully.',
        ], 200);
    }
}
