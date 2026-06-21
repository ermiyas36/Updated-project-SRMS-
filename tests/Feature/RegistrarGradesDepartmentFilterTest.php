<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrarGradesDepartmentFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_academic_card_shows_students_from_health_sub_departments(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260001',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Health Academic',
            'year' => 1,
        ]);

        $student = User::create([
            'list_no' => 'STU20260003',
            'first_name' => 'Alice',
            'last_name' => 'Student',
            'email' => 'alice@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Nursing',
            'year' => 2,
        ]);

        $teacher = User::create([
            'list_no' => 'TCH20260003',
            'first_name' => 'Teach',
            'last_name' => 'One',
            'email' => 'teacher3@example.com',
            'password' => 'Password1',
            'role' => 'teacher',
            'department' => 'Nursing',
            'year' => 1,
        ]);

        $course = Course::create([
            'course_name' => 'Basic Nursing',
            'course_code' => 'NUR101',
            'department' => 'Nursing',
            'credits' => 3,
        ]);

        Grade::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'grade' => 'A',
            'teacher_id' => $teacher->id,
            'semester' => 1,
            'academic_year' => 2026,
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($registrar)->get(route('registrar.grades', ['department' => 'Health Academic']));

        $response->assertOk();
        $response->assertDontSee('No submitted grades found.');
        $response->assertSee('Nursing');
    }
}
