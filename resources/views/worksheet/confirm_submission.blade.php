@extends('layouts.master')

@section('title', 'Confirm Submission')

@section('main')
    <div class="container my-4">
        <div class="alert alert-warning">
            <h5>You have not completed all sections of this worksheet.</h5>
            <p>Are you sure you want to submit it?</p>
            <a href="{{ route('worksheet.submit_worksheet', ['worksheet' => $worksheet->id]) }}" class="btn btn-danger">Submit Anyway</a>
            <a href="{{ route('worksheet.student_worksheet', ['worksheet' => $worksheet->id]) }}" class="btn btn-primary">Continue Worksheet</a>
        </div>
    </div>
@endsection
