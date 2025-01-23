<?php
namespace App\Http\Controllers\FactoryDeatail;

use App\Http\Controllers\Controller;
use App\Http\Requests\FactoryDeatail\FactoryDeatailRequest;
use App\Repositories\All\FactoryDeatail\FactoryDeatailInterface;

class FactoryDeatailController extends Controller
{
    protected $factoryDeatailInterface;

    public function __construct(FactoryDeatailInterface $factoryDeatailInterface)
    {
        $this->factoryDeatailInterface = $factoryDeatailInterface;
    }

    public function show()
    {
        $factoryDetails = $this->factoryDeatailInterface->all();

        if ($factoryDetails->isEmpty()) {
            return response()->json([
                'message' => 'No factory details found.',
            ], 404);
        }

        return response()->json($factoryDetails);
    }
    public function store(FactoryDeatailRequest $request)
    {
        $validatedData = $request->validated();
        $factoryDetail = $this->factoryDeatailInterface->create($validatedData);

        return response()->json([
            'message'        => 'Factory detail created successfully!',
            'factory_detail' => $factoryDetail,
        ], 201);
    }

}
