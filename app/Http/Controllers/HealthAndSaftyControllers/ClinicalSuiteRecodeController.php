<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhClinicalSuite\ClinicalSuiteRequest;
use App\Repositories\All\ClinicalSuite\ClinicalSuiteInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class ClinicalSuiteRecodeController extends Controller
{
    protected $clinicalSuiteInterface;
    protected $userInterface;

    public function __construct(ClinicalSuiteInterface $clinicalSuiteInterface, UserInterface $userInterface)
    {
        $this->clinicalSuiteInterface = $clinicalSuiteInterface;
        $this->userInterface          = $userInterface;
    }

    public function index()
    {
        $clinicalSuite = $this->clinicalSuiteInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();
        $clinicalSuite = $clinicalSuite->map(function ($risk) {

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            return $risk;
        });

        return response()->json($clinicalSuite, 200);
    }

    public function store(ClinicalSuiteRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $user->id;

        $clinicalSuite = $this->clinicalSuiteInterface->create($validatedData);

        return response()->json([
            'message' => 'Clinical suite record created successfully.',
            'data'    => $clinicalSuite,
        ], 201);
    }

    public function update(ClinicalSuiteRequest $request, string $id)
    {
        $clinicalSuite = $this->clinicalSuiteInterface->findById($id);

        if (! $clinicalSuite) {
            return response()->json([
                'message' => 'Clinical suite record not found.',
            ], );
        }

        $this->clinicalSuiteInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Clinical suite record updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $clinicalSuite = $this->clinicalSuiteInterface->findById($id);

        if (! $clinicalSuite) {
            return response()->json([
                'message' => 'Clinical suite record not found.',
            ], );
        }

        $this->clinicalSuiteInterface->deleteById($id);

        return response()->json([
            'message' => 'Clinical suite record deleted successfully.',
        ], 200);
    }
}
