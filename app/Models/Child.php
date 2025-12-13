<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'parent_id',
        'doctor_id',
        'autism_level'
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function answers()
    {
        return $this->hasMany(CarsAnswer::class);
    }

    public function skillLevels()
    {
        return $this->hasMany(ChildSkillLevel::class);
    }

    public function activityProgress()
    {
        return $this->hasMany(LovasActivityProgress::class);
    }

   // public function reports()
  //{
  //    return $this->hasMany(Report::class);
  // }
}
