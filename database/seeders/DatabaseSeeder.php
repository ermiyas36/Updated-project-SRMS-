<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        $this->command->info('Clearing existing data...');
        User::query()->delete();
        Course::query()->delete();

        // Seed normalized data first
        $this->command->info('Creating departments and sub-fields...');
        $this->call(DepartmentSeeder::class);
        $this->call(SubFieldSeeder::class);
        $this->call(AcademicPeriodSeeder::class);

        $this->command->info('Creating users...');

        // Get Computer Science department
        $csDept = \App\Models\Department::where('name', 'Computer Science')->first();
        $adminDept = \App\Models\Department::where('name', 'Other')->first();

        // Create Admin
        User::create([
            'list_no' => 'ADM2024001',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
            'department' => 'Administration',
            'department_id' => $adminDept->id ?? null,
        ]);

        // Create Teacher
        User::create([
            'list_no' => 'TCH2024001',
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'teacher@example.com',
            'password' => Hash::make('Teacher123'),
            'role' => 'teacher',
            'department' => 'Computer Science',
            'department_id' => $csDept->id ?? null,
        ]);

        // Create Student
        User::create([
            'list_no' => 'STU2024001',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'student@example.com',
            'password' => Hash::make('Student123'),
            'role' => 'student',
            'department' => 'Computer Science',
            'department_id' => $csDept->id ?? null,
            'year' => 2,
        ]);

        // Create Registrar
        User::create([
            'list_no' => 'REG2024001',
            'first_name' => 'Mary',
            'last_name' => 'Johnson',
            'email' => 'registrar@example.com',
            'password' => Hash::make('Registrar123'),
            'role' => 'registrar',
            'department' => 'Registrar Office',
            'department_id' => $adminDept->id ?? null,
        ]);

        $this->command->info('Creating courses...');

        // Use the CourseSeeder for comprehensive course data
        $this->call(CourseSeeder::class);

        $this->command->info('====================================');
        $this->command->info(' Database seeded successfully with 3NF normalization!');
        $this->command->info('====================================');
        $this->command->info('Demo Accounts:');
        $this->command->info('📧 Admin: admin@example.com / Admin123');
        $this->command->info('📧 Teacher: teacher@example.com / Teacher123');
        $this->command->info('📧 Student: student@example.com / Student123');
        $this->command->info('📧 Registrar: registrar@example.com / Registrar123');
        $this->command->info('====================================');
    }
}