<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LovasSkill extends Model {
    use HasFactory;
    protected $fillable = ['id','name','description'];

    public function questions() { return $this->hasMany(CarsQuestion::class,'lovas_skill_id'); }
    public function activities() { return $this->hasMany(LovasActivity::class,'skill_id'); }
}

