<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicPeriod;

class AcademicPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periods = [
            ['semester' => 1, 'academic_year' => 2024, 'start_date' => '2024-01-08', 'end_date' => '2024-05-31', 'status' => 'completed'],
            ['semester' => 2, 'academic_year' => 2024, 'start_date' => '2024-06-01', 'end_date' => '2024-10-31', 'status' => 'completed'],
            ['semester' => 1, 'academic_year' => 2025, 'start_date' => '2025-01-08', 'end_date' => '2025-05-31', 'status' => 'completed'],
            ['semester' => 2, 'academic_year' => 2025, 'start_date' => '2025-06-01', 'end_date' => '2025-10-31', 'status' => 'active'],
            ['semester' => 1, 'academic_year' => 2026, 'start_date' => '2026-01-08', 'end_date' => '2026-05-31', 'status' => 'active'],
        ];

        foreach ($periods as $period) {
            AcademicPeriod::updateOrCreate(
                ['semester' => $period['semester'], 'academic_year' => $period['academic_year']],
                $period
            );
        }
    }
}
