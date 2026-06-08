@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Course Enrollment Management</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('registrar.enrollment.manage') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="student_id" class="form-label">Select Student</label>
                                <select name="student_id" id="student_id" class="form-select" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="course_id" class="form-label">Select Course</label>
                                <select name="course_id" id="course_id" class="form-select" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="semester" class="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-select" required>
                                    <option value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                    <option value="3">3rd Semester</option>
                                    <option value="4">4th Semester</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="academic_year" class="form-label">Academic Year</label>
                                <input type="number" name="academic_year" id="academic_year" class="form-control" value="{{ date('Y') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Enroll Student</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Enrolled Students</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Academic Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                                        <td>{{ $enrollment->student->email }}</td>
                                        <td>{{ $enrollment->course->course_name }}</td>
                                        <td>{{ $enrollment->semester }}</td>
                                        <td>{{ $enrollment->academic_year }}</td>
                                        <td>
                                            <form action="{{ route('registrar.enrollment.remove', $enrollment->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this enrollment?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No students enrolled yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection