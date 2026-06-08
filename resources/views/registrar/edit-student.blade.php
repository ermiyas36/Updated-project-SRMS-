@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Student</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('registrar.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $student->email }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>New Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Department</label>
                                <select name="department" class="form-control" required>
                                    <option value="Computer Science" {{ $student->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="Engineering" {{ $student->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                    <option value="Business" {{ $student->department == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Mathematics" {{ $student->department == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Year</label>
                                <select name="year" class="form-control" required>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ $student->year == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Current Image</label>
                                @if($student->profile_image)
                                    <div>
                                        <img src="{{ Storage::url($student->profile_image) }}" style="width: 100px; height: 100px;" class="mb-2">
                                    </div>
                                @endif
                                <input type="file" name="profile_image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Student</button>
                        <a href="{{ route('registrar.students') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection