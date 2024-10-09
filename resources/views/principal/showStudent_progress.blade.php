@extends('layouts.master')

@section('title', $student->name . ' - Progress')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Progress for {{ $student->name }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Worksheet Name</th>
                            <th>Total Sections</th>
                            <th>Completed Sections</th>
                            <th>Remaining Sections</th>
                            <th>Correct Questions</th>
                            <th>Incorrect Questions</th>
                            <th>Total Time Spent (mins)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($worksheetProgress) > 0)
                            @foreach($worksheetProgress as $progress)
                                <tr>
                                    <td>{{ $progress['worksheet_name'] }}</td>
                                    <td>{{ $progress['totalSections'] }}</td>
                                    <td>{{ $progress['completedSections'] }}</td>
                                    <td>{{ $progress['remainingSections'] }}</td>
                                    <td>{{ $progress['correctQuestions'] }}</td>
                                    <td>{{ $progress['incorrectQuestions'] }}</td>
                                    <td>{{ round($progress['totalTimeSpent'] / 60, 2) }} mins</td>
                                    <td>
                                        <span class="bg-label-success {{ $progress['status'] == 'Completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $progress['status'] }}
                                        </span>
                                    </td>
                                </tr>

                                <!-- Nested table for section time spent -->
                                <tr>
                                    <td colspan="8">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                            <tr>
                                                <th>Section Name</th>
                                                <th>Time Spent (mins)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($progress['sections'] as $section)
                                                <tr>
                                                    <td>{{ $section['section_name'] }}</td>
                                                    <td>{{ round($section['time_spent'] / 60, 2) }} mins</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No worksheets completed for {{ $student->name }} yet.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
