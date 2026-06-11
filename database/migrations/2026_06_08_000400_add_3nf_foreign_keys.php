<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null')->after('department');
        });

        // Add new columns to courses table
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('sub_field_id')->nullable()->constrained('sub_fields')->onDelete('set null')->after('sub_field');
        });

        // Add academic_period_id to grades table
        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('academic_period_id')->nullable()->constrained('academic_periods')->onDelete('set null')->after('course_id');
        });

        // Add academic_period_id to enrollments table
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreignId('academic_period_id')->nullable()->constrained('academic_periods')->onDelete('set null')->after('course_id');
        });

        // Add academic_period_id to attendances table (optional but helpful)
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'academic_period_id')) {
                $table->foreignId('academic_period_id')->nullable()->constrained('academic_periods')->onDelete('set null')->after('date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sub_field_id');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_period_id');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_period_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'academic_period_id')) {
                $table->dropConstrainedForeignId('academic_period_id');
            }
        });
    }
};
