@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Student Records</h5>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <form id="searchForm" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by name or list number..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="year" id="year" class="form-control">
                        <option value="">All Years</option>
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('teacher.students') }}" class="btn btn-secondary">Show All</a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Search Results Message -->
        @if(isset($searchMessage))
            <div class="alert alert-info mb-3">
                <i class="fas fa-search me-2"></i>{{ $searchMessage }}
                @if(isset($isSingleStudent) && $isSingleStudent)
                    <span class="badge bg-success ms-2">Single Student Found</span>
                @endif
            </div>
        @endif

        <!-- Students Table -->
        <div id="studentsTable">
            @include('teacher.partials.student_table')
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('teacher.students.search') }}",
                type: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    $('#studentsTable').html(response);
                }
            });
        });
    });
</script>
@endpush
@endsection