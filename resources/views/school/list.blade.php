@extends('layouts.master')

@section('main')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Schools</h5>
                    <a href="{{ route('school.add') }}" class="btn btn-primary">Add School</a>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($schools as $school)
                                <tr>
                                    <td>{{ $school->id }}</td>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->address }}</td>
                                    <td>
                                        <form action="{{ route('school.updateStatus', $school->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="form-select 
                                                @if ($school->status == 'active')
                                                    bg-success text-white
                                                @elseif($school->status == 'blocked')
                                                    bg-danger text-white
                                                @elseif($school->status == 'pending')
                                                    bg-warning text-dark
                                                @endif
                                            ">
                                                <option value="active" {{ $school->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="blocked" {{ $school->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                <option value="pending" {{ $school->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('school.edit', $school->id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('school.delete', $school->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $schools->links() }}
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>
@endsection
