<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsToLovasMapping extends Model {
    use HasFactory;

    
    protected $table = 'cars_to_lovas_mapping';

    protected $fillable = ['id','cars_question_id','lovas_activity_id','severity_level'];

    public function question() {
        return $this->belongsTo(CarsQuestion::class,'cars_question_id');
    }

    public function activity() {
        return $this->belongsTo(LovasActivity::class,'lovas_activity_id');
    }
}
