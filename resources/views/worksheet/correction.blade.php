@extends('layouts.master')

@section('title', 'Correct Incorrect Answers')

@section('main')
    <div class="container my-5 d-flex justify-content-center">
        <div class="page-layout shadow-lg" style="width: 8.5in; padding: 1in; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-4">
                <h3 class="mb-1">{{ $worksheet->name }}</h3> <!-- Worksheet Name -->
                <h5 class="text-muted">Correction Section</h5> <!-- Correction Section Title -->
            </div>

            <div class="card shadow-none border-0 mt-4">
                <div class="card-body">
                    @if(isset($incorrectAnswers) && count($incorrectAnswers) > 0)
                        <form action="{{ route('worksheet.submit_correction', ['worksheet' => $worksheet->id]) }}" method="POST" id="correctionForm">
                            @csrf

                            <!-- Enhanced question design for corrections -->
                            @foreach ($incorrectAnswers as $answer)
                                <div class="question-box mb-4 p-3 shadow-sm d-flex flex-column justify-content-center align-items-center text-center">
                                    <h5 class="question-number"><strong>Question {{ $loop->index + 1 }}</strong></h5>
                                    <p class="question-text">{{ $answer->question->question_text }}</p>
                                    <p class="text-success"><strong>Correct Answer:</strong> {{ $answer->question->correct_answer }}</p>
                                    <div class="answer-box mt-3">
                                        <label for="answer-{{ $answer->question_id }}" class="form-label">Your Correction:</label>
                                        <input type="number" id="answer-{{ $answer->question_id }}" name="answers[{{ $answer->question_id }}]" class="form-control answer-input" value="{{ $answer->student_answer }}" required step="any">
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">Submit Corrections</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <strong>No incorrect answers to correct!</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* MS Word-like page layout */
        .page-layout {
            width: 8.5in;
            padding: 1in;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow for page effect */
            border: 1px solid #ddd;
        }

        /* Question box styling */
        .question-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .question-number {
            font-size: 1.2rem;
            color: #007bff;
        }

        .question-text {
            font-size: 1.6rem;
            margin-top: 0.5rem;
            color: #333;
        }

        .answer-box {
            margin-top: 1rem;
        }

        /* Styling input fields */
        .form-control {
            font-size: 14px;
            padding: 10px;
            max-width: 250px; /* Slightly larger answer field */
        }

        /* Action buttons layout */
        .d-flex {
            gap: 1rem;
        }

        /* Centering the page layout */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <script>
        document.getElementById('correctionForm').onsubmit = function(event) {
            let allAnswered = true;
            document.querySelectorAll('.answer-input').forEach(function(input) {
                if (input.value.trim() === "") {
                    allAnswered = false;
                }
            });

            if (!allAnswered) {
                alert("Please correct all the questions before submitting.");
                event.preventDefault(); // Prevent form submission if answers are missing
                return;
            }
        };
    </script>
@endsection
