@extends('layouts.master')

@section('title', 'Edit Section')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h5>Edit Section</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sections.update', $section->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Section Name -->
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Section Name:</label>
                            <select id="subject" name="subject" class="form-control" required>
                                <option value="">Select Section Name</option>
                                <option value="Addition" {{ $section->subject == 'Addition' ? 'selected' : '' }}>Addition</option>
                                <option value="Subtraction" {{ $section->subject == 'Subtraction' ? 'selected' : '' }}>Subtraction</option>
                                <option value="Multiplication" {{ $section->subject == 'Multiplication' ? 'selected' : '' }}>Multiplication</option>
                                <option value="Division" {{ $section->subject == 'Division' ? 'selected' : '' }}>Division</option>
                            </select>
                        </div>

                        <!-- Difficulty Level -->
                        <div class="col-md-6 mb-3">
                            <label for="difficulty_level" class="form-label">Difficulty Level:</label>
                            <select id="difficulty_level" name="difficulty_level" class="form-control" required>
                                <option value="1" {{ $section->difficulty_level == 1 ? 'selected' : '' }}>Easy</option>
                                <option value="2" {{ $section->difficulty_level == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ $section->difficulty_level == 3 ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">Update Section</button>
                </form>
            </div>
        </div>
    </div>
@endsection
