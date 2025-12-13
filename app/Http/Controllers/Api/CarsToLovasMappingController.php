<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarsToLovasMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CarsToLovasMappingController extends Controller
{
    public function index()
    {
        $mappings = CarsToLovasMapping::with(['question','activity'])->get();

        return response()->json([
            'msg' => 'Return all mappings',
            'status' => 200,
            'mappings' => $mappings
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $mapping = CarsToLovasMapping::with(['question','activity'])->find($id);

        if ($mapping) {
            return response()->json([
                'msg' => 'Mapping found',
                'status' => 200,
                'mapping' => $mapping
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Mapping not found',
            'status' => 404,
            'mapping' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_to_lovas_mapping|max:11',
            'cars_question_id' => 'required|exists:cars_questions,id',
            'lovas_activity_id' => 'required|exists:lovas_activities,id',
            'severity_level' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $mapping = CarsToLovasMapping::create([
            'id' => $request->id,
            'cars_question_id' => $request->cars_question_id,
            'lovas_activity_id' => $request->lovas_activity_id,
            'severity_level' => $request->severity_level
        ]);

        return response()->json([
            'msg' => 'Mapping created successfully',
            'status' => 201,
            'mapping' => $mapping
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $mapping = CarsToLovasMapping::find($old_id);

        if (!$mapping) {
            return response()->json([
                'msg' => 'Mapping not found',
                'status' => 404,
                'mapping' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_to_lovas_mapping,id,' . $old_id . '|max:11',
            'cars_question_id' => 'required|exists:cars_questions,id',
            'lovas_activity_id' => 'required|exists:lovas_activities,id',
            'severity_level' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        DB::table('cars_to_lovas_mapping')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'cars_question_id' => $request->cars_question_id,
                'lovas_activity_id' => $request->lovas_activity_id,
                'severity_level' => $request->severity_level
            ]);

        $updatedMapping = CarsToLovasMapping::with(['question','activity'])->find($request->id);

        return response()->json([
            'msg' => 'Mapping updated successfully',
            'status' => 200,
            'mapping' => $updatedMapping
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function delete($id)
    {
        $mapping = CarsToLovasMapping::find($id);

        if (!$mapping) {
            return response()->json([
                'msg' => 'Mapping not found',
                'status' => 404,
                'mapping' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $mapping->delete();

        return response()->json([
            'msg' => 'Mapping deleted successfully',
            'status' => 200,
            'mapping' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
