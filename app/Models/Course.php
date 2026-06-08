<?php

namespace App\Models;

use App\Models\Grade;  // ← ADD THIS IMPORT


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code', 
        'course_name', 
        'department', 
        'sub_field',
        'credits'
    ];

    // Relationship with Grades
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // Relationship with Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relationship with Enrollment
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relationship with Teachers (many-to-many)
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_courses', 'course_id', 'teacher_id');
    }
}