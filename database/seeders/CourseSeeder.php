<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\SubField;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // Format: code, name, dept, sub, credits
            ['NUR101', 'Introduction to Nursing', 'Nursing', 'Basic Nursing', 3],
            ['NUR201', 'Medical-Surgical Nursing', 'Nursing', 'Clinical Nursing', 4],
            ['MED101', 'Human Anatomy', 'Medicine', 'Basic Sciences', 4],
            ['MED201', 'Pathology', 'Medicine', 'Clinical Medicine', 3],
            ['PH101', 'Public Health Fundamentals', 'Public Health', 'Public Health', 3],
            ['PH201', 'Epidemiology', 'Public Health', 'Disease Prevention', 4],
            ['INF101', 'Introduction to Informatics', 'Informatics', 'Computer Fundamentals', 3],
            ['INF201', 'Database Systems', 'Informatics', 'Software Development', 4],
            ['EE101', 'Electrical Engineering Fundamentals', 'Electrical Engineering', 'Circuits', 4],
            ['EE201', 'Digital Systems', 'Electrical Engineering', 'Electronics', 4],
            ['ME101', 'Engineering Mechanics', 'Mechanical Engineering', 'Mechanics', 4],
            ['ME201', 'Thermodynamics', 'Mechanical Engineering', 'Energy Systems', 4],
            ['CE101', 'Engineering Materials', 'Civil Engineering', 'Materials', 3],
            ['CE201', 'Structural Analysis', 'Civil Engineering', 'Structures', 4],
            ['CSE101', 'Programming Fundamentals', 'Computer Science', 'Programming', 4],
            ['CSE201', 'Data Structures', 'Computer Science', 'Algorithms', 4],
            ['PSY101', 'Introduction to Psychology', 'Psychology', 'General Psychology', 3],
            ['PSY201', 'Clinical Psychology', 'Psychology', 'Clinical Practice', 4],
            ['SOC101', 'Sociology Fundamentals', 'Sociology', 'Social Theory', 3],
            ['SOC201', 'Social Research Methods', 'Sociology', 'Research Methods', 3],
            ['POS101', 'Introduction to Political Science', 'Political Science', 'Political Theory', 3],
            ['POS201', 'International Relations', 'Political Science', 'Global Politics', 3],
            ['ECO101', 'Microeconomics', 'Economics', 'Microeconomics', 3],
            ['ECO201', 'Macroeconomics', 'Economics', 'Macroeconomics', 3],
            ['BIO101', 'General Biology', 'Biology', 'Cell Biology', 4],
            ['BIO201', 'Molecular Biology', 'Biology', 'Molecular Biology', 4],
            ['CHE101', 'General Chemistry', 'Chemistry', 'Organic Chemistry', 4],
            ['CHE201', 'Analytical Chemistry', 'Chemistry', 'Analytical Methods', 4],
            ['PHY101', 'Physics I', 'Physics', 'Classical Physics', 4],
            ['PHY201', 'Physics II', 'Physics', 'Modern Physics', 4],
            ['ENV101', 'Environmental Science Fundamentals', 'Environmental Science', 'Ecology', 3],
            ['ENV201', 'Environmental Management', 'Environmental Science', 'Conservation', 3],
            ['BUS101', 'Introduction to Business', 'Business', 'Business Fundamentals', 3],
            ['BUS201', 'Business Strategy', 'Business', 'Strategy', 3],
            ['ACC101', 'Financial Accounting', 'Accounting', 'Financial Reporting', 3],
            ['ACC201', 'Management Accounting', 'Accounting', 'Cost Analysis', 3],
            ['FIN101', 'Corporate Finance', 'Finance', 'Financial Management', 3],
            ['FIN201', 'Investment Analysis', 'Finance', 'Investments', 3],
            ['MKT101', 'Marketing Principles', 'Marketing', 'Marketing Strategy', 3],
            ['MKT201', 'Digital Marketing', 'Marketing', 'Digital Strategy', 3],
            ['MGT101', 'Management Principles', 'Management', 'Organizational Management', 3],
            ['MGT201', 'Human Resource Management', 'Management', 'HR Strategy', 3],
            ['LIT101', 'Introduction to Literature', 'Literature', 'Literary Analysis', 3],
            ['LIT201', 'World Literature', 'Literature', 'Comparative Literature', 3],
            ['HIS101', 'World History', 'History', 'World Events', 3],
            ['HIS201', 'Modern History', 'History', 'Contemporary History', 3],
            ['PHI101', 'Introduction to Philosophy', 'Philosophy', 'Philosophical Thinking', 3],
            ['PHI201', 'Ethics', 'Philosophy', 'Moral Philosophy', 3],
            ['ART101', 'Fine Arts Fundamentals', 'Fine Arts', 'Art Theory', 3],
            ['ART201', 'Contemporary Art', 'Fine Arts', 'Modern Art', 3],
            ['LNG101', 'Language Studies', 'Languages', 'Linguistics', 3],
            ['LNG201', 'Translation Studies', 'Languages', 'Applied Languages', 3],
            ['MATH101', 'Calculus I', 'Mathematics', 'Calculus', 4],
            ['MATH201', 'Linear Algebra', 'Mathematics', 'Algebra', 4],
            ['STAT101', 'Statistics Fundamentals', 'Statistics', 'Descriptive Statistics', 3],
            ['STAT201', 'Inferential Statistics', 'Statistics', 'Hypothesis Testing', 3],
            ['AMATH101', 'Applied Mathematics I', 'Applied Mathematics', 'Numerical Methods', 3],
            ['AMATH201', 'Applied Mathematics II', 'Applied Mathematics', 'Optimization', 3],
            ['LAW101', 'Introduction to Law', 'Law', 'Legal Principles', 3],
            ['LAW201', 'Constitutional Law', 'Law', 'Constitutional Studies', 3],
            ['EDU101', 'Educational Theory', 'Education', 'Pedagogy', 3],
            ['EDU201', 'Curriculum Development', 'Education', 'Instructional Design', 3],
            ['AGR101', 'Agricultural Fundamentals', 'Agriculture', 'Crop Science', 3],
            ['AGR201', 'Soil Science', 'Agriculture', 'Soil Management', 3],
            ['ENG101', 'Engineering Field Fundamentals', 'Engineering Field', 'General Engineering', 3],
            ['ENG201', 'Professional Practice', 'Engineering Field', 'Engineering Ethics', 3],
            ['HAD101', 'Health Administration Basics', 'Health Academic', 'Healthcare Management', 3],
            ['HAD201', 'Health Policy', 'Health Academic', 'Policy Studies', 3],
            ['SS101', 'Introduction to Social Science', 'Social Science', 'Social Theory', 3],
            ['SS201', 'Research Methods', 'Social Science', 'Methodology', 3],
            ['NS101', 'Natural Science Overview', 'Natural Science', 'Science Foundations', 3],
            ['NS201', 'Scientific Methods', 'Natural Science', 'Research Techniques', 3],
            ['OTH101', 'Other Studies I', 'Other', 'General Studies', 3],
            ['OTH201', 'Other Studies II', 'Other', 'Special Topics', 3],
        ];

        foreach ($courses as $course) {
            [$code, $name, $dept, $subFieldName, $credits] = $course;
            
            $subField = SubField::whereHas('department', function ($q) use ($dept) {
                $q->where('name', $dept);
            })->where('name', $subFieldName)->first();

            Course::updateOrCreate(
                ['course_code' => $code],
                [
                    'course_name' => $name,
                    'department' => $dept,
                    'sub_field' => $subFieldName,
                    'sub_field_id' => $subField->id ?? null,
                    'credits' => $credits,
                ]
            );
        }
    }
}
