@extends('layouts.master')

@section('main')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Students</h5>
                     @if (Auth::user()->role == 2) <!-- Ensure only role 2 sees the "Add Student" button -->
                    <a href="{{ route('student.add') }}" class="btn btn-primary">Add Student</a>
                    @endif
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>DOB</th>
                                <th>School Name</th> <!-- Added this column -->
                                @if (Auth::user()->role == 2)
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        @if($student->profile_pic)
                                            <img src="{{ asset('/uploads/profile_pics/' . $student->profile_pic) }}" alt="Profile Picture" width="50" height="50">
                                        @else
                                            <img src="{{ asset('default-profile.png') }}" alt="Default Profile Picture" width="50" height="50">
                                        @endif
                                    </td>

                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->date_of_birth }}</td>
                                    <td>{{ $student->school->name ?? 'No School Assigned' }}</td> <!-- Check if school exists -->
                                    @if (Auth::user()->role == 2)
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('student.edit', $student->id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('student.delete', $student->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
