@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>My Profile</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if($student->profile_image)
                        <img src="{{ Storage::url($student->profile_image) }}" style="width: 150px; height: 150px; border-radius: 50%;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" style="width: 150px; height: 150px; border-radius: 50%;">
                    @endif
                </div>
                
                <form action="{{ route('student.update-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>List Number</label>
                            <input type="text" value="{{ $student->list_no }}" class="form-control" readonly>
                        </div>
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
                            <label>Department</label>
                            <input type="text" value="{{ $student->department }}" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Year</label>
                            <input type="text" value="Year {{ $student->year }}" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Change Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-12 mb-3">
                            <hr>
                            <h6>Change Password (Optional)</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection