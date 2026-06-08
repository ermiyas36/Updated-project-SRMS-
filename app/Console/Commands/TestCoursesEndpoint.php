<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Course;

class TestCoursesEndpoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-courses-endpoint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the courses by department endpoint';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing courses endpoint...');

        // Test direct database query
        $departments = Course::select('department')->distinct()->pluck('department');
        $this->info('Available departments: ' . $departments->join(', '));

        // Test with Psychology department
        $courses = Course::where('department', 'Psychology')->get();
        $this->info('Psychology courses: ' . $courses->count());
        foreach ($courses as $course) {
            $this->line("  - {$course->course_code}: {$course->course_name} ({$course->sub_field})");
        }

        $this->info('Test completed successfully!');
    }
}
