<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LovasActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LovasActivityController extends Controller
{
    public function index()
    {
        $activities = LovasActivity::with('skill')->get();

        return response()->json([
            'msg' => 'Return all activities',
            'status' => 200,
            'activities' => $activities
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $activity = LovasActivity::with('skill')->find($id);

        if ($activity) {
            return response()->json([
                'msg' => 'Activity found',
                'status' => 200,
                'activity' => $activity
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Activity not found',
            'status' => 404,
            'activity' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:lovas_activities|max:11',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|in:game,visual_task,language_task,other',
            'level' => 'nullable|integer|min:1',
            'skill_id' => 'nullable|exists:lovas_skills,id',
            'asset_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $activity = LovasActivity::create([
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'level' => $request->level ?? 1,
            'skill_id' => $request->skill_id,
            'asset_url' => $request->asset_url
        ]);

        return response()->json([
            'msg' => 'Activity created successfully',
            'status' => 201,
            'activity' => $activity
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $activity = LovasActivity::find($old_id);

        if (!$activity) {
            return response()->json([
                'msg' => 'Activity not found',
                'status' => 404,
                'activity' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:lovas_activities,id,' . $old_id . '|max:11',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|in:game,visual_task,language_task,other',
            'level' => 'nullable|integer|min:1',
            'skill_id' => 'nullable|exists:lovas_skills,id',
            'asset_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        DB::table('lovas_activities')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'level' => $request->level ?? 1,
                'skill_id' => $request->skill_id,
                'asset_url' => $request->asset_url
            ]);

        $updatedActivity = LovasActivity::with('skill')->find($request->id);

        return response()->json([
            'msg' => 'Activity updated successfully',
            'status' => 200,
            'activity' => $updatedActivity
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function delete($id)
    {
        $activity = LovasActivity::find($id);

        if (!$activity) {
            return response()->json([
                'msg' => 'Activity not found',
                'status' => 404,
                'activity' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $activity->delete();

        return response()->json([
            'msg' => 'Activity deleted successfully',
            'status' => 200,
            'activity' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
