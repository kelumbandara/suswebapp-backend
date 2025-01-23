<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auditee\AuditeeRequest;
use App\Repositories\All\Auditee\AuditeeInterface;
use Illuminate\Http\Request;

class AuditeeController extends Controller
{
    protected $auditeeInterface;

    public function __construct(AuditeeInterface $auditeeInterface)
    {
        $this->auditeeInterface = $auditeeInterface;
    }


    public function show()
    {
        $auditees = $this->auditeeInterface->All();

        if ($auditees->isEmpty()) {
            return response()->json([
                'message' => 'No auditees found.',
            ], 404);
        }

        return response()->json($auditees);
    }


    public function store(AuditeeRequest $request)
    {
        $validatedData = $request->validated();
        $auditee = $this->auditeeInterface->create($validatedData);

        return response()->json([
            'message' => 'Auditee created successfully!',
            'auditee' => $auditee,
        ], 201);
    }
}
