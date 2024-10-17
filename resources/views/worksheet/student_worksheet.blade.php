@extends('layouts.master')

@section('title', 'Student Worksheet')

@section('main')
    <div class="container my-5 d-flex justify-content-center">
        <div class="page-layout shadow-lg" style="width: 8.5in; padding: 1in; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-4">
                <h3 class="mb-1">{{ $worksheet->name }}</h3> <!-- Worksheet Name -->
                <h5 class="text-muted">Section: {{ $section->subject }}</h5> <!-- Section Name -->
            </div>

            <div class="card shadow-none border-0 mt-4">
                <div class="card-body">
                    @if(isset($questions) && count($questions) > 0)
                        <form action="{{ route('worksheet.submit_section', ['worksheet' => $worksheet->id, 'section' => $section->id]) }}" method="POST" id="worksheetForm">
                            @csrf
                            <input type="hidden" name="time_taken" id="time_taken" value="0">
                            <input type="hidden" name="action" id="action" value="submit">

                            <!-- Enhanced question design -->
                            @foreach ($questions as $question)
                                <div class="question-box mb-4 p-3 shadow-sm d-flex flex-column justify-content-center align-items-center text-center">
                                    <h5 class="question-number"><strong>Question {{ $loop->index + 1 }}</strong></h5>
                                    <p class="question-text">{{ $question->question_text }}</p>
                                    <div class="answer-box mt-3">
                                        <label for="answer-{{ $question->id }}" class="form-label">Your Answer:</label>
                                        <input type="number" id="answer-{{ $question->id }}" name="answers[{{ $question->id }}]" class="form-control answer-input" placeholder="Enter your answer" required step="any">
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end mt-4">
                                @if($remainingSections === 0)
                                    <button type="submit" class="btn btn-primary me-2" onclick="setAction('submit')">Submit Worksheet</button>
                                @else
                                    <button type="submit" class="btn btn-primary me-2" onclick="setAction('submit')">Submit Section</button>
                                    <button type="submit" class="btn btn-primary" onclick="setAction('next')">Next Section</button>
                                @endif
                            </div>
                        </form>

                        <div class="mt-4">
                            <p class="font-weight-bold"><strong>Time Spent on This Section: </strong><span id="display_time">0 seconds</span></p>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <strong>No questions available!</strong> The admin has not added any questions for this section. Please contact your instructor for further assistance.
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

        /* Timer display */
        #display_time {
            font-weight: bold;
            color: #555;
        }
    </style>

    <script>
        let startTime = new Date().getTime(); // Capture the starting time
        let timerInterval;

        function updateTimer() {
            let currentTime = new Date().getTime();
            let timeSpent = Math.floor((currentTime - startTime) / 1000); // Convert to seconds
            document.getElementById('display_time').textContent = timeSpent + " seconds"; // Display the time
        }

        timerInterval = setInterval(updateTimer, 1000);

        function stopTimer() {
            clearInterval(timerInterval); // Stop the interval
        }

        function setAction(actionType) {
            document.getElementById('action').value = actionType;
        }

        document.getElementById('worksheetForm').onsubmit = function(event) {
            let endTime = new Date().getTime();
            let timeTaken = (endTime - startTime) / 1000; // Convert to seconds
            document.getElementById('time_taken').value = timeTaken;

            let allAnswered = true;
            document.querySelectorAll('.answer-input').forEach(function(input) {
                if (input.value.trim() === "") {
                    allAnswered = false;
                }
            });

            if (!allAnswered) {
                alert("Please answer all the questions before submitting.");
                event.preventDefault(); // Prevent form submission if answers are missing
                return;
            }

            stopTimer(); // Stop the timer when the form is submitted
        };
    </script>
@endsection
