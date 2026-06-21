@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Student Management</h4>
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Student
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(empty($department))
                        <div class="alert alert-info mb-4">
                            Choose a college dashboard card to view and manage students by department.
                        </div>

                        <div class="row g-3 mb-4">
                            @foreach($collegeGroups as $college => $collegeDepartments)
                                <div class="col-md-3">
                                    <a href="{{ route('admin.students', ['department' => $college]) }}" class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow-sm border-0 hover-card">
                                            <div class="card-body text-center">
                                                <i class="fas fa-university fa-3x text-primary mb-3"></i>
                                                <h5 class="card-title">{{ $college }}</h5>
                                                <p class="card-text small text-muted">{{ $collegeCounts[$college] ?? 0 }} student(s) across {{ count($collegeDepartments) }} department(s).</p>
                                                <span class="btn btn-outline-primary btn-sm">Open {{ $college }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <a href="{{ route('admin.students', ['department' => 'Freshman']) }}" class="text-decoration-none text-dark">
                                    <div class="card h-100 shadow-sm border-0 hover-card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-graduate fa-3x text-success mb-3"></i>
                                            <h5 class="card-title">Freshman</h5>
                                            <p class="card-text small text-muted">{{ $freshmanCount ?? 0 }} student(s) in this group.</p>
                                            <span class="btn btn-outline-success btn-sm">Open Freshman</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="{{ route('admin.students', ['department' => 'Remedial']) }}" class="text-decoration-none text-dark">
                                    <div class="card h-100 shadow-sm border-0 hover-card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-cog fa-3x text-warning mb-3"></i>
                                            <h5 class="card-title">Remedial</h5>
                                            <p class="card-text small text-muted">{{ $remedialCount ?? 0 }} student(s) in this group.</p>
                                            <span class="btn btn-outline-warning btn-sm">Open Remedial</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @elseif(!empty($selectedCollege) && $department === $selectedCollege)
                        <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span>Showing departments under <strong>{{ $selectedCollege }}</strong>.</span>
                            <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary btn-sm">Back to college cards</a>
                        </div>

                        <div class="mb-4">
                            <div class="small text-uppercase text-muted fw-semibold mb-2">Department quick access</div>
                            <div class="d-flex flex-wrap gap-2 overflow-auto pb-1">
                                @foreach($selectedCollegeDepartments as $dept)
                                    <a href="{{ route('admin.students', ['department' => $dept]) }}" class="btn btn-sm btn-outline-primary rounded-pill shadow-sm">
                                        {{ $dept }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @if($department === 'Freshman')
                            <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <span>Showing Freshman categories for <strong>{{ $selectedFreshmanCategory ?? 'Natural' }}</strong>.</span>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary btn-sm">Back to college cards</a>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-3">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Freshman Categories</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="list-group list-group-flush">
                                                @foreach($freshmanCategories as $label => $groupDepartments)
                                                    <a href="{{ route('admin.students', ['department' => 'Freshman', 'freshman_group' => $label]) }}"
                                                       class="list-group-item list-group-item-action {{ $selectedFreshmanCategory === $label ? 'active' : '' }}">
                                                        <i class="fas fa-folder-open me-2"></i>{{ $label }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Students in {{ $selectedFreshmanCategory }}</h5>
                                            <span class="badge bg-primary">{{ $students->total() }} student(s)</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>ID No.</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email</th>
                                                            <th>Grade/Year</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($students as $student)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $student->list_no ?? $student->id }}</td>
                                                                <td>{{ $student->first_name ?? 'N/A' }}</td>
                                                                <td>{{ $student->last_name ?? 'N/A' }}</td>
                                                                <td>{{ $student->email }}</td>
                                                                <td>{{ $student->year ?? 'N/A' }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-info">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </a>
                                                                    <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">
                                                                            <i class="fas fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center">No students found for this Freshman category.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{ $students->appends(['department' => 'Freshman', 'freshman_group' => $selectedFreshmanCategory])->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <span>Showing students for <strong>{{ $department }}</strong>.</span>
                                <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary btn-sm">Back to department cards</a>
                            </div>

                            @if(!empty($selectedCollegeDepartments))
                            <div class="mb-4">
                                <div class="small text-uppercase text-muted fw-semibold mb-2">Departments in {{ $selectedCollege }}</div>
                                <div class="d-flex flex-wrap gap-2 overflow-auto pb-1">
                                    @foreach($selectedCollegeDepartments as $dept)
                                        <a href="{{ route('admin.students', ['department' => $dept]) }}"
                                           class="btn btn-sm rounded-pill shadow-sm {{ $dept === $department ? 'btn-primary' : 'btn-outline-dark' }}">
                                            {{ $dept }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Departments</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach($departments as $dept)
                                                <a class="list-group-item list-group-item-action {{ $dept === $department ? 'active' : '' }}" href="{{ route('admin.students', ['department' => $dept]) }}">
                                                    {{ $dept }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID No.</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Grade/Year</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($students as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->list_no ?? $student->id }}</td>
                                                    <td>{{ $student->first_name ?? 'N/A' }}</td>
                                                    <td>{{ $student->last_name ?? 'N/A' }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->year ?? 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No students found for this department.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{ $students->links() }}
                            </div>
                        </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection