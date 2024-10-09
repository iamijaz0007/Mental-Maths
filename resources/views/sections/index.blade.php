@extends('layouts.master')

@section('title', 'Sections List')

@section('main')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sections List</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Worksheet</th>
                        <th>Subject</th>
                        <th>Difficulty</th>
                        <th>Questions Count</th>
{{--                        <th>Actions</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->worksheet->name }}</td> <!-- Assuming the relation exists -->
                            <td>{{ $section->subject }}</td>
                            <td>{{ ucfirst($section->difficulty_level) }}</td>
                            <td>{{ $section->questions_count }}</td>
                            <td>
{{--                                <a href="{{ route('questions.create', $section->id) }}" class="btn btn-sm btn-info">Add Questions</a>--}}
{{--                                <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-warning">Edit</a>--}}
{{--                                <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline;">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this section?')">Delete</button>--}}
{{--                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
