@extends('layouts.master')

@section('title', 'Report Error')

@section('main')
    <div class="container mt-4">
        @include('layouts.message')

        <h3 class="mb-4">{{ $worksheet->name }} - Error Report</h3>

        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h5 class="mb-0">Report Mistakes</h5>
            </div>
            <div class="card-body mt-3">
                <p>If you found any mistakes or errors in the worksheet, please let us know by submitting the form below:</p>

                <form action="{{ route('worksheet.submit_report', ['worksheet' => $worksheet->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="error_message" class="form-label"><strong>Describe the mistake(s) you found:</strong></label>
                        <textarea name="error_message" id="error_message" class="form-control" rows="5" required placeholder="Please provide detailed information about any mistakes or issues you found in the worksheet."></textarea>
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Submit Error Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
