<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentGradesTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_grades_page_renders_without_errors(): void
    {
        $student = User::create([
            'list_no' => 'STU20260002',
            'first_name' => 'Jane',
            'last_name' => 'Student',
            'email' => 'student2@example.com',
            'password' => 'password',
            'role' => 'student',
            'department' => 'Science',
            'year' => 1,
        ]);

        $teacher = User::create([
            'list_no' => 'TCH20260002',
            'first_name' => 'John',
            'last_name' => 'Teacher',
            'email' => 'teacher2@example.com',
            'password' => 'password',
            'role' => 'teacher',
            'department' => 'Science',
            'year' => 1,
        ]);

        $course = Course::create([
            'course_name' => 'Mathematics',
            'course_code' => 'MATH102',
            'department' => 'Science',
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

        $response = $this->actingAs($student)->get(route('student.grades'));

        $response->assertOk();
        $response->assertSee('Mathematics');
    }
}
