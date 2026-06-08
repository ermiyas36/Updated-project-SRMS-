@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>My Grades</h5>
    </div>
    <div class="card-body">
        @forelse($grades as $semester => $semesterGrades)
            <h4 class="mt-3">Semester {{ $semester }}</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Grade</th>
                            <th>Academic Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semesterGrades as $grade)
                        <tr>
                            <td>{{ $grade->course->course_name }}</td>
                            <td>{{ $grade->course->course_code }}</td>
                            <td>
                                @if($grade->grade)
                                    <span class="badge bg-{{ $grade->grade == 'F' ? 'danger' : 'success' }}">
                                        {{ $grade->grade }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">Not Graded</span>
                                @endif
                            </td>
                            <td>{{ $grade->academic_year }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="alert alert-info">No grades found.</div>
        @endforelse
    </div>
</div>
@endsection