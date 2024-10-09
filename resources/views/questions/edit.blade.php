@extends('layouts.master')

@section('title', 'Edit Question')

@section('main')
    <div class="container">
        <div class="card my-4">
            <div class="card-header">
                <h5>Edit Question</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('questions.update', $question->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty</label>
                        <select class="form-control" id="difficulty" name="difficulty" required>
                            <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="question_text" class="form-label">Question Text</label>
                        <input type="text" class="form-control" id="question_text" name="question_text" value="{{ $question->question_text }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <input type="text" class="form-control" id="correct_answer" name="correct_answer" value="{{ $question->correct_answer }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Question</button>
                </form>
            </div>
        </div>
    </div>
@endsection
