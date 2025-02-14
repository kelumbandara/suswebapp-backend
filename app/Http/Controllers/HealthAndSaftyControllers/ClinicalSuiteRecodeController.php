<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhClinicalSuite\ClinicalSuiteRequest;
use App\Repositories\All\ClinicalSuite\ClinicalSuiteInterface;

class ClinicalSuiteRecodeController extends Controller
{
    protected $clinicalSuiteInterface;

    public function __construct(ClinicalSuiteInterface $clinicalSuiteInterface)
    {
        $this->clinicalSuiteInterface = $clinicalSuiteInterface;
    }

    public function index()
    {
        $clinicalSuite = $this->clinicalSuiteInterface->All();
        if ($clinicalSuite->isEmpty()) {
            return response()->json([
                'message' => 'No clinicalSuite found.',
            ], );
        }
        return response()->json($clinicalSuite, 200);
    }

    public function store(ClinicalSuiteRequest $request)
    {
        $clinicalSuite = $this->clinicalSuiteInterface->create($request->validated());

        return response()->json([
            'message' => 'Clinical suite record created successfully.',
            'data'    => $clinicalSuite,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
