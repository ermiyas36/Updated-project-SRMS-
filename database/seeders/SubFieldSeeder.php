<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubField;
use App\Models\Department;

class SubFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subFields = [
            // Nursing
            ['department' => 'Nursing', 'name' => 'Basic Nursing'],
            ['department' => 'Nursing', 'name' => 'Clinical Nursing'],
            // Medicine
            ['department' => 'Medicine', 'name' => 'Basic Sciences'],
            ['department' => 'Medicine', 'name' => 'Clinical Medicine'],
            // Informatics
            ['department' => 'Informatics', 'name' => 'Computer Fundamentals'],
            ['department' => 'Informatics', 'name' => 'Software Development'],
            // Computer Science
            ['department' => 'Computer Science', 'name' => 'Programming'],
            ['department' => 'Computer Science', 'name' => 'Algorithms'],
            // Electrical Engineering
            ['department' => 'Electrical Engineering', 'name' => 'Circuits'],
            ['department' => 'Electrical Engineering', 'name' => 'Electronics'],
            // Mechanical Engineering
            ['department' => 'Mechanical Engineering', 'name' => 'Mechanics'],
            ['department' => 'Mechanical Engineering', 'name' => 'Energy Systems'],
            // Civil Engineering
            ['department' => 'Civil Engineering', 'name' => 'Materials'],
            ['department' => 'Civil Engineering', 'name' => 'Structures'],
            // Psychology
            ['department' => 'Psychology', 'name' => 'General Psychology'],
            ['department' => 'Psychology', 'name' => 'Clinical Practice'],
            // Sociology
            ['department' => 'Sociology', 'name' => 'Social Theory'],
            ['department' => 'Sociology', 'name' => 'Research Methods'],
            // Political Science
            ['department' => 'Political Science', 'name' => 'Political Theory'],
            ['department' => 'Political Science', 'name' => 'Global Politics'],
            // Economics
            ['department' => 'Economics', 'name' => 'Microeconomics'],
            ['department' => 'Economics', 'name' => 'Macroeconomics'],
            // Biology
            ['department' => 'Biology', 'name' => 'Cell Biology'],
            ['department' => 'Biology', 'name' => 'Molecular Biology'],
            // Chemistry
            ['department' => 'Chemistry', 'name' => 'Organic Chemistry'],
            ['department' => 'Chemistry', 'name' => 'Analytical Methods'],
            // Physics
            ['department' => 'Physics', 'name' => 'Classical Physics'],
            ['department' => 'Physics', 'name' => 'Modern Physics'],
            // Environmental Science
            ['department' => 'Environmental Science', 'name' => 'Ecology'],
            ['department' => 'Environmental Science', 'name' => 'Conservation'],
            // Business
            ['department' => 'Business', 'name' => 'Business Fundamentals'],
            ['department' => 'Business', 'name' => 'Strategy'],
            // Accounting
            ['department' => 'Accounting', 'name' => 'Financial Reporting'],
            ['department' => 'Accounting', 'name' => 'Cost Analysis'],
            // Finance
            ['department' => 'Finance', 'name' => 'Financial Management'],
            ['department' => 'Finance', 'name' => 'Investments'],
            // Marketing
            ['department' => 'Marketing', 'name' => 'Marketing Strategy'],
            ['department' => 'Marketing', 'name' => 'Digital Strategy'],
            // Management
            ['department' => 'Management', 'name' => 'Organizational Management'],
            ['department' => 'Management', 'name' => 'HR Strategy'],
            // Literature
            ['department' => 'Literature', 'name' => 'Literary Analysis'],
            ['department' => 'Literature', 'name' => 'Comparative Literature'],
            // History
            ['department' => 'History', 'name' => 'World Events'],
            ['department' => 'History', 'name' => 'Contemporary History'],
            // Philosophy
            ['department' => 'Philosophy', 'name' => 'Philosophical Thinking'],
            ['department' => 'Philosophy', 'name' => 'Moral Philosophy'],
            // Fine Arts
            ['department' => 'Fine Arts', 'name' => 'Art Theory'],
            ['department' => 'Fine Arts', 'name' => 'Modern Art'],
            // Languages
            ['department' => 'Languages', 'name' => 'Linguistics'],
            ['department' => 'Languages', 'name' => 'Applied Languages'],
            // Mathematics
            ['department' => 'Mathematics', 'name' => 'Calculus'],
            ['department' => 'Mathematics', 'name' => 'Algebra'],
            // Statistics
            ['department' => 'Statistics', 'name' => 'Descriptive Statistics'],
            ['department' => 'Statistics', 'name' => 'Hypothesis Testing'],
            // Applied Mathematics
            ['department' => 'Applied Mathematics', 'name' => 'Numerical Methods'],
            ['department' => 'Applied Mathematics', 'name' => 'Optimization'],
            // Law
            ['department' => 'Law', 'name' => 'Legal Principles'],
            ['department' => 'Law', 'name' => 'Constitutional Studies'],
            // Education
            ['department' => 'Education', 'name' => 'Pedagogy'],
            ['department' => 'Education', 'name' => 'Instructional Design'],
            // Agriculture
            ['department' => 'Agriculture', 'name' => 'Crop Science'],
            ['department' => 'Agriculture', 'name' => 'Soil Management'],
            // Engineering Field
            ['department' => 'Engineering Field', 'name' => 'General Engineering'],
            ['department' => 'Engineering Field', 'name' => 'Engineering Ethics'],
            // Health Academic
            ['department' => 'Health Academic', 'name' => 'Healthcare Management'],
            ['department' => 'Health Academic', 'name' => 'Policy Studies'],
            // Public Health
            ['department' => 'Public Health', 'name' => 'Public Health'],
            ['department' => 'Public Health', 'name' => 'Disease Prevention'],
            // Social Science
            ['department' => 'Social Science', 'name' => 'Social Theory'],
            ['department' => 'Social Science', 'name' => 'Methodology'],
            // Natural Science
            ['department' => 'Natural Science', 'name' => 'Science Foundations'],
            ['department' => 'Natural Science', 'name' => 'Research Techniques'],
            // Other
            ['department' => 'Other', 'name' => 'General Studies'],
            ['department' => 'Other', 'name' => 'Special Topics'],
        ];

        foreach ($subFields as $subField) {
            $dept = Department::where('name', $subField['department'])->first();
            if ($dept) {
                SubField::updateOrCreate(
                    ['name' => $subField['name'], 'department_id' => $dept->id],
                    ['description' => null]
                );
            }
        }
    }
}
