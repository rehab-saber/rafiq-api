<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarsQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CarsQuestionController extends Controller
{
    public function index()
    {
        $questions = CarsQuestion::all();

        return response()->json([
            'msg' => 'Return all questions',
            'status' => 200,
            'questions' => $questions
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $question = CarsQuestion::find($id);

        if ($question) {
            return response()->json([
                'msg' => 'Question found',
                'status' => 200,
                'question' => $question
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Question not found',
            'status' => 404,
            'question' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_questions|max:11',
            'question_text' => 'required|string',
            'lovas_skill_id' => 'required|exists:lovas_skills,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $question = CarsQuestion::create([
            'id' => $request->id,
            'question_text' => $request->question_text,
            'lovas_skill_id' => $request->lovas_skill_id
        ]);

        return response()->json([
            'msg' => 'Question created successfully',
            'status' => 201,
            'question' => $question
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $question = CarsQuestion::find($old_id);

        if (!$question) {
            return response()->json([
                'msg' => 'Question not found',
                'status' => 404,
                'question' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_questions,id,' . $old_id . '|max:11',
            'question_text' => 'required|string',
            'lovas_skill_id' => 'required|exists:lovas_skills,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Update using query builder
        DB::table('cars_questions')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'question_text' => $request->question_text,
                'lovas_skill_id' => $request->lovas_skill_id,
            ]);

        // Get the updated question
        $updatedQuestion = CarsQuestion::find($request->id);

        return response()->json([
            'msg' => 'Question updated successfully',
            'status' => 200,
            'question' => $updatedQuestion
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function delete($id)
    {
        $question = CarsQuestion::find($id);

        if (!$question) {
            return response()->json([
                'msg' => 'Question not found',
                'status' => 404,
                'question' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $question->delete();

        return response()->json([
            'msg' => 'Question deleted successfully',
            'status' => 200,
            'question' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}