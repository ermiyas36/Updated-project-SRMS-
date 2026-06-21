@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-secondary">
                <h4 class="mb-1">Department Grade Dashboard</h4>
                <p class="mb-0">Choose a category to view submitted student grade data for that department.</p>
            </div>
        </div>
    </div>
    @php
        $collegeGroups = [
            'Health Academic' => ['Health Academic', 'Nursing', 'Medicine', 'Public Health'],
            'Engineering' => ['Software Engineering', 'Computer Science', 'Information Technology', 'Information Systems', 'Engineering Field', 'Electrical Engineering', 'Mechanical Engineering', 'Civil Engineering'],
            'Social Science' => ['Social Science', 'Psychology', 'Sociology', 'Political Science', 'Economics'],
            'Natural Science' => ['Natural Science', 'Biology', 'Chemistry', 'Physics', 'Environmental Science'],
            'Business & Management' => ['Business', 'Accounting', 'Finance', 'Marketing', 'Management'],
            'Arts & Humanities' => ['Literature', 'History', 'Philosophy', 'Fine Arts', 'Languages'],
            'Mathematics & Statistics' => ['Mathematics', 'Statistics', 'Applied Mathematics'],
            'Other' => ['Law', 'Education', 'Agriculture', 'Other'],
        ];
    @endphp

    @if(empty($department))
    <div class="row g-3 mb-4">
        @foreach($collegeGroups as $college => $departments)
        <div class="col-md-3">
            <a href="{{ route('registrar.grades', ['department' => $college]) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">{{ $college }}</h5>
                        <p class="card-text small text-muted">View submitted grades for all departments under {{ $college }}.</p>
                        <span class="btn btn-outline-primary btn-sm">Open College</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

        <div class="col-md-3">
            <a href="{{ route('registrar.grades', ['department' => 'Freshman']) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Freshman</h5>
                        <p class="card-text small text-muted">View grade records for Year 1 students.</p>
                        <span class="btn btn-outline-success btn-sm">Open Freshman</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('registrar.grades', ['department' => 'Remedial']) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-user-shield fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Remedial</h5>
                        <p class="card-text small text-muted">View grade records for remedial and support-year students.</p>
                        <span class="btn btn-outline-warning btn-sm">Open Remedial</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if(!empty($department))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info mb-0">
                Showing submitted grades for <strong>{{ $department }}</strong> college.
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Departments in {{ $department }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($collegeGroups[$department] ?? [] as $dept)
                            <a class="list-group-item list-group-item-action {{ $dept === ($department ?? '') ? 'active' : '' }}" href="{{ route('registrar.grades', ['department' => $dept]) }}">
                                {{ $dept }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Submitted student results for the selected department.</small>
                    </div>
                    <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export to Excel
                    </button>
                </div>
                <div class="card-body">
                    @if($gradesByDepartment->isEmpty())
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> No submitted grades found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="gradesTable" class="table table-bordered table-striped excel-like mb-0">
                                <thead class="excel-header">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>List No</th>
                                        <th>Department</th>
                                        <th>Course</th>
                                        <th>Grade</th>
                                        <th>Teacher</th>
                                        <th>Semester</th>
                                        <th>Academic Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gradesByDepartment as $dept => $deptGrades)
                                        @foreach($deptGrades as $grade)
                                        <tr>
                                            <td>{{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}</td>
                                            <td>{{ $grade->student->list_no }}</td>
                                            <td>{{ $grade->student->department }}</td>
                                            <td>{{ $grade->course->course_name }} @if($grade->course->course_code)({{ $grade->course->course_code }})@endif</td>
                                            <td>{{ $grade->grade }}</td>
                                            <td>{{ $grade->teacher->first_name }} {{ $grade->teacher->last_name }}</td>
                                            <td>{{ $grade->semester }}</td>
                                            <td>{{ $grade->academic_year }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="card-title mb-0">Choose a College</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">Select a college card above to view its departments and submitted student grades.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.excel-like {
    border-collapse: collapse;
    font-family: 'Calibri', sans-serif;
    font-size: 14px;
}

.excel-like th, .excel-like td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.excel-header th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
}

.excel-like tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.excel-like tbody tr:hover {
    background-color: #e6f3ff;
}

.department-section {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    overflow: hidden;
}

.department-header {
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 0;
    color: #495057;
    font-weight: 600;
}

.department-header .badge {
    font-size: 0.875em;
}
</style>

<script>
function exportToExcel() {
    // Export all department tables to Excel
    let csv = [];
    let departmentSections = document.querySelectorAll('.department-section');

    if (departmentSections.length === 0) {
        alert('No grades to export.');
        return;
    }

    // Add header
    csv.push('"Department","Student Name","List No","Course","Grade","Teacher","Semester","Academic Year"');

    // Process each department section
    departmentSections.forEach(section => {
        let deptName = section.querySelector('.department-header').innerText.split(' Department')[0];
        let table = section.querySelector('table');
        let rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let cols = row.querySelectorAll('td');
            let rowData = [
                '"' + deptName + '"',
                '"' + cols[0].innerText + '"',
                '"' + cols[1].innerText + '"',
                '"' + cols[2].innerText + '"',
                '"' + cols[3].innerText + '"',
                '"' + cols[4].innerText + '"',
                '"' + cols[5].innerText + '"',
                '"' + cols[6].innerText + '"'
            ];
            csv.push(rowData.join(','));
        });
    });

    let csvContent = csv.join('\n');
    let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'student_grades.csv';
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function sortTable(n) {
    const table = document.getElementById('gradesTable');
    let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    switching = true;
    dir = "asc";
    
    while (switching) {
        switching = false;
        rows = table.rows;
        
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

// Make headers clickable for sorting
document.addEventListener('DOMContentLoaded', function() {
    const headers = document.querySelectorAll('#gradesTable th');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTable(index);
        });
    });
});
</script>
@endsection