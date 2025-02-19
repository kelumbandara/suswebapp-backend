<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMiMedicineRequest\MedicineRequestRequest;
use App\Repositories\All\MiMedicineRequest\MedicineRequestInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class OsMiMedicineRequestController extends Controller
{
    protected $medicineRequestInterface;
    protected $userInterface;


    public function __construct(MedicineRequestInterface $medicineRequestInterface, UserInterface $userInterface)
    {
        $this->medicineRequestInterface = $medicineRequestInterface;
        $this->userInterface = $userInterface;
    }

    public function index()
    {
        $medicineStock = $this->medicineRequestInterface->All();
        $medicineStock = $medicineStock->map(function ($risk) {
            try {
                $assignee           = $this->userInterface->getById($risk->assignee);
                $risk->assigneeName = $assignee ? $assignee->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->assigneeName = 'Unknown';
            }

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        return response()->json($medicineStock, 200);
    }

    public function store(MedicineRequestRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $validatedData = $request->validated();
        $validatedData['createdByUser'] = $user->id;

        $medicine = $this->medicineRequestInterface->create($validatedData);

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
