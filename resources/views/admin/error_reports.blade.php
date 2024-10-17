@extends('layouts.master')

@section('title', 'Error Reports')

@section('main')
    <div class="container mt-4">
        @include('layouts.message')
        <div class="card">
            <div class="card-header bg-label-primary text-white">
                <h5 class="card-title">Error Reports List</h5>
            </div>
            <div class="card-body mt-2">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Worksheet</th>
                        <th>Error Message</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($errorReports as $report)
                        <tr>
                            <!-- Handle cases where student or worksheet might be null -->
                            <td>{{ $report->student->name ?? 'N/A' }}</td>
                            <td>{{ $report->worksheet->name ?? 'N/A' }}</td>
                            <td>{{ $report->error_message }}</td>
                            <td>
                                @if($report->status === 'resolved' || $report->status === 'not_an_error')
                                    <button class="btn btn-secondary" disabled>Resolved</button>
                                    <button class="btn btn-secondary" disabled>Not an Error</button>
                                @else
                                    <a href="{{ route('admin.resolve_report', ['id' => $report->id]) }}" class="btn btn-primary">Resolve</a>
                                    <a href="{{ route('admin.not_an_error', ['id' => $report->id]) }}" class="btn btn-danger">Not an Error</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
