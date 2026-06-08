<div class="table-responsive">
    <!-- Search Results Message for AJAX -->
    @if(isset($searchMessage))
        <div class="alert alert-info mb-3">
            <i class="fas fa-search me-2"></i>{{ $searchMessage }}
            @if(isset($isSingleStudent) && $isSingleStudent)
                <span class="badge bg-success ms-2">Single Student Found</span>
            @endif
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>List No</th>
                <th>ID No</th>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Department</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>{{ $student->list_no }}</td>
                <td>{{ $student->id }}</td>
                <td>
                    @if($student->profile_image)
                        <img src="{{ Storage::url($student->profile_image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" style="width: 40px; height: 40px; border-radius: 50%;">
                    @endif
                </td>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->department }}</td>
                <td>Year {{ $student->year }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No students found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>