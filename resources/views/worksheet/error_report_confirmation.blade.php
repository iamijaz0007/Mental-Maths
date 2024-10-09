@extends('layouts.master')

@section('title', 'Error Report Confirmation')

@section('main')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h5 class="mb-0">{{ $worksheet->name }} - Error Report Confirmation</h5>
            </div>
            <div class="card-body mt-3">
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill"/>
                        </svg>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <h5 class="mb-4">You have completed the worksheet! Would you like to report any mistakes or errors that you found?</h5>

                <div class="d-flex justify-content-start">
                    <a href="{{ route('worksheet.report', ['worksheet' => $worksheet->id]) }}" class="btn btn-primary me-3">Yes, Report Error</a>
                    <a href="{{ route('worksheet.worksheet_list') }}" class="btn btn-secondary">No, Go Back to Worksheet List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
