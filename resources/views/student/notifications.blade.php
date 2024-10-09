@extends('layouts.master')

@section('title', 'Notifications')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Notifications</h5>
            </div>

            <div class="card-body mt-2">
                @if($errorReports->isEmpty())
                    <p class="text-center">No notifications available.</p>
                @else
                    <div class="list-group">
                        @foreach($errorReports as $report)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1">Error Report for: {{ $report->worksheet->name }}</h6>
                                        <p class="mb-1">{{ $report->error_message }}</p>
                                        <small>Admin Response: {{ $report->admin_response }}</small>
                                    </div>
                                    <div>
                                        @if($report->status == 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @elseif($report->status == 'not_an_error')
                                            <span class="badge bg-danger">Not an Error</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
