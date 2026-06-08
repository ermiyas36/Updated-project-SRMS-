<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // Health Academic Department
            [
                'course_code' => 'NUR101',
                'course_name' => 'Introduction to Nursing',
                'department' => 'Nursing',
                'sub_field' => 'Basic Nursing',
                'credits' => 3
            ],
            [
                'course_code' => 'NUR201',
                'course_name' => 'Medical-Surgical Nursing',
                'department' => 'Nursing',
                'sub_field' => 'Clinical Nursing',
                'credits' => 4
            ],
            [
                'course_code' => 'MED101',
                'course_name' => 'Human Anatomy',
                'department' => 'Medicine',
                'sub_field' => 'Basic Sciences',
                'credits' => 4
            ],
            [
                'course_code' => 'MED201',
                'course_name' => 'Pathology',
                'department' => 'Medicine',
                'sub_field' => 'Clinical Medicine',
                'credits' => 3
            ],

            // Engineering Department
            [
                'course_code' => 'INF101',
                'course_name' => 'Introduction to Informatics',
                'department' => 'Informatics',
                'sub_field' => 'Computer Fundamentals',
                'credits' => 3
            ],
            [
                'course_code' => 'INF201',
                'course_name' => 'Database Systems',
                'department' => 'Informatics',
                'sub_field' => 'Software Development',
                'credits' => 4
            ],
            [
                'course_code' => 'CSE101',
                'course_name' => 'Programming Fundamentals',
                'department' => 'Computer Science',
                'sub_field' => 'Programming',
                'credits' => 4
            ],
            [
                'course_code' => 'CSE201',
                'course_name' => 'Data Structures',
                'department' => 'Computer Science',
                'sub_field' => 'Algorithms',
                'credits' => 4
            ],

            // Social Science Department
            [
                'course_code' => 'PSY101',
                'course_name' => 'Introduction to Psychology',
                'department' => 'Psychology',
                'sub_field' => 'General Psychology',
                'credits' => 3
            ],
            [
                'course_code' => 'PSY201',
                'course_name' => 'Clinical Psychology',
                'department' => 'Psychology',
                'sub_field' => 'Clinical Practice',
                'credits' => 4
            ],
            [
                'course_code' => 'SOC101',
                'course_name' => 'Sociology Fundamentals',
                'department' => 'Sociology',
                'sub_field' => 'Social Theory',
                'credits' => 3
            ],
            [
                'course_code' => 'ECO101',
                'course_name' => 'Microeconomics',
                'department' => 'Economics',
                'sub_field' => 'Microeconomics',
                'credits' => 3
            ],

            // Natural Science Department
            [
                'course_code' => 'BIO101',
                'course_name' => 'General Biology',
                'department' => 'Biology',
                'sub_field' => 'Cell Biology',
                'credits' => 4
            ],
            [
                'course_code' => 'BIO201',
                'course_name' => 'Molecular Biology',
                'department' => 'Biology',
                'sub_field' => 'Molecular Biology',
                'credits' => 4
            ],
            [
                'course_code' => 'CHE101',
                'course_name' => 'General Chemistry',
                'department' => 'Chemistry',
                'sub_field' => 'Organic Chemistry',
                'credits' => 4
            ],
            [
                'course_code' => 'PHY101',
                'course_name' => 'Physics I',
                'department' => 'Physics',
                'sub_field' => 'Classical Physics',
                'credits' => 4
            ],

            // Business & Management Department
            [
                'course_code' => 'BUS101',
                'course_name' => 'Introduction to Business',
                'department' => 'Business',
                'sub_field' => 'Business Fundamentals',
                'credits' => 3
            ],
            [
                'course_code' => 'ACC101',
                'course_name' => 'Financial Accounting',
                'department' => 'Accounting',
                'sub_field' => 'Financial Reporting',
                'credits' => 3
            ],
            [
                'course_code' => 'FIN101',
                'course_name' => 'Corporate Finance',
                'department' => 'Finance',
                'sub_field' => 'Financial Management',
                'credits' => 3
            ],
            [
                'course_code' => 'MKT101',
                'course_name' => 'Marketing Principles',
                'department' => 'Marketing',
                'sub_field' => 'Marketing Strategy',
                'credits' => 3
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
