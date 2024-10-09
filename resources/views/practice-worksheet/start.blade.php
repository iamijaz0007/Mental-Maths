@extends('layouts.master')

@section('main')
    <div class="container my-5 d-flex justify-content-center">
        <div class="page-layout shadow-lg">
            <div class="text-center mb-4">
                <h3 class="mb-1">Practice Worksheet</h3>
            </div>

            <div class="card shadow-none border-0 mt-4">
                <div class="card-body">
                    <form action="{{ route('practice.worksheet.submit') }}" method="POST" id="practiceWorksheetForm">
                        @csrf

                        @foreach($questions as $index => $question)
                            <div class="question-box mb-4 p-3 shadow-sm text-center">
                                <h5 class="question-number">Question {{ $loop->index + 1 }}</h5>
                                <p class="question-text">{{ $question['question'] }}</p>

                                <!-- Question input with wider, centered alignment -->
                                <div class="input-container">
                                    <input type="number" name="answers[{{ $index }}]" class="form-control answer-input" placeholder="Enter your answer" required>
                                    <input type="hidden" name="correct_answers[{{ $index }}]" value="{{ $question['correct_answer'] }}">
                                    <input type="hidden" name="questions[{{ $index }}]" value="{{ $question['question'] }}">
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-layout {
            width: 100%;
            max-width: 900px;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .question-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .question-number {
            font-size: 1.2rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .question-text {
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 15px;
        }

        .input-container {
            text-align: center;
        }

        .form-control {
            font-size: 16px;
            padding: 12px;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .btn {
            padding: 10px 30px;
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-layout {
                padding: 20px;
            }

            .question-text {
                font-size: 1.4rem;
            }

            .form-control {
                font-size: 14px;
            }

            .btn {
                font-size: 16px;
            }
        }
    </style>
@endsection
