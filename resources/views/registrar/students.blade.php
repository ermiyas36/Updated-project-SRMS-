@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Registered Students</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>List No</th>
                        <th>Image</th>
                        <th>Full Name</th>
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
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->department }}</td>
                        <td>Year {{ $student->year }}</td>
                        <td>
                            <a href="{{ route('registrar.students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('registrar.students.delete', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Archive this student?')">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No students registered.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $students->links() }}
    </div>
</div>
@endsection