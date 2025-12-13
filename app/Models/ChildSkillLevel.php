<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSkillLevel extends Model {
    use HasFactory;
    protected $fillable = ['id','child_id','skill_id','score','current_level'];

    public function child() { return $this->belongsTo(Child::class,'child_id'); }
    public function skill() { return $this->belongsTo(LovasSkill::class,'skill_id'); }
}

