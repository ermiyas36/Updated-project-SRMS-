<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrarStudentsDepartmentFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registrar_students_page_filters_by_department_group(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260002',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar2@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        User::create([
            'list_no' => 'STU20260011',
            'first_name' => 'Alice',
            'last_name' => 'Student',
            'email' => 'alice.students@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Biology',
            'year' => 2,
        ]);

        User::create([
            'list_no' => 'STU20260012',
            'first_name' => 'Bob',
            'last_name' => 'Other',
            'email' => 'bob.students@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Psychology',
            'year' => 2,
        ]);

        $response = $this->actingAs($registrar)
            ->get(route('registrar.students', ['department' => 'Biology']));

        $response->assertOk();
        $response->assertSee('Biology');
        $response->assertSee('Alice');
        $response->assertDontSee('Bob');
    }

    public function test_registrar_students_dashboard_shows_college_cards_without_summary_cards(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260004',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar4@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        User::create([
            'list_no' => 'STU20260031',
            'first_name' => 'Fresh',
            'last_name' => 'Student',
            'email' => 'fresh.students@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Biology',
            'year' => 1,
        ]);

        $response = $this->actingAs($registrar)->get(route('registrar.students'));

        $response->assertOk();
        $response->assertSee('Freshman Students');
        $response->assertSee('Remedial Students');
        $response->assertSee('Health Academic');
        $response->assertSee('Business & Management');
        $response->assertSee('Natural Science');
    }

    public function test_registrar_students_page_can_show_freshman_group_students(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260005',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar5@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        User::create([
            'list_no' => 'STU20260041',
            'first_name' => 'Freshman',
            'last_name' => 'Student',
            'email' => 'freshman.group@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Biology',
            'year' => 1,
        ]);

        $response = $this->actingAs($registrar)
            ->get(route('registrar.students', ['group' => 'freshman']));

        $response->assertOk();
        $response->assertSee('Freshman Students');
        $response->assertSee('Freshman');
    }

    public function test_registrar_students_can_register_freshman_with_limited_fields(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260006',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar6@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        $response = $this->actingAs($registrar)
            ->post(route('registrar.students.store'), [
                'first_name' => 'Limited',
                'last_name' => 'Student',
                'student_group' => 'freshman',
                'year' => 1,
            ]);

        $response->assertRedirect(route('registrar.students', ['group' => 'freshman']));
        $this->assertDatabaseHas('users', [
            'first_name' => 'Limited',
            'last_name' => 'Student',
            'role' => 'student',
            'year' => 1,
        ]);
    }

    public function test_old_regular_registration_rejects_freshman_and_remedial_groups(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260007',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar7@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        $response = $this->actingAs($registrar)
            ->post(route('registrar.students.store', ['mode' => 'old']), [
                'first_name' => 'Old',
                'last_name' => 'Regular',
                'student_group' => 'freshman',
                'year' => 1,
                'email' => 'old.regular@example.com',
                'password' => 'Password1',
                'department' => 'Biology',
                'teacher_id' => 1,
            ]);

        $response->assertSessionHasErrors('student_group');
        $this->assertDatabaseMissing('users', ['email' => 'old.regular@example.com']);
    }

    public function test_new_regular_registration_accepts_only_freshman_or_remedial_groups(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260008',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar8@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        $response = $this->actingAs($registrar)
            ->post(route('registrar.students.store', ['mode' => 'new']), [
                'first_name' => 'New',
                'last_name' => 'Regular',
                'student_group' => 'general',
                'year' => 1,
            ]);

        $response->assertSessionHasErrors('student_group');
    }

    public function test_registrar_students_page_keeps_department_group_navigation_for_specific_departments(): void
    {
        $registrar = User::create([
            'list_no' => 'REG20260003',
            'first_name' => 'Registrar',
            'last_name' => 'User',
            'email' => 'registrar3@example.com',
            'password' => 'Password1',
            'role' => 'registrar',
            'department' => 'Natural Science',
            'year' => 1,
        ]);

        User::create([
            'list_no' => 'STU20260021',
            'first_name' => 'Nurse',
            'last_name' => 'Student',
            'email' => 'nurse.students@example.com',
            'password' => 'Password1',
            'role' => 'student',
            'department' => 'Biology',
            'year' => 3,
        ]);

        $response = $this->actingAs($registrar)
            ->get(route('registrar.students', ['department' => 'Biology']));

        $response->assertOk();
        $response->assertSee('Students in Biology');
        $response->assertSee('Departments in Natural Science');
        $response->assertSee('Nurse');
    }
}
