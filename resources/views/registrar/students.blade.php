@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @php
        $pageTitle = $groupLabel
            ?? (!empty($department) && empty($selectedCollege) ? $department : ($selectedCollege ?? $department));
        $pageTitle = $pageTitle ?: 'Registered Students';
    @endphp

    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-secondary">
                <h4 class="mb-1">{{ $pageTitle }}</h4>
                <p class="mb-0">Choose a college to view registered students by department.</p>
            </div>
        </div>
    </div>

    @if(empty($department) && empty($group))
    <div class="row g-3 mb-4">
        @foreach($collegeGroups as $college => $departments)
        <div class="col-md-3">
            <a href="{{ route('registrar.students', ['department' => $college]) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">{{ $college }}</h5>
                        <p class="card-text small text-muted">View registered students for departments under {{ $college }}.</p>
                        <span class="btn btn-outline-primary btn-sm">Open {{ $college }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

        <div class="col-md-3">
            <a href="{{ route('registrar.students', ['group' => 'freshman']) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Freshman Students</h5>
                        <p class="card-text small text-muted">{{ $freshmanStudents ?? 0 }} students in Year 1.</p>
                        <span class="btn btn-outline-success btn-sm">Open Freshman List</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('registrar.students', ['group' => 'remedial']) }}" class="text-decoration-none text-dark">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <i class="fas fa-user-shield fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Remedial Students</h5>
                        <p class="card-text small text-muted">{{ $remedialStudents ?? 0 }} students in higher-year support groups.</p>
                        <span class="btn btn-outline-warning btn-sm">Open Remedial List</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @elseif(!empty($group))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info mb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span>Showing only <strong>{{ $groupLabel }}</strong> in this view.</span>
                @if($group === 'freshman')
                    <a href="{{ route('registrar.register-student', ['group' => $group]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Fresh Registration
                    </a>
                @else
                    <a href="{{ route('registrar.register-student', ['group' => $group]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Rim Registration
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $groupLabel }}</h5>
                        <small class="text-muted">This list shows only the registered {{ $group === 'freshman' ? 'Freshman' : 'Remedial' }} students; no other department list is included here.</small>
                    </div>
                    <span class="badge bg-primary">{{ $students->total() }} student(s)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>List No</th>
                                    <th>Image</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->list_no }}</td>
                                    <td>
                                        @if($student->profile_image)
                                            <img src="{{ Storage::url($student->profile_image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $student->first_name ?? '' }}</td>
                                    <td>{{ $student->last_name ?? '' }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->department }}</td>
                                    <td>Year {{ $student->year }}</td>
                                    <td>
                                        <a href="{{ route('registrar.students.edit', $student->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('registrar.students.delete', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Archive this student?')"><i class="fas fa-archive"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No registered students found for this group.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info mb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span>Showing registered students for <strong>{{ $department }}</strong>.</span>
                <a href="{{ route('registrar.register-student') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Add New Student
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Departments in {{ $groupLabel ?? ($selectedCollege ?? $department) }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($filterDepartments as $dept)
                            <a class="list-group-item list-group-item-action {{ $dept === ($department ?? '') ? 'active' : '' }}" href="{{ route('registrar.students', array_filter(['department' => $dept, 'group' => $group])) }}">
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
                        <h5 class="mb-0">Students in {{ $groupLabel ?? $department }}</h5>
                        <small class="text-muted">Click a department on the left to refine the list.</small>
                    </div>
                    <span class="badge bg-primary">{{ $students->total() }} student(s)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>List No</th>
                                    <th>Image</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->list_no }}</td>
                                    <td>
                                        @if($student->profile_image)
                                            <img src="{{ Storage::url($student->profile_image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $student->first_name ?? '' }}</td>
                                    <td>{{ $student->last_name ?? '' }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->department }}</td>
                                    <td>Year {{ $student->year }}</td>
                                    <td>
                                        <a href="{{ route('registrar.students.edit', $student->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('registrar.students.delete', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Archive this student?')"><i class="fas fa-archive"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No registered students found for this department.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection