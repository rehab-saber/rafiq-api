<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LovasActivityProgress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LovasActivityProgressController extends Controller
{
    // GET all progress
    public function index()
    {
        $progress = LovasActivityProgress::with(['child', 'activity'])->get();
        return response()->json([
            'msg' => 'All progress retrieved successfully',
            'status' => 200,
            'progress' => $progress
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // GET single progress by id
    public function show($id)
    {
        $progress = LovasActivityProgress::with(['child', 'activity'])->find($id);
        if (!$progress) {
            return response()->json([
                'msg' => 'Progress not found',
                'status' => 404,
                'progress' => null
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Progress retrieved successfully',
            'status' => 200,
            'progress' => $progress
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // CREATE new progress
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id' => 'required|exists:children,id',
            'activity_id' => 'required|exists:lovas_activities,id',
            'score' => 'nullable|integer',
            'time_spent' => 'nullable|integer',
            'status' => 'nullable|in:in-progress,completed,failed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $progress = LovasActivityProgress::create($request->all());

        return response()->json([
            'msg' => 'Progress created successfully',
            'status' => 201,
            'progress' => $progress
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // UPDATE progress
    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $progress = LovasActivityProgress::find($old_id);

        if (!$progress) {
            return response()->json([
                'msg' => 'Progress not found',
                'status' => 404,
                'progress' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:lovas_activity_progress,id,' . $old_id,
            'child_id' => 'required|exists:children,id',
            'activity_id' => 'required|exists:lovas_activities,id',
            'score' => 'nullable|integer',
            'time_spent' => 'nullable|integer',
            'status' => 'nullable|in:in-progress,completed,failed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Update using query builder
        DB::table('lovas_activity_progress')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'child_id' => $request->child_id,
                'activity_id' => $request->activity_id,
                'score' => $request->score,
                'time_spent' => $request->time_spent,
                'status' => $request->status,
            ]);

        // Get the updated record
        $updatedProgress = LovasActivityProgress::with(['child', 'activity'])->find($request->id);

        return response()->json([
            'msg' => 'Progress updated successfully',
            'status' => 200,
            'progress' => $updatedProgress
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    // DELETE progress
    public function delete($id)
    {
        $progress = LovasActivityProgress::find($id);
        if (!$progress) {
            return response()->json([
                'msg' => 'Progress not found',
                'status' => 404
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $progress->delete();

        return response()->json([
            'msg' => 'Progress deleted successfully',
            'status' => 200
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
