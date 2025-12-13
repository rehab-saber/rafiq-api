<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LovasActivityProgress extends Model {
    use HasFactory;
    protected $table = 'lovas_activity_progress';
    protected $fillable = ['id','child_id','activity_id','score','time_spent','status'];

    public function child() { return $this->belongsTo(Child::class,'child_id'); }
    public function activity() { return $this->belongsTo(LovasActivity::class,'activity_id'); }
}

