<?php
//ApiController
use App\Http\Controllers\Api\CarsAnswerController;
use App\Http\Controllers\Api\CarsQuestionController;
use App\Http\Controllers\Api\CarsQuestionOptionController;
use App\Http\Controllers\Api\CarsToLovasMappingController;
use App\Http\Controllers\Api\LovasActivityController;
use App\Http\Controllers\Api\LovasActivityProgressController;
use App\Http\Controllers\Api\LovasSkillController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//CarsQuestion
Route::get('QuestionShow', [CarsQuestionController::class, 'index']);
Route::get('QuestionShowone/{id}', [CarsQuestionController::class, 'show']);
Route::post('QuestionStore', [CarsQuestionController::class, 'store']);
Route::post('QuestionUpdate', [CarsQuestionController::class, 'update']);
Route::get('QuestionDelete/{id}', [CarsQuestionController::class, 'delete']);


//CarsAnswer
Route::get('AnswerShow', [CarsAnswerController::class, 'index']);
Route::get('AnswerShowOne/{id}', [CarsAnswerController::class, 'show']);
Route::post('AnswerStore', [CarsAnswerController::class, 'store']);
Route::post('AnswerUpdate', [CarsAnswerController::class, 'update']);
Route::get('AnswerDelete/{id}', [CarsAnswerController::class, 'delete']);

//CarsQuestionOption
Route::get('OptionShow', [CarsQuestionOptionController::class, 'index']);
Route::get('OptionShowOne/{id}', [CarsQuestionOptionController::class, 'show']);
Route::post('OptionStore', [CarsQuestionOptionController::class, 'store']);
Route::post('OptionUpdate', [CarsQuestionOptionController::class, 'update']);
Route::get('OptionDelete/{id}', [CarsQuestionOptionController::class, 'delete']);

//LovasSkill
Route::get('SkillShow', [LovasSkillController::class,'index']);
Route::get('SkillShowOne/{id}', [LovasSkillController::class,'show']);
Route::post('SkillStore', [LovasSkillController::class,'store']);
Route::post('SkillUpdate', [LovasSkillController::class,'update']);
Route::get('SkillDelete/{id}', [LovasSkillController::class,'delete']);

//lovasActivity
Route::get('ActivityShow', [LovasActivityController::class,'index']);
Route::get('ActivityShowOne/{id}', [LovasActivityController::class,'show']);
Route::post('ActivityStore', [LovasActivityController::class,'store']);
Route::post('ActivityUpdate', [LovasActivityController::class,'update']);
Route::get('ActivityDelete/{id}', [LovasActivityController::class,'delete']);

//LovasActivityProgress

Route::get('ProgressShow', [LovasActivityProgressController::class, 'index']);
Route::get('ProgressShowOne/{id}', [LovasActivityProgressController::class, 'show']);
Route::post('ProgressStore', [LovasActivityProgressController::class, 'store']);
Route::post('ProgressUpdate', [LovasActivityProgressController::class, 'update']);
Route::get('ProgressDelete/{id}', [LovasActivityProgressController::class, 'delete']);


//CarsToLovasMapping
Route::get('MappingShow', [CarsToLovasMappingController::class,'index']);
Route::get('MappingShowOne/{id}', [CarsToLovasMappingController::class,'show']);
Route::post('MappingStore', [CarsToLovasMappingController::class,'store']);
Route::post('MappingUpdate', [CarsToLovasMappingController::class,'update']);
Route::get('MappingDelete/{id}', [CarsToLovasMappingController::class,'delete']);
