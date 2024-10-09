@extends('layouts.master')

@section('title', 'Student Progress')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Student Progress</h5>
            </div>
            <div class="card-body mt-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <a href="{{ route('principal.show-student-progress', ['studentId' => $student->id]) }}" class="btn btn-sm btn-info">View Progress</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
