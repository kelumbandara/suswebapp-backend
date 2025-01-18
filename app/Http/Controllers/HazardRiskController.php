<?php
namespace App\Http\Controllers;

use App\Models\HazardRisk;
use App\Models\HSHazardRisk;
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
            'riskLevel' => 'required|in:Low,Medium,High',
            'unsafeActOrCondition' => 'required|in:Unsafe Act,Unsafe Condition',
            'createdByUser' => 'nullable|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $hazardRisk = HSHazardRisk::create($data);

        return response()->json([
            'message' => 'Hazard/Risk created successfully',
            'data' => $hazardRisk,
            'document_url' => asset('storage/' . $hazardRisk->document)
        ], 201);
    }

    public function index()
    {
        $hazardRisks = HSHazardRisk::all();
        return response()->json($hazardRisks);
    }

    public function update(Request $request, $id)
    {
        $hazardRisk = HSHazardRisk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'division' => 'required|string|max:255',
            'locationOrDepartment' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:Low,Medium,High',
            'unsafeActOrCondition' => 'required|in:Unsafe Act,Unsafe Condition',
            'status' => 'nullable|in:draft,approved,declined',
            'createdByUser' => 'nullable|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:2048',
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

        return response()->json([
            'message' => 'Hazard/Risk updated successfully',
            'data' => $hazardRisk,
            'document_url' => asset('storage/' . $hazardRisk->document)
        ]);
    }
}



