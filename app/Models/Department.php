<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_code'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subFields()
    {
        return $this->hasMany(SubField::class);
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, SubField::class);
    }
}
