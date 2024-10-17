@extends('layouts.master')

@section('title', 'Add Sections to Worksheet')

@section('main')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h5 class="mb-0">Add Section to {{ $worksheet->name }}</h5>
            </div>
            <div class="card-body">
                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sections.store', $worksheet->id) }}" method="POST">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Section Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Section Name"  />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="difficulty_level" class="form-label">Difficulty Level:</label>
                            <select id="difficulty_level" name="difficulty_level" class="form-control" required>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Add Section</button>
                </form>
            </div>
        </div>
    </div>
@endsection
