@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <h3>{{ $totalStudents }}</h3>
                    <p>Total Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-3x text-success"></i>
                    <h3>{{ $newStudents }}</h3>
                    <p>New Students ({{ date('Y') }})</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-graduation-cap fa-3x text-warning"></i>
                    <h3>{{ $graduatingStudents }}</h3>
                    <p>Graduating Students</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('registrar.register-student') }}" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-user-plus"></i> Register New Student
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('registrar.students') }}" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-list"></i> View All Students
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('registrar.enrollment') }}" class="btn btn-info btn-lg w-100">
                        <i class="fas fa-book-open"></i> Manage Enrollment
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                    <div>
                        <a href="{{ route('registrar.grades') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-chart-line"></i> View Student Grades
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection