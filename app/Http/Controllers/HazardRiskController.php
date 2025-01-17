<?php

namespace App\Http\Controllers;

use App\Models\HazardRisk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HazardRiskController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'division' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:LOW,MEDIUM,HIGH',
            'unsafeActOrCondition' => 'required|in:UNSAFE_ACT,UNSAFE_CONDITION',
            'status' => 'required|in:DRAFT,APPROVED,DECLINED',
            'created_by_user' => 'required|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $hazardRisk = HazardRisk::create([
            'division' => $request->division,
            'location' => $request->location,
            'subLocation' => $request->subLocation,
            'category' => $request->category,
            'subCategory' => $request->subCategory,
            'observationType' => $request->observationType,
            'description' => $request->description,
            'riskLevel' => $request->riskLevel,
            'unsafeActOrCondition' => $request->unsafeActOrCondition,
            'status' => $request->status,
            'created_by_user' => $request->created_by_user,
            'dueDate' => $request->dueDate,
            'assignee' => $request->assignee,
        ]);

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
            'location' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:LOW,MEDIUM,HIGH',
            'unsafeActOrCondition' => 'required|in:UNSAFE_ACT,UNSAFE_CONDITION',
            'status' => 'required|in:DRAFT,APPROVED,DECLINED',
            'created_by_user' => 'required|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $hazardRisk->update([
            'division' => $request->division,
            'location' => $request->location,
            'subLocation' => $request->sub_location,
            'category' => $request->category,
            'subCategory' => $request->sub_category,
            'observationType' => $request->observation_type,
            'description' => $request->description,
            'riskLevel' => $request->risk_level,
            'unsafeActOrCondition' => $request->unsafe_act_or_condition,
            'status' => $request->status,
            'created_by_user' => $request->created_by_user,
            'dueDate' => $request->due_date,
            'assignee' => $request->assignee,
        ]);

        return response()->json(['message' => 'Hazard/Risk updated successfully', 'data' => $hazardRisk]);
    }



}
