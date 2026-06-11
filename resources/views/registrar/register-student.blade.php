@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Register New Student</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('registrar.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>List No (Auto-generated)</label>
                            <input type="text" class="form-control" value="Auto-generated" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="form-text text-muted d-block mt-1">
                                <strong>Requirements:</strong> 8+ chars, Uppercase, Lowercase, Number
                            </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Department</label>
                            <select name="department" id="department" class="form-control" required>
                                <option value="">Select Department</option>
                                <optgroup label="Health Academic">
                                    <option value="Health Academic" {{ old('department') == 'Health Academic' ? 'selected' : '' }}>Health Academic</option>
                                    <option value="Nursing" {{ old('department') == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                                    <option value="Medicine" {{ old('department') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                                    <option value="Public Health" {{ old('department') == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                                </optgroup>
                                <optgroup label="Engineering">
                                    <option value="Informatics" {{ old('department') == 'Informatics' ? 'selected' : '' }}>Informatics</option>
                                    <option value="Engineering Field" {{ old('department') == 'Engineering Field' ? 'selected' : '' }}>Engineering Field</option>
                                    <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="Electrical Engineering" {{ old('department') == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                                    <option value="Mechanical Engineering" {{ old('department') == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                                    <option value="Civil Engineering" {{ old('department') == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                                </optgroup>
                                <optgroup label="Social Science">
                                    <option value="Social Science" {{ old('department') == 'Social Science' ? 'selected' : '' }}>Social Science</option>
                                    <option value="Psychology" {{ old('department') == 'Psychology' ? 'selected' : '' }}>Psychology</option>
                                    <option value="Sociology" {{ old('department') == 'Sociology' ? 'selected' : '' }}>Sociology</option>
                                    <option value="Political Science" {{ old('department') == 'Political Science' ? 'selected' : '' }}>Political Science</option>
                                    <option value="Economics" {{ old('department') == 'Economics' ? 'selected' : '' }}>Economics</option>
                                </optgroup>
                                <optgroup label="Natural Science">
                                    <option value="Natural Science" {{ old('department') == 'Natural Science' ? 'selected' : '' }}>Natural Science</option>
                                    <option value="Biology" {{ old('department') == 'Biology' ? 'selected' : '' }}>Biology</option>
                                    <option value="Chemistry" {{ old('department') == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
                                    <option value="Physics" {{ old('department') == 'Physics' ? 'selected' : '' }}>Physics</option>
                                    <option value="Environmental Science" {{ old('department') == 'Environmental Science' ? 'selected' : '' }}>Environmental Science</option>
                                </optgroup>
                                <optgroup label="Business & Management">
                                    <option value="Business" {{ old('department') == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Accounting" {{ old('department') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                                    <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Management" {{ old('department') == 'Management' ? 'selected' : '' }}>Management</option>
                                </optgroup>
                                <optgroup label="Arts & Humanities">
                                    <option value="Literature" {{ old('department') == 'Literature' ? 'selected' : '' }}>Literature</option>
                                    <option value="History" {{ old('department') == 'History' ? 'selected' : '' }}>History</option>
                                    <option value="Philosophy" {{ old('department') == 'Philosophy' ? 'selected' : '' }}>Philosophy</option>
                                    <option value="Fine Arts" {{ old('department') == 'Fine Arts' ? 'selected' : '' }}>Fine Arts</option>
                                    <option value="Languages" {{ old('department') == 'Languages' ? 'selected' : '' }}>Languages</option>
                                </optgroup>
                                <optgroup label="Mathematics & Statistics">
                                    <option value="Mathematics" {{ old('department') == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                                    <option value="Statistics" {{ old('department') == 'Statistics' ? 'selected' : '' }}>Statistics</option>
                                    <option value="Applied Mathematics" {{ old('department') == 'Applied Mathematics' ? 'selected' : '' }}>Applied Mathematics</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="Law" {{ old('department') == 'Law' ? 'selected' : '' }}>Law</option>
                                    <option value="Education" {{ old('department') == 'Education' ? 'selected' : '' }}>Education</option>
                                    <option value="Agriculture" {{ old('department') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                    <option value="Other" {{ old('department') == 'Other' ? 'selected' : '' }}>Other</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Assign Teacher</label>
                            <select name="teacher_id" id="teacher_id" class="form-control" required>
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" data-department="{{ $teacher->department }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }} ({{ $teacher->department }})
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted d-block mt-1">
                                Registered students are assigned to a teacher from the same department.
                            </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Year</label>
                            <select name="year" class="form-control" required>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Upload Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const departmentSelect = document.getElementById('department');
        const teacherSelect = document.getElementById('teacher_id');

        function filterTeachers() {
            const selectedDepartment = departmentSelect.value;
            let firstVisibleIndex = -1;

            Array.from(teacherSelect.options).forEach((option, index) => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                const teacherDepartment = option.dataset.department || '';
                const visible = selectedDepartment === '' || teacherDepartment === selectedDepartment;
                option.hidden = !visible;

                if (visible && firstVisibleIndex === -1) {
                    firstVisibleIndex = index;
                }
            });

            if (selectedDepartment && firstVisibleIndex !== -1) {
                teacherSelect.selectedIndex = firstVisibleIndex;
            }
        }

        departmentSelect.addEventListener('change', filterTeachers);
        filterTeachers();
    });
</script>
@endpush
@endsection