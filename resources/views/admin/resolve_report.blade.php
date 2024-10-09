@extends('layouts.master')

@section('title', 'Resolve Error Report')

@section('main')
<div class="container mt-4">
    <h3>Resolve Error Report for {{ $report->worksheet->name }}</h3>

    <form action="{{ route('admin.submit_resolution', ['id' => $report->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="admin_response" class="form-label">Admin Response</label>
            <textarea name="admin_response" id="admin_response" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit Resolution</button>
    </form>
</div>
@endsection
