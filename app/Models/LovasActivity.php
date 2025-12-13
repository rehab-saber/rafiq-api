<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LovasActivity extends Model {
    use HasFactory;
    protected $fillable = ['id','name','description','type','level','skill_id','asset_url'];

    public function skill() { return $this->belongsTo(LovasSkill::class,'skill_id'); }
}
