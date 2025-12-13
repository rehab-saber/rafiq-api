<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarsQuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CarsQuestionOptionController extends Controller
{
    public function index()
    {
        $options = CarsQuestionOption::with('question')->get();

        return response()->json([
            'msg' => 'Return all options',
            'status' => 200,
            'options' => $options
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $option = CarsQuestionOption::with('question')->find($id);

        if ($option) {
            return response()->json([
                'msg' => 'Option found',
                'status' => 200,
                'option' => $option
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'msg' => 'Option not found',
            'status' => 404,
            'option' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_question_options|max:11',
            'cars_question_id' => 'required|exists:cars_questions,id',
            'label' => 'required|string',
            'score' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $option = CarsQuestionOption::create([
            'id' => $request->id ?? null,
            'cars_question_id' => $request->cars_question_id,
            'label' => $request->label,
            'score' => $request->score
        ]);

        return response()->json([
            'msg' => 'Option created successfully',
            'status' => 201,
            'option' => $option
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $option = CarsQuestionOption::find($old_id);

        if (!$option) {
            return response()->json([
                'msg' => 'Option not found',
                'status' => 404,
                'option' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:cars_question_options,id,' . $old_id . '|max:11',
            'cars_question_id' => 'required|exists:cars_questions,id',
            'label' => 'required|string',
            'score' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation errors',
                'status' => 422,
                'errors' => $validator->errors()
            ], 422, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Update using query builder
        DB::table('cars_question_options')
            ->where('id', $old_id)
            ->update([
                'id' => $request->id,
                'cars_question_id' => $request->cars_question_id,
                'label' => $request->label,
                'score' => $request->score
            ]);

        // Get the updated option
        $updatedOption = CarsQuestionOption::with('question')->find($request->id);

        return response()->json([
            'msg' => 'Option updated successfully',
            'status' => 200,
            'option' => $updatedOption
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    public function delete($id)
    {
        $option = CarsQuestionOption::find($id);

        if (!$option) {
            return response()->json([
                'msg' => 'Option not found',
                'status' => 404,
                'option' => null
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $option->delete();

        return response()->json([
            'msg' => 'Option deleted successfully',
            'status' => 200,
            'option' => null
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
