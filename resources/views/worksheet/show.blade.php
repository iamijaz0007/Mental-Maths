@extends('layouts.master')

@section('title', 'Worksheet Details')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h1 class="mb-0">{{ $worksheet->name }}</h1>
            </div>
            <div class="card-body">
                <p>Status: <strong>{{ ucfirst($worksheet->status) }}</strong></p>

                <h2>Sections</h2>
                @foreach($worksheet->sections as $section)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $section->subject }}</h5>
                            <a href="{{ route('questions.create', $section->id) }}" class="btn btn-sm btn-info">Add Questions</a>
                        </div>
                        <div class="card-body">
                            @if($section->questions->isEmpty())
                                <p class="text-muted">No questions available for this section.</p>
                            @else
                                <ul class="list-unstyled">
                                    @foreach($section->questions as $question)
                                        <li class="mb-2">
                                            <strong>Q:</strong> {{ $question->question_text }}<br>
                                            <strong>A:</strong> {{ $question->correct_answer }}<br>
                                            <strong>Difficulty:</strong> {{ ucfirst($question->difficulty) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
