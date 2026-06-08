@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.students') }}">
                            <i class="fas fa-users"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.teachers') }}">
                            <i class="fas fa-chalkboard-user"></i> Teachers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.grades') }}">
                            <i class="fas fa-chart-line"></i> Grades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.reports') }}">
                            <i class="fas fa-file-alt"></i> Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Teacher</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" data-assigned-courses="{{ $teacher->assignedCourses->pluck('id')->toJson() }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="{{ $teacher->first_name }}" class="form-control" required>
                                <small class="form-text text-muted">Only letters and spaces allowed.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="{{ $teacher->last_name }}" class="form-control" required>
                                <small class="form-text text-muted">Only letters and spaces allowed.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $teacher->email }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>New Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Department</label>
                                <select name="department" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <optgroup label="Health Academic">
                                        <option value="Health Academic" {{ $teacher->department == 'Health Academic' ? 'selected' : '' }}>Health Academic</option>
                                        <option value="Nursing" {{ $teacher->department == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                                        <option value="Medicine" {{ $teacher->department == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                                        <option value="Public Health" {{ $teacher->department == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                                    </optgroup>
                                    <optgroup label="Engineering">
                                        <option value="Informatics" {{ $teacher->department == 'Informatics' ? 'selected' : '' }}>Informatics</option>
                                        <option value="Engineering Field" {{ $teacher->department == 'Engineering Field' ? 'selected' : '' }}>Engineering Field</option>
                                        <option value="Computer Science" {{ $teacher->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                        <option value="Electrical Engineering" {{ $teacher->department == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                                        <option value="Mechanical Engineering" {{ $teacher->department == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                                        <option value="Civil Engineering" {{ $teacher->department == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                                    </optgroup>
                                    <optgroup label="Social Science">
                                        <option value="Social Science" {{ $teacher->department == 'Social Science' ? 'selected' : '' }}>Social Science</option>
                                        <option value="Psychology" {{ $teacher->department == 'Psychology' ? 'selected' : '' }}>Psychology</option>
                                        <option value="Sociology" {{ $teacher->department == 'Sociology' ? 'selected' : '' }}>Sociology</option>
                                        <option value="Political Science" {{ $teacher->department == 'Political Science' ? 'selected' : '' }}>Political Science</option>
                                        <option value="Economics" {{ $teacher->department == 'Economics' ? 'selected' : '' }}>Economics</option>
                                    </optgroup>
                                    <optgroup label="Natural Science">
                                        <option value="Natural Science" {{ $teacher->department == 'Natural Science' ? 'selected' : '' }}>Natural Science</option>
                                        <option value="Biology" {{ $teacher->department == 'Biology' ? 'selected' : '' }}>Biology</option>
                                        <option value="Chemistry" {{ $teacher->department == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
                                        <option value="Physics" {{ $teacher->department == 'Physics' ? 'selected' : '' }}>Physics</option>
                                        <option value="Environmental Science" {{ $teacher->department == 'Environmental Science' ? 'selected' : '' }}>Environmental Science</option>
                                    </optgroup>
                                    <optgroup label="Business & Management">
                                        <option value="Business" {{ $teacher->department == 'Business' ? 'selected' : '' }}>Business</option>
                                        <option value="Accounting" {{ $teacher->department == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                                        <option value="Finance" {{ $teacher->department == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Marketing" {{ $teacher->department == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="Management" {{ $teacher->department == 'Management' ? 'selected' : '' }}>Management</option>
                                    </optgroup>
                                    <optgroup label="Arts & Humanities">
                                        <option value="Literature" {{ $teacher->department == 'Literature' ? 'selected' : '' }}>Literature</option>
                                        <option value="History" {{ $teacher->department == 'History' ? 'selected' : '' }}>History</option>
                                        <option value="Philosophy" {{ $teacher->department == 'Philosophy' ? 'selected' : '' }}>Philosophy</option>
                                        <option value="Fine Arts" {{ $teacher->department == 'Fine Arts' ? 'selected' : '' }}>Fine Arts</option>
                                        <option value="Languages" {{ $teacher->department == 'Languages' ? 'selected' : '' }}>Languages</option>
                                    </optgroup>
                                    <optgroup label="Mathematics & Statistics">
                                        <option value="Mathematics" {{ $teacher->department == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                                        <option value="Statistics" {{ $teacher->department == 'Statistics' ? 'selected' : '' }}>Statistics</option>
                                        <option value="Applied Mathematics" {{ $teacher->department == 'Applied Mathematics' ? 'selected' : '' }}>Applied Mathematics</option>
                                    </optgroup>
                                    <optgroup label="Other">
                                        <option value="Law" {{ $teacher->department == 'Law' ? 'selected' : '' }}>Law</option>
                                        <option value="Education" {{ $teacher->department == 'Education' ? 'selected' : '' }}>Education</option>
                                        <option value="Agriculture" {{ $teacher->department == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                        <option value="Other" {{ $teacher->department == 'Other' ? 'selected' : '' }}>Other</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Assigned Courses</label>
                                <div id="coursesContainer">
                                    @if($teacher->department)
                                        <div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading courses...</div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Please select a department first to load available courses.
                                        </div>
                                    @endif
                                </div>
                                <small class="form-text text-muted">Select the courses this teacher will be responsible for grading.</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Teacher</button>
                        <a href="{{ route('admin.teachers') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var departmentSelect = document.getElementById('department');
        var coursesContainer = document.getElementById('coursesContainer');
        var assignedCourses = JSON.parse(document.querySelector('form[data-assigned-courses]').getAttribute('data-assigned-courses') || '[]').map(Number);

        function renderMessage(html) {
            coursesContainer.innerHTML = html;
        }

        function loadCoursesByDepartment(department, selectedCourses) {
            console.log('Loading courses for department:', department);
            renderMessage('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading courses...</div>');
            fetch('{{ route("admin.courses.by-department") }}?department=' + encodeURIComponent(department), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error, status = ' + response.status);
                }
                return response.json();
            })
            .then(function (data) {
                console.log('Courses data:', data);
                if (data.courses && data.courses.length > 0) {
                    displayCourses(data.courses, data.subFields, selectedCourses);
                } else {
                    renderMessage('<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> No courses found for this department.</div>');
                }
            })
            .catch(function (error) {
                console.error('Error loading courses:', error);
                renderMessage('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error loading courses. Please try again. Error: ' + error.message + '</div>');
            });
        }

        function displayCourses(courses, subFields, selectedCourses) {
            if (!courses || courses.length === 0) {
                renderMessage('<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> No courses found for this department.</div>');
                return;
            }

            var html = '<div class="course-selection-container">';
            html += '<div class="mb-3"><button type="button" class="btn btn-sm btn-outline-primary" id="selectAllCourses">Select All</button> <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllCourses">Clear All</button></div>';

            if (subFields && Object.keys(subFields).length > 0) {
                Object.keys(subFields).forEach(function (subField) {
                    var subFieldCourses = courses.filter(function (course) {
                        return course.sub_field === subField;
                    });

                    if (subFieldCourses.length > 0) {
                        html += '<div class="sub-field-section mb-4">';
                        html += '<h6 class="sub-field-title"><i class="fas fa-graduation-cap"></i> ' + subField + ' (' + subFieldCourses.length + ' courses)</h6>';
                        html += '<div class="course-checkboxes">';
                        subFieldCourses.forEach(function (course) {
                            var isChecked = selectedCourses.includes(Number(course.id)) ? 'checked' : '';
                            html += '<div class="form-check">';
                            html += '<input class="form-check-input course-checkbox" type="checkbox" name="courses[]" value="' + course.id + '" id="course_' + course.id + '" ' + isChecked + '>';
                            html += '<label class="form-check-label" for="course_' + course.id + '">';
                            html += '<strong>' + course.course_code + '</strong> - ' + course.course_name;
                            html += '<small class="text-muted"> (' + course.credits + ' credits)</small>';
                            html += '</label>';
                            html += '</div>';
                        });
                        html += '</div></div>';
                    }
                });
            } else {
                html += '<div class="course-checkboxes">';
                courses.forEach(function (course) {
                    var isChecked = selectedCourses.includes(Number(course.id)) ? 'checked' : '';
                    html += '<div class="form-check">';
                    html += '<input class="form-check-input course-checkbox" type="checkbox" name="courses[]" value="' + course.id + '" id="course_' + course.id + '" ' + isChecked + '>';
                    html += '<label class="form-check-label" for="course_' + course.id + '">';
                    html += '<strong>' + course.course_code + '</strong> - ' + course.course_name;
                    html += '<small class="text-muted"> (' + course.credits + ' credits)</small>';
                    html += '</label>';
                    html += '</div>';
                });
                html += '</div>';
            }

            html += '</div>';
            coursesContainer.innerHTML = html;
            attachCourseButtons();
        }

        function attachCourseButtons() {
            var selectAll = document.getElementById('selectAllCourses');
            var clearAll = document.getElementById('clearAllCourses');

            if (selectAll) {
                selectAll.addEventListener('click', function () {
                    document.querySelectorAll('.course-checkbox').forEach(function (checkbox) {
                        checkbox.checked = true;
                    });
                });
            }

            if (clearAll) {
                clearAll.addEventListener('click', function () {
                    document.querySelectorAll('.course-checkbox').forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                });
            }
        }

        var initialDepartment = departmentSelect.value;
        if (initialDepartment) {
            loadCoursesByDepartment(initialDepartment, assignedCourses);
        }

        departmentSelect.addEventListener('change', function () {
            var department = this.value;
            console.log('Department changed to:', department);
            if (department) {
                loadCoursesByDepartment(department, assignedCourses);
            } else {
                renderMessage('<div class="alert alert-info"><i class="fas fa-info-circle"></i> Please select a department first to load available courses.</div>');
            }
        });
    });
</script>
@endpush
@endsection