<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Health Academic', 'department_code' => 'HA', 'description' => 'Health and Medical Sciences'],
            ['name' => 'Nursing', 'department_code' => 'NUR', 'description' => 'Nursing and Healthcare'],
            ['name' => 'Medicine', 'department_code' => 'MED', 'description' => 'Medical Sciences'],
            ['name' => 'Public Health', 'department_code' => 'PH', 'description' => 'Public Health and Epidemiology'],
            ['name' => 'Informatics', 'department_code' => 'INF', 'description' => 'Information Technology'],
            ['name' => 'Computer Science', 'department_code' => 'CS', 'description' => 'Computer Science and Programming'],
            ['name' => 'Electrical Engineering', 'department_code' => 'EE', 'description' => 'Electrical Engineering'],
            ['name' => 'Mechanical Engineering', 'department_code' => 'ME', 'description' => 'Mechanical Engineering'],
            ['name' => 'Civil Engineering', 'department_code' => 'CE', 'description' => 'Civil Engineering'],
            ['name' => 'Engineering Field', 'department_code' => 'EF', 'description' => 'General Engineering'],
            ['name' => 'Psychology', 'department_code' => 'PSY', 'description' => 'Psychology and Behavior'],
            ['name' => 'Sociology', 'department_code' => 'SOC', 'description' => 'Sociology and Social Studies'],
            ['name' => 'Political Science', 'department_code' => 'POS', 'description' => 'Political Science'],
            ['name' => 'Economics', 'department_code' => 'ECO', 'description' => 'Economics and Finance'],
            ['name' => 'Biology', 'department_code' => 'BIO', 'description' => 'Biology and Life Sciences'],
            ['name' => 'Chemistry', 'department_code' => 'CHE', 'description' => 'Chemistry'],
            ['name' => 'Physics', 'department_code' => 'PHY', 'description' => 'Physics'],
            ['name' => 'Environmental Science', 'department_code' => 'ENV', 'description' => 'Environmental Science'],
            ['name' => 'Business', 'department_code' => 'BUS', 'description' => 'Business Administration'],
            ['name' => 'Accounting', 'department_code' => 'ACC', 'description' => 'Accounting and Finance'],
            ['name' => 'Finance', 'department_code' => 'FIN', 'description' => 'Finance and Investment'],
            ['name' => 'Marketing', 'department_code' => 'MKT', 'description' => 'Marketing'],
            ['name' => 'Management', 'department_code' => 'MGT', 'description' => 'Business Management'],
            ['name' => 'Literature', 'department_code' => 'LIT', 'description' => 'Literature and Language Arts'],
            ['name' => 'History', 'department_code' => 'HIS', 'description' => 'History'],
            ['name' => 'Philosophy', 'department_code' => 'PHI', 'description' => 'Philosophy'],
            ['name' => 'Fine Arts', 'department_code' => 'ART', 'description' => 'Fine Arts and Design'],
            ['name' => 'Languages', 'department_code' => 'LNG', 'description' => 'Languages and Linguistics'],
            ['name' => 'Mathematics', 'department_code' => 'MAT', 'description' => 'Mathematics'],
            ['name' => 'Statistics', 'department_code' => 'STA', 'description' => 'Statistics'],
            ['name' => 'Applied Mathematics', 'department_code' => 'AMAT', 'description' => 'Applied Mathematics'],
            ['name' => 'Law', 'department_code' => 'LAW', 'description' => 'Law'],
            ['name' => 'Education', 'department_code' => 'EDU', 'description' => 'Education'],
            ['name' => 'Agriculture', 'department_code' => 'AGR', 'description' => 'Agriculture'],
            ['name' => 'Social Science', 'department_code' => 'SS', 'description' => 'Social Sciences'],
            ['name' => 'Natural Science', 'department_code' => 'NS', 'description' => 'Natural Sciences'],
            ['name' => 'Other', 'department_code' => 'OTH', 'description' => 'Other Programs'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
