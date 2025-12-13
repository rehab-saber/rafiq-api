<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    public function childrenAsParent()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

   
    public function childrenAsDoctor()
    {
        return $this->hasMany(Child::class, 'doctor_id');
    }
}
