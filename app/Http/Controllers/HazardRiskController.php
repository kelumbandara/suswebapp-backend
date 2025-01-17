<?php

namespace App\Http\Controllers;

use App\Models\HazardRisk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HazardRiskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'division' => 'required|string|max:255',
            'locationOrDepartment' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:LOW,MEDIUM,HIGH',
            'unsafeActOrCondition' => 'required|in:UNSAFE_ACT,UNSAFE_CONDITION',
            'status' => 'required|in:DRAFT,APPROVED,DECLINED',
            'createdByUser' => 'required|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
            'document' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png', // Validate uploaded document
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public'); // Store document in the 'documents' directory
        }

        $hazardRisk = HazardRisk::create($data);

        return response()->json(['message' => 'Hazard/Risk created successfully', 'data' => $hazardRisk], 201);
    }

    public function index()
    {
        $hazardRisks = HazardRisk::all();
        return response()->json($hazardRisks);
    }

    public function update(Request $request, $id)
    {
        $hazardRisk = HazardRisk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'division' => 'required|string|max:255',
            'locationOrDepartment' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:LOW,MEDIUM,HIGH',
            'unsafeActOrCondition' => 'required|in:UNSAFE_ACT,UNSAFE_CONDITION',
            'status' => 'required|in:DRAFT,APPROVED,DECLINED',
            'createdByUser' => 'required|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
            'document' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('document')) {
            if ($hazardRisk->document) {
                Storage::disk('public')->delete($hazardRisk->document);
            }

            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $hazardRisk->update($data);

        return response()->json(['message' => 'Hazard/Risk updated successfully', 'data' => $hazardRisk]);
    }
}
