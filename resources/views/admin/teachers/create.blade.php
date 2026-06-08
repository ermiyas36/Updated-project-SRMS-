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
                <h1 class="h2">Add New Teacher</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    <small class="form-text text-muted">Only letters and spaces allowed.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    <small class="form-text text-muted">Only letters and spaces allowed.</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted d-block mt-1">
                                <strong>Requirements:</strong> 8+ chars, Uppercase, Lowercase, Number
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="">Select Department</option>
                                <optgroup label="Health Academic">
                                    <option value="Health Academic" @selected(old('department') == 'Health Academic')>Health Academic</option>
                                    <option value="Nursing" @selected(old('department') == 'Nursing')>Nursing</option>
                                    <option value="Medicine" @selected(old('department') == 'Medicine')>Medicine</option>
                                    <option value="Public Health" @selected(old('department') == 'Public Health')>Public Health</option>
                                </optgroup>
                                <optgroup label="Engineering">
                                    <option value="Informatics" @selected(old('department') == 'Informatics')>Informatics</option>
                                    <option value="Engineering Field" @selected(old('department') == 'Engineering Field')>Engineering Field</option>
                                    <option value="Computer Science" @selected(old('department') == 'Computer Science')>Computer Science</option>
                                    <option value="Electrical Engineering" @selected(old('department') == 'Electrical Engineering')>Electrical Engineering</option>
                                    <option value="Mechanical Engineering" @selected(old('department') == 'Mechanical Engineering')>Mechanical Engineering</option>
                                    <option value="Civil Engineering" @selected(old('department') == 'Civil Engineering')>Civil Engineering</option>
                                </optgroup>
                                <optgroup label="Social Science">
                                    <option value="Social Science" @selected(old('department') == 'Social Science')>Social Science</option>
                                    <option value="Psychology" @selected(old('department') == 'Psychology')>Psychology</option>
                                    <option value="Sociology" @selected(old('department') == 'Sociology')>Sociology</option>
                                    <option value="Political Science" @selected(old('department') == 'Political Science')>Political Science</option>
                                    <option value="Economics" @selected(old('department') == 'Economics')>Economics</option>
                                </optgroup>
                                <optgroup label="Natural Science">
                                    <option value="Natural Science" @selected(old('department') == 'Natural Science')>Natural Science</option>
                                    <option value="Biology" @selected(old('department') == 'Biology')>Biology</option>
                                    <option value="Chemistry" @selected(old('department') == 'Chemistry')>Chemistry</option>
                                    <option value="Physics" @selected(old('department') == 'Physics')>Physics</option>
                                    <option value="Environmental Science" @selected(old('department') == 'Environmental Science')>Environmental Science</option>
                                </optgroup>
                                <optgroup label="Business & Management">
                                    <option value="Business" @selected(old('department') == 'Business')>Business</option>
                                    <option value="Accounting" @selected(old('department') == 'Accounting')>Accounting</option>
                                    <option value="Finance" @selected(old('department') == 'Finance')>Finance</option>
                                    <option value="Marketing" @selected(old('department') == 'Marketing')>Marketing</option>
                                    <option value="Management" @selected(old('department') == 'Management')>Management</option>
                                </optgroup>
                                <optgroup label="Arts & Humanities">
                                    <option value="Literature" @selected(old('department') == 'Literature')>Literature</option>
                                    <option value="History" @selected(old('department') == 'History')>History</option>
                                    <option value="Philosophy" @selected(old('department') == 'Philosophy')>Philosophy</option>
                                    <option value="Fine Arts" @selected(old('department') == 'Fine Arts')>Fine Arts</option>
                                    <option value="Languages" @selected(old('department') == 'Languages')>Languages</option>
                                </optgroup>
                                <optgroup label="Mathematics & Statistics">
                                    <option value="Mathematics" @selected(old('department') == 'Mathematics')>Mathematics</option>
                                    <option value="Statistics" @selected(old('department') == 'Statistics')>Statistics</option>
                                    <option value="Applied Mathematics" @selected(old('department') == 'Applied Mathematics')>Applied Mathematics</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="Law" @selected(old('department') == 'Law')>Law</option>
                                    <option value="Education" @selected(old('department') == 'Education')>Education</option>
                                    <option value="Agriculture" @selected(old('department') == 'Agriculture')>Agriculture</option>
                                    <option value="Other" @selected(old('department') == 'Other')>Other</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="courses" class="form-label">Assigned Courses</label>
                            <div id="coursesContainer" data-selected-courses="{{ json_encode(old('courses', [])) }}">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Please select a department first to load available courses.
                                </div>
                            </div>
                            @error('courses')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            @error('courses.*')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Select the courses this teacher will be responsible for grading.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Teacher</button>
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
        var selectedCourses = JSON.parse(coursesContainer.getAttribute('data-selected-courses') || '[]');
        var initialDepartment = '{{ old("department", "") }}' || departmentSelect.value;

        function renderMessage(html) {
            coursesContainer.innerHTML = html;
        }

        function loadCoursesByDepartment(department, selected) {
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
                    displayCourses(data.courses, data.subFields, selected);
                } else {
                    renderMessage('<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> No courses found for this department.</div>');
                }
            })
            .catch(function (error) {
                console.error('Error loading courses:', error);
                renderMessage('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error loading courses. Please try again. Error: ' + error.message + '</div>');
            });
        }

        function displayCourses(courses, subFields, selected) {
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
                            var isChecked = selected && selected.includes(String(course.id)) ? 'checked' : '';
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
                    var isChecked = selected && selected.includes(String(course.id)) ? 'checked' : '';
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

        if (initialDepartment) {
            loadCoursesByDepartment(initialDepartment, selectedCourses);
        }

        departmentSelect.addEventListener('change', function () {
            var department = this.value;
            console.log('Department changed to:', department);
            if (department) {
                loadCoursesByDepartment(department, []);
            } else {
                renderMessage('<div class="alert alert-info"><i class="fas fa-info-circle"></i> Please select a department first to load available courses.</div>');
            }
        });
    });
</script>
@endpush
@endsection