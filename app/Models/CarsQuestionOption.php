<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsQuestionOption extends Model {
    use HasFactory;

    
    protected $table = 'cars_question_options'; 

    protected $fillable = ['id','cars_question_id','label','score'];

    public function question() {
        return $this->belongsTo(CarsQuestion::class,'cars_question_id');
    }
}
