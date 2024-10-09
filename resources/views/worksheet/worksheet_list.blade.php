@extends('layouts.master')

@section('title', 'Student Worksheet Progress')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Student Worksheet Progress</h5>
            </div>
            @include('layouts.message')
            <div class="card-body">
                @if(Auth::user()->role === 1 || Auth::user()->role === 3)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Worksheet Name</th>
                                <th>Total Sections</th>
                                <th>Completed Sections</th>
                                <th>Remaining Sections</th>
                                <th>Status</th>
                                <th>Error Report</th> <!-- New column for Error Report status -->
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($worksheets as $index => $worksheet)
                                <tr>
                                    <td>{{ $worksheet->id }}</td>
                                    <td>{{ $worksheet->name }}</td>
                                    <td>{{ $worksheetProgress[$worksheet->id]['totalSections'] }}</td>
                                    <td>{{ $worksheetProgress[$worksheet->id]['completedSections'] }}</td>
                                    <td>{{ $worksheetProgress[$worksheet->id]['remainingSections'] }}</td>
                                    <td>
                                        @php
                                            // Check if the worksheet has any sections and questions
                                            $hasSections = $worksheetProgress[$worksheet->id]['totalSections'] > 0;
                                            $hasQuestions = $worksheet->sections->sum(function ($section) {
                                                return $section->questions->count();
                                            }) > 0;
                                        @endphp

                                        @if($worksheet->is_completed && $hasSections && $hasQuestions)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif(!$hasSections || !$hasQuestions)
                                            <span class="badge bg-danger">No Sections/Questions</span>
                                        @elseif($index == 0 || $worksheets[$index - 1]->is_completed)
                                            <span class="badge bg-warning">In Progress</span>
                                        @else
                                            <span class="badge bg-secondary">Locked</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Display error report status if any -->
                                        @php
                                            $errorReport = $worksheet->errorReports->where('user_id', Auth::id())->first();
                                        @endphp

                                        @if($errorReport)
                                            @if($errorReport->status == 'resolved')
                                                <span class="badge bg-success">Resolved</span>
                                                <p>Admin Response: {{ $errorReport->admin_response }}</p>
                                            @elseif($errorReport->status == 'not_an_error')
                                                <span class="badge bg-danger">Not an Error</span>
                                                <p>Admin Response: {{ $errorReport->admin_response }}</p>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">No Error Report</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($worksheet->is_completed && $hasSections && $hasQuestions)
                                            <button class="btn btn-secondary btn-sm" disabled>Worksheet Completed</button>
                                        @elseif(!$hasSections || !$hasQuestions)
                                            <button class="btn btn-secondary btn-sm" disabled>Incomplete</button>
                                        @elseif($index == 0 || $worksheets[$index - 1]->is_completed)
                                            <a href="{{ route('worksheet.student_worksheet', ['worksheet' => $worksheet->id]) }}" class="btn btn-primary btn-sm">Start / Continue</a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Locked</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No worksheets found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>You do not have permission to view this page.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
