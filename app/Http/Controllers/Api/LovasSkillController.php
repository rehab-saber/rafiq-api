<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LovasSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LovasSkillController extends Controller
{
    public function index()
    {
        $skills = LovasSkill::all();

        return response()->json([
            'msg' => 'Return all skills',
            'status' => 200,
            'skills' => $skills
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $skill = LovasSkill::find($id);

        if ($skill) {
            return response()->json([
                'msg' => 'Skill found',
                'status' => 200,
                'skill' => $skill
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Skill not found',
            'status' => 404,
            'skill' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:lovas_skills|max:11',
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $skill = LovasSkill::create([
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'msg' => 'Skill created successfully',
            'status' => 201,
            'skill' => $skill
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $skill = LovasSkill::find($old_id);

        if (!$skill) {
            return response()->json([
                'msg' => 'Skill not found',
                'status' => 404,
                'skill' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:lovas_skills,id,' . $old_id . '|max:11',
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        DB::table('lovas_skills')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description
            ]);

        $updatedSkill = LovasSkill::find($request->id);

        return response()->json([
            'msg' => 'Skill updated successfully',
            'status' => 200,
            'skill' => $updatedSkill
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function delete($id)
    {
        $skill = LovasSkill::find($id);

        if (!$skill) {
            return response()->json([
                'msg' => 'Skill not found',
                'status' => 404,
                'skill' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $skill->delete();

        return response()->json([
            'msg' => 'Skill deleted successfully',
            'status' => 200,
            'skill' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
