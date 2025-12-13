<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsQuestion extends Model {
    use HasFactory;
    protected $fillable = ['id','question_text','lovas_skill_id'];

    public function skill() { return $this->belongsTo(LovasSkill::class,'lovas_skill_id'); }
    public function options() { return $this->hasMany(CarsQuestionOption::class,'cars_question_id'); }
}

