@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Register New Student</h5>
                <form method="GET" action="{{ route('registrar.register-student') }}" class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                    <label for="registration_mode_switch" class="mb-0 small text-muted">Registration mode</label>
                    <select id="registration_mode_switch" name="mode" class="form-select form-select-sm" style="max-width: 240px;" onchange="this.form.submit()">
                        <option value="old" {{ $mode === 'old' ? 'selected' : '' }}>Old Regular Registration</option>
                        <option value="new" {{ $mode === 'new' ? 'selected' : '' }}>New Regular Registration</option>
                    </select>
                </form>
            </div>
            <div class="card-body">
                <form action="{{ route('registrar.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="registration_mode" value="{{ $mode ?? 'old' }}">
                    <div class="row">
                        @php
                            $isNewRegular = $mode === 'new' || in_array($group, ['freshman', 'remedial'], true);
                        @endphp
                        <div class="col-12 mb-3">
                            <div class="alert {{ $isNewRegular ? 'alert-warning' : 'alert-info' }} mb-0">
                                @if($isNewRegular)
                                    New Regular registration is for Freshman and Remedial students only. This path keeps the registration limited to the approved group details.
                                @else
                                    Old Regular registration is for department-based students across all colleges and departments.
                                @endif
                            </div>
                        </div>

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

                        @unless($isNewRegular)
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
                        @endunless

                        @if($isNewRegular)
                            <div class="col-md-6 mb-3">
                                <label>Student Group</label>
                                <select name="student_group" id="student_group" class="form-control" required>
                                    <option value="">Select Group</option>
                                    <option value="freshman" {{ old('student_group', $group) == 'freshman' ? 'selected' : '' }}>Freshman (F-N)</option>
                                    <option value="remedial" {{ old('student_group', $group) == 'remedial' ? 'selected' : '' }}>Remedial (RIM)</option>
                                </select>
                                <small class="form-text text-muted d-block mt-1">New Regular registration only accepts Freshman or Remedial student entries.</small>
                            </div>

                            <div class="col-md-6 mb-3" id="freshman_department_group" style="display: none;">
                                <label>Freshman Category</label>
                                <select name="department" id="freshman_department" class="form-control">
                                    <option value="">Select Natural or Social</option>
                                    <option value="Natural Science" {{ old('department') == 'Natural Science' ? 'selected' : '' }}>Natural</option>
                                    <option value="Social Science" {{ old('department') == 'Social Science' ? 'selected' : '' }}>Social</option>
                                </select>
                                <small class="form-text text-muted d-block mt-1">For Freshman registration, choose Natural or Social.</small>
                            </div>
                        @endif

                        @unless($isNewRegular)
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
                                    <optgroup label="Engineering / Informatics">
                                        <option value="Software Engineering" {{ old('department') == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                                        <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                        <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                                        <option value="Information Systems" {{ old('department') == 'Information Systems' ? 'selected' : '' }}>Information Systems</option>
                                        <option value="Engineering Field" {{ old('department') == 'Engineering Field' ? 'selected' : '' }}>Engineering Field</option>
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
                        @endunless

                        @unless($isNewRegular)
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
                        @endunless

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

                    <button type="submit" class="btn btn-primary">{{ $isNewRegular ? 'Register New Regular Student' : 'Register Old Regular Student' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const studentGroupSelect = document.getElementById('student_group');
        const freshmanDepartmentGroup = document.getElementById('freshman_department_group');
        const freshmanDepartmentSelect = document.getElementById('freshman_department');
        const departmentSelect = document.getElementById('department');
        const teacherSelect = document.getElementById('teacher_id');

        function toggleFreshmanDepartmentField() {
            if (!studentGroupSelect || !freshmanDepartmentGroup || !freshmanDepartmentSelect) {
                return;
            }

            const isFreshman = studentGroupSelect.value === 'freshman';
            freshmanDepartmentGroup.style.display = isFreshman ? 'block' : 'none';
            freshmanDepartmentSelect.required = isFreshman;
        }

        if (studentGroupSelect) {
            studentGroupSelect.addEventListener('change', toggleFreshmanDepartmentField);
            toggleFreshmanDepartmentField();
        }

        if (!departmentSelect || !teacherSelect) {
            return;
        }

        function normalizeDepartment(value) {
            return (value || '').toString().trim().toLowerCase();
        }

        function matchesDepartment(selectedDepartment, teacherDepartment) {
            if (!selectedDepartment) {
                return true;
            }

            return normalizeDepartment(teacherDepartment) === normalizeDepartment(selectedDepartment);
        }

        function filterTeachers() {
            const selectedDepartment = departmentSelect.value;
            let firstVisibleIndex = -1;

            Array.from(teacherSelect.options).forEach((option, index) => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                const teacherDepartment = option.dataset.department || '';
                const visible = matchesDepartment(selectedDepartment, teacherDepartment);
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