@extends('layouts.master')

@section('title', 'Add Question to Section')

@section('main')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h5 class="mb-0">Add Question to Section: {{ $section->subject }}</h5>
                @include('layouts.message')
            </div>
            <div class="card-body mt-3">
                <form action="{{ route('questions.store', ['worksheet' => $worksheet->id, 'section' => $section->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="difficulty" class="form-label">Difficulty</label>
                                <select name="difficulty" id="difficulty" class="form-control" required>
                                    <option value="">Select Difficulty</option>
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="question_text" class="form-label">Question</label>
                                <input type="text" name="question_text" id="question_text" class="form-control" placeholder="Enter question" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="correct_answer" class="form-label">Correct Answer</label>
                                <input type="text" name="correct_answer" id="correct_answer" class="form-control" placeholder="Enter correct answer" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Question</button>
                </form>
            </div>
        </div>
    </div>
@endsection
