<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function skills() {
        return $this->belongsToMany(Skill::class);
    }
}
