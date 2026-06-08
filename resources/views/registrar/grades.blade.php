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
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Health Academic</h5>
                    <p class="card-text">View grades for health-related academic departments.</p>
                    <a href="{{ route('registrar.grades', ['department' => 'Health Academic']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-cogs fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Engineering</h5>
                    <p class="card-text">Select a program to view engineering student grades.</p>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#engineeringModal">
                        <i class="fas fa-eye"></i> Choose Program
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-user-friends fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Social Science</h5>
                    <p class="card-text">View grades for social science students.</p>
                    <a href="{{ route('registrar.grades', ['department' => 'Social Science']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-flask fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Natural Science</h5>
                    <p class="card-text">View grades for natural science students.</p>
                    <a href="{{ route('registrar.grades', ['department' => 'Natural Science']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="engineeringModal" tabindex="-1" aria-labelledby="engineeringModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="engineeringModalLabel">Engineering Programs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Select the engineering field to view student grade data.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('registrar.grades', ['department' => 'Informatics']) }}" class="btn btn-outline-primary">
                            <i class="fas fa-laptop-code me-2"></i> Informatics
                        </a>
                        <a href="{{ route('registrar.grades', ['department' => 'Engineering Field']) }}" class="btn btn-outline-primary">
                            <i class="fas fa-industry me-2"></i> Engineering Field
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($department))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                Showing submitted grades for <strong>{{ $department }}</strong>.
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student Grades Overview</h3>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                            <i class="fas fa-download"></i> Export to Excel
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($gradesByDepartment->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No submitted grades found.
                        </div>
                    @else
                        @foreach($gradesByDepartment as $dept => $deptGrades)
                        <div class="department-section mb-4">
                            <h4 class="department-header bg-light p-3 rounded">
                                <i class="fas fa-building me-2"></i>
                                {{ $dept }} Department
                                <span class="badge bg-primary ms-2">{{ $deptGrades->count() }} grades</span>
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped excel-like">
                                    <thead class="excel-header">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>List No</th>
                                            <th>Course</th>
                                            <th>Grade</th>
                                            <th>Teacher</th>
                                            <th>Semester</th>
                                            <th>Academic Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deptGrades as $grade)
                                        <tr>
                                            <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                            <td>{{ $grade->student->list_no }}</td>
                                            <td>{{ $grade->course->course_name }} @if($grade->course->course_code)({{ $grade->course->course_code }})@endif</td>
                                            <td>{{ $grade->grade }}</td>
                                            <td>{{ $grade->teacher->first_name }} {{ $grade->teacher->last_name }}</td>
                                            <td>{{ $grade->semester }}</td>
                                            <td>{{ $grade->academic_year }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
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