@extends('layouts.master')

@section('title', 'Worksheet Details')

@section('main')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h2 class="mb-0">{{ $worksheet->name }}</h2>
            </div>
            <div class="card-body mt-2">
                @include('layouts.message')
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4">Sections</h2>
                    <a href="{{ route('sections.create', $worksheet->id) }}" class="btn btn-primary btn-sm">+ Add Section</a>
                </div>

                @if($worksheet->sections->isEmpty())
                    <div class="alert alert-warning text-center" role="alert">
                        No sections added yet. <a href="{{ route('sections.create', $worksheet->id) }}" class="alert-link">Add a new section</a> to get started.
                    </div>
                @else
                    <div class="accordion" id="accordionSections">
                        @foreach($worksheet->sections as $section)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="heading-{{ $section->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $section->id }}" aria-expanded="false" aria-controls="collapse-{{ $section->id }}">
                                        <strong>{{ $section->subject }}</strong>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $section->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $section->id }}" data-bs-parent="#accordionSections">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Questions</h5>
                                            <a href="{{ route('questions.create', $section->id) }}" class="btn btn-info btn-sm">+ Add Questions</a>
                                        </div>

                                        @if($section->questions->isEmpty())
                                            <div class="alert alert-info text-center" role="alert">
                                                No questions available for this section. <a href="{{ route('questions.create', $section->id) }}" class="alert-link">Add a question</a> to this section.
                                            </div>
                                        @else
                                            <ul class="list-group">
                                                @foreach($section->questions as $question)
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <strong>Q:</strong> {{ $question->question_text }}<br>
                                                                <strong>A:</strong> {{ $question->correct_answer }}<br>
                                                                <strong>Difficulty:</strong> <span class="badge bg-label-{{ $question->difficulty == 'easy' ? 'success' : ($question->difficulty == 'medium' ? 'warning' : 'danger') }}">{{ ucfirst($question->difficulty) }}</span>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                                                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <!-- Section Edit and Delete buttons -->
                                        <div class="mt-3">
                                            <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-outline-warning">Edit Section</a>
                                            <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this section?')">Delete Section</button>
                                            </form>
                                        </div>

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
