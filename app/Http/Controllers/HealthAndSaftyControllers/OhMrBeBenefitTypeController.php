<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMrBeBenefitType\BenefitTypeRequest;
use App\Repositories\All\OhMrBeBenefitType\BenefitTypeInterface;
use Illuminate\Http\Request;

class OhMrBeBenefitTypeController extends Controller
{
    protected $benefitTypeInterface;

    public function __construct(BenefitTypeInterface $benefitTypeInterface)
    {
        $this->benefitTypeInterface = $benefitTypeInterface;
    }

    public function index()
    {
        $benefitType = $this->benefitTypeInterface->All();
        if ($benefitType->isEmpty()) {
            return response()->json([
                'message' => 'No benefit type found.',
            ]);
        }
        return response()->json($benefitType);
    }

    public function store(BenefitTypeRequest $request)
    {
        $benefitType = $this->benefitTypeInterface->create($request->validated());

        return response()->json([
            'message'  => 'benefit type created successfully!',
            'category' => $benefitType,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
