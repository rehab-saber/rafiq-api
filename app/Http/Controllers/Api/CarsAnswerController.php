<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarsAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CarsAnswerController extends Controller
{
    public function index()
    {
        $answers = CarsAnswer::with(['child', 'question', 'option'])->get();

        return response()->json([
            'msg' => 'Return all answers',
            'status' => 200,
            'answers' => $answers
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $answer = CarsAnswer::with(['child', 'question', 'option'])->find($id);

        if ($answer) {
            return response()->json([
                'msg' => 'Answer found',
                'status' => 200,
                'answer' => $answer
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Answer not found',
            'status' => 404,
            'answer' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_answers|max:11',
            'child_id' => 'required|exists:children,id',
            'question_id' => 'required|exists:cars_questions,id',
            'option_id' => 'required|exists:cars_question_options,id',
            'score' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $answer = CarsAnswer::create([
            'id' => $request->id,
            'child_id' => $request->child_id,
            'question_id' => $request->question_id,
            'option_id' => $request->option_id,
            'score' => $request->score
        ]);

        return response()->json([
            'msg' => 'Answer created successfully',
            'status' => 201,
            'answer' => $answer
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $answer = CarsAnswer::find($old_id);

        if (!$answer) {
            return response()->json([
                'msg' => 'Answer not found',
                'status' => 404,
                'answer' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_answers,id,' . $old_id . '|max:11',
            'child_id' => 'required|exists:children,id',
            'question_id' => 'required|exists:cars_questions,id',
            'option_id' => 'required|exists:cars_question_options,id',
            'score' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Update using query builder
        DB::table('cars_answers')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'child_id' => $request->child_id,
                'question_id' => $request->question_id,
                'option_id' => $request->option_id,
                'score' => $request->score
            ]);

        // Get the updated answer
        $updatedAnswer = CarsAnswer::with(['child', 'question', 'option'])->find($request->id);

        return response()->json([
            'msg' => 'Answer updated successfully',
            'status' => 200,
            'answer' => $updatedAnswer
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    public function delete($id)
    {
        $answer = CarsAnswer::find($id);

        if (!$answer) {
            return response()->json([
                'msg' => 'Answer not found',
                'status' => 404,
                'answer' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $answer->delete();

        return response()->json([
            'msg' => 'Answer deleted successfully',
            'status' => 200,
            'answer' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
