@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-book fa-3x text-primary"></i>
                    <h3>{{ $stats['total_courses'] ?? 0 }}</h3>
                    <p>Enrolled Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-success"></i>
                    <h3>{{ $stats['average_grade'] ?? 'N/A' }}</h3>
                    <p>Average Grade (GPA)</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-calendar-check fa-3x text-warning"></i>
                    <h3>{{ $stats['attendance_rate'] ?? 'N/A' }}</h3>
                    <p>Attendance Rate</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('student.profile') }}" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('student.grades') }}" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-graduation-cap"></i> My Grades
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('student.attendance') }}" class="btn btn-info btn-lg w-100">
                        <i class="fas fa-calendar-alt"></i> My Attendance
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection