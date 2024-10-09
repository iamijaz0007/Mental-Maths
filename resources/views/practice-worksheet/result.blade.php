@extends('layouts.master')

@section('main')
    <div class="container my-5 d-flex justify-content-center">
        <div class="page-layout shadow-lg">
            <div class="text-center mb-4">
                <h3 class="mb-1">Practice Worksheet Results</h3>
                <p class="score"><strong>Score:</strong> {{ $score }} out of {{ count($results) }}</p>
            </div>

            <div class="card shadow-none border-0 mt-4">
                <div class="card-body">
                    @foreach($results as $index => $result)
                        <div class="question-box mb-4 p-3 shadow-sm">
                            <h5 class="question-number">Question {{ $index + 1 }}</h5>
                            <p class="question-text">{{ $result['question'] }}</p>
                            <p><strong>Your Answer:</strong> <span class="{{ $result['is_correct'] ? 'text-success' : 'text-danger' }}">{{ $result['submitted_answer'] }}</span></p>
                            <p><strong>Correct Answer:</strong> {{ $result['correct_answer'] }}</p>
                            <p>
                                <strong>Status:</strong>
                                @if($result['is_correct'])
                                    <span class="badge bg-success">Correct</span>
                                @else
                                    <span class="badge bg-danger">Incorrect</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('practice-worksheet.worksheet') }}" class="btn btn-primary btn-lg">Try Again</a>
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

        .score {
            font-size: 1.4rem;
            color: #333;
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

        .badge {
            font-size: 1rem;
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Centering the page layout */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-layout {
                padding: 20px;
            }

            .question-text {
                font-size: 1.4rem;
            }

            .score {
                font-size: 1.2rem;
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
