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
                        <a class="nav-link" href="{{ route('admin.teachers') }}">
                            <i class="fas fa-chalkboard-user"></i> Teachers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.grades') }}">
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
                <h1 class="h2">Grade Management</h1>
            </div>

            <!-- Grades Table -->
            <div class="card">
                <div class="card-body">
                    @if($grades->isEmpty())
                        <p class="text-muted">No grades found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Grade</th>
                                        <th>Semester</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                    <tr>
                                        <td>{{ $grade->student->first_name ?? 'N/A' }} {{ $grade->student->last_name ?? '' }}</td>
                                        <td>{{ $grade->course->course_name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $grade->grade >= 75 ? 'success' : 'danger' }}">
                                                {{ $grade->grade }}
                                            </span>
                                        </td>
                                        <td>{{ $grade->semester ?? 'N/A' }}</td>
                                        <td>{{ $grade->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.grades.edit', $grade->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.grades.delete', $grade->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this grade?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $grades->links() }}
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection