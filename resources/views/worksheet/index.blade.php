@extends('layouts.master')

@section('title', 'Admin - Worksheet List')

@section('main')
    <div class="container my-4">
        <div class="card">
            @include('layouts.message')
            <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Worksheets Created for Students</h5>
                <a href="{{ route('worksheet.create') }}" class="btn btn-primary">Create New Worksheet</a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Worksheet Name</th>
                            <th>Sections</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($worksheets as $worksheet)
                            <tr>
                                <td>{{ $worksheet->id }}</td>
                                <td>{{ $worksheet->name }}</td>
                                <td>
                                    @if($worksheet->sections->isNotEmpty())
                                        <div class="accordion" id="accordion{{ $worksheet->id }}">
                                            @foreach($worksheet->sections as $index => $section)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $worksheet->id }}{{ $index }}">
                                                        <button class="accordion-button{{ $index === 0 ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $worksheet->id }}{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $worksheet->id }}{{ $index }}">
                                                            {{ $section->subject }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $worksheet->id }}{{ $index }}" class="accordion-collapse collapse{{ $index === 0 ? ' show' : '' }}" aria-labelledby="heading{{ $worksheet->id }}{{ $index }}" data-bs-parent="#accordion{{ $worksheet->id }}">
                                                        <div class="accordion-body">
                                                            <!-- Add Questions Button -->
{{--                                                            <a href="{{ route('questions.create', $section->id) }}" class="btn btn-sm btn-info mb-3">+ Add Questions</a>--}}

                                                            <!-- List of Questions -->
                                                            @if($section->questions->isNotEmpty())
                                                                @foreach($section->questions as $question)
                                                                    <div class="card mb-3 shadow-sm">
                                                                        <div class="card-body">
                                                                            <h6 class="card-title">
                                                                                <strong>Q:</strong> {{ $question->question_text }}
                                                                            </h6>
                                                                            <p class="card-text mb-1">
                                                                                <strong>A:</strong> {{ $question->correct_answer }}
                                                                            </p>
                                                                            <p class="card-text mb-1">
                                                                                <strong>Difficulty:</strong>
                                                                                <span class="badge bg-label-{{ $question->difficulty == 'easy' ? 'success' : ($question->difficulty == 'medium' ? 'warning' : 'danger') }}">
                                                                                    {{ ucfirst($question->difficulty) }}
                                                                                </span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <p class="text-muted">No questions added to this section yet.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No sections added yet.</p>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('worksheet.show', $worksheet->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('worksheet.edit', $worksheet->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('worksheet.destroy', $worksheet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this worksheet?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No worksheets found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Bootstrap JS for accordion functionality --}}
    @section('scripts')
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @endsection
@endsection
