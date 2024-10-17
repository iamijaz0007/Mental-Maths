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
                            <div class="col-sm-9">
                                <input value="{{ $section->subject }}" type="text" class="form-control" id="subject" name="subject" placeholder="Enter Section Name"  />
                            </div>
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

                    <button type="submit" class="btn btn-primary">Update Section</button>
                </form>
            </div>
        </div>
    </div>
@endsection
