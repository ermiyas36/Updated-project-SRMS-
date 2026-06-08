@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Edit Student</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
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
                                <option value="">Select Department</option>
                                <optgroup label="Health Academic">
                                    <option value="Health Academic" {{ $student->department == 'Health Academic' ? 'selected' : '' }}>Health Academic</option>
                                    <option value="Nursing" {{ $student->department == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                                    <option value="Medicine" {{ $student->department == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                                    <option value="Public Health" {{ $student->department == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                                </optgroup>
                                <optgroup label="Engineering">
                                    <option value="Informatics" {{ $student->department == 'Informatics' ? 'selected' : '' }}>Informatics</option>
                                    <option value="Engineering Field" {{ $student->department == 'Engineering Field' ? 'selected' : '' }}>Engineering Field</option>
                                    <option value="Computer Science" {{ $student->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="Electrical Engineering" {{ $student->department == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                                    <option value="Mechanical Engineering" {{ $student->department == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                                    <option value="Civil Engineering" {{ $student->department == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                                </optgroup>
                                <optgroup label="Social Science">
                                    <option value="Social Science" {{ $student->department == 'Social Science' ? 'selected' : '' }}>Social Science</option>
                                    <option value="Psychology" {{ $student->department == 'Psychology' ? 'selected' : '' }}>Psychology</option>
                                    <option value="Sociology" {{ $student->department == 'Sociology' ? 'selected' : '' }}>Sociology</option>
                                    <option value="Political Science" {{ $student->department == 'Political Science' ? 'selected' : '' }}>Political Science</option>
                                    <option value="Economics" {{ $student->department == 'Economics' ? 'selected' : '' }}>Economics</option>
                                </optgroup>
                                <optgroup label="Natural Science">
                                    <option value="Natural Science" {{ $student->department == 'Natural Science' ? 'selected' : '' }}>Natural Science</option>
                                    <option value="Biology" {{ $student->department == 'Biology' ? 'selected' : '' }}>Biology</option>
                                    <option value="Chemistry" {{ $student->department == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
                                    <option value="Physics" {{ $student->department == 'Physics' ? 'selected' : '' }}>Physics</option>
                                    <option value="Environmental Science" {{ $student->department == 'Environmental Science' ? 'selected' : '' }}>Environmental Science</option>
                                </optgroup>
                                <optgroup label="Business & Management">
                                    <option value="Business" {{ $student->department == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Accounting" {{ $student->department == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                                    <option value="Finance" {{ $student->department == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Marketing" {{ $student->department == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Management" {{ $student->department == 'Management' ? 'selected' : '' }}>Management</option>
                                </optgroup>
                                <optgroup label="Arts & Humanities">
                                    <option value="Literature" {{ $student->department == 'Literature' ? 'selected' : '' }}>Literature</option>
                                    <option value="History" {{ $student->department == 'History' ? 'selected' : '' }}>History</option>
                                    <option value="Philosophy" {{ $student->department == 'Philosophy' ? 'selected' : '' }}>Philosophy</option>
                                    <option value="Fine Arts" {{ $student->department == 'Fine Arts' ? 'selected' : '' }}>Fine Arts</option>
                                    <option value="Languages" {{ $student->department == 'Languages' ? 'selected' : '' }}>Languages</option>
                                </optgroup>
                                <optgroup label="Mathematics & Statistics">
                                    <option value="Mathematics" {{ $student->department == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                                    <option value="Statistics" {{ $student->department == 'Statistics' ? 'selected' : '' }}>Statistics</option>
                                    <option value="Applied Mathematics" {{ $student->department == 'Applied Mathematics' ? 'selected' : '' }}>Applied Mathematics</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="Law" {{ $student->department == 'Law' ? 'selected' : '' }}>Law</option>
                                    <option value="Education" {{ $student->department == 'Education' ? 'selected' : '' }}>Education</option>
                                    <option value="Agriculture" {{ $student->department == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                    <option value="Other" {{ $student->department == 'Other' ? 'selected' : '' }}>Other</option>
                                </optgroup>
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
                    <a href="{{ route('admin.students') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection