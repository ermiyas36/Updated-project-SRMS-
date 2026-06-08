@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Add New Student</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <small class="form-text text-muted d-block mt-1">
                                <strong>Requirements:</strong> 8+ chars, Uppercase, Lowercase, Number
                            </small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Department</label>
                            <select name="department" class="form-control @error('department') is-invalid @enderror" required>
                                <option value="">Select Department</option>
                                <optgroup label="Health Academic">
                                    <option value="Health Academic">Health Academic</option>
                                    <option value="Nursing">Nursing</option>
                                    <option value="Medicine">Medicine</option>
                                    <option value="Public Health">Public Health</option>
                                </optgroup>
                                <optgroup label="Engineering">
                                    <option value="Informatics">Informatics</option>
                                    <option value="Engineering Field">Engineering Field</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Electrical Engineering">Electrical Engineering</option>
                                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                                    <option value="Civil Engineering">Civil Engineering</option>
                                </optgroup>
                                <optgroup label="Social Science">
                                    <option value="Social Science">Social Science</option>
                                    <option value="Psychology">Psychology</option>
                                    <option value="Sociology">Sociology</option>
                                    <option value="Political Science">Political Science</option>
                                    <option value="Economics">Economics</option>
                                </optgroup>
                                <optgroup label="Natural Science">
                                    <option value="Natural Science">Natural Science</option>
                                    <option value="Biology">Biology</option>
                                    <option value="Chemistry">Chemistry</option>
                                    <option value="Physics">Physics</option>
                                    <option value="Environmental Science">Environmental Science</option>
                                </optgroup>
                                <optgroup label="Business & Management">
                                    <option value="Business">Business</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Management">Management</option>
                                </optgroup>
                                <optgroup label="Arts & Humanities">
                                    <option value="Literature">Literature</option>
                                    <option value="History">History</option>
                                    <option value="Philosophy">Philosophy</option>
                                    <option value="Fine Arts">Fine Arts</option>
                                    <option value="Languages">Languages</option>
                                </optgroup>
                                <optgroup label="Mathematics & Statistics">
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="Statistics">Statistics</option>
                                    <option value="Applied Mathematics">Applied Mathematics</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="Law">Law</option>
                                    <option value="Education">Education</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Other">Other</option>
                                </optgroup>
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Year</label>
                            <select name="year" class="form-control @error('year') is-invalid @enderror" required>
                                <option value="">Select Year</option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                                <option value="5">Year 5</option>
                            </select>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Profile Image</label>
                            <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Student</button>
                    <a href="{{ route('admin.students') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection