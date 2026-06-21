@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5>Add/Update Grade</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.add-grade') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Student (List No - First Name Last Name)</label>
                        <select name="student_id" class="form-control" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->list_no }} - {{ $student->first_name }} {{ $student->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }} ({{ $course->course_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Grade</label>
                        <select name="grade" class="form-control" required>
                            <option value="">Select Grade</option>
                            <option value="A+">A+</option>
                            <option value="A">A</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B">B</option>
                            <option value="B-">B-</option>
                            <option value="C+">C+</option>
                            <option value="C">C</option>
                            <option value="C-">C-</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Semester</label>
                        <input type="number" name="semester" class="form-control" required min="1" max="4">
                    </div>
                    <div class="mb-3">
                        <label>Academic Year</label>
                        <input type="number" name="academic_year" class="form-control" required value="{{ date('Y') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Grade</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grades List (List No, Student Name, Course, Grade)</h5>
                <form action="{{ route('teacher.submit-grades') }}" method="POST" id="submitForm">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Submit selected grades to registrar?')">
                        <i class="fas fa-paper-plane"></i> Submit to Registrar
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>List No</th>
                                <th>Student Name</th>
                                <th>Course Name</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td>
                                    @if($grade->status == 'draft')
                                        <input type="checkbox" name="grade_ids[]" value="{{ $grade->id }}" form="submitForm">
                                    @endif
                                </td>
                                <td>{{ $grade->student->list_no }}</td>
                                <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                <td>{{ $grade->course->course_name }}</td>
                                <td>{{ $grade->grade }}</td>
                                <td>
                                    @if($grade->status == 'submitted')
                                        <span class="badge bg-success">Submitted</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($grade->status == 'draft')
                                        <form action="{{ route('teacher.delete-grade', $grade->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this grade?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No grades added yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="grade_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection