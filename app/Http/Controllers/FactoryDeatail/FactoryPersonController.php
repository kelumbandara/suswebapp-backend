<?php
namespace App\Http\Controllers\FactoryDeatail;

use App\Http\Controllers\Controller;
use App\Http\Requests\FactoryDeatail\FactoryPersonRequest;
use App\Repositories\All\FactoryPerson\FactoryPersonInterface;

class FactoryPersonController extends Controller
{
    protected $factoryPersonInterface;

    public function __construct(FactoryPersonInterface $factoryPersonInterface)
    {
        $this->factoryPersonInterface = $factoryPersonInterface;
    }

    public function show()
    {
        $factoryPerson = $this->factoryPersonInterface->all();

        if ($factoryPerson->isEmpty()) {
            return response()->json([
                'message' => 'No factory  Person found.',
            ], 404);
        }

        return response()->json($factoryPerson);
    }


    public function store(FactoryPersonRequest $request)
    {
        $validatedData = $request->validated();
        $factoryPerson = $this->factoryPersonInterface->create($validatedData);

        return response()->json([
            'message'        => 'Factory Person created successfully!',
            'factory_person' => $factoryPerson,
        ], 201);
    }


}
