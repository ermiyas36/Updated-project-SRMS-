<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $list_no
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $department
 * @property int|null $year
 * @property string|null $profile_image
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'list_no', 'first_name', 'last_name', 'email', 'password',
        'role', 'department', 'year', 'profile_image'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function taughtGrades()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function taughtAttendances()
    {
        return $this->hasMany(Attendance::class, 'teacher_id');
    }

    public function assignedCourses()
    {
        return $this->belongsToMany(Course::class, 'teacher_courses', 'teacher_id', 'course_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isRegistrar()
    {
        return $this->role === 'registrar';
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function generateListNo(string $role): string
    {
        $prefix = strtoupper(substr($role, 0, 3));
        $year = date('Y');
        $base = $prefix . $year;

        $lastListNo = self::where('list_no', 'like', "{$base}%")
            ->orderBy('list_no', 'desc')
            ->value('list_no');

        $nextNumber = 1;
        if ($lastListNo) {
            $nextNumber = (int) substr($lastListNo, strlen($base)) + 1;
        }

        do {
            $listNo = $base . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $exists = self::where('list_no', $listNo)->exists();
            $nextNumber++;
        } while ($exists);

        return $listNo;
    }
}