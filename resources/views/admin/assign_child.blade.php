@extends('layouts.master')

@section('title', 'Assign Child to Parent')

@section('main')

    <div class="container">
        <div class="card mt-5">
            <div class="card-header bg-label-primary">
                <h3 class="mb-0">Assign Child to Parent</h3>
            </div>
            <div class="card-body mt-2">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.assignChild') }}" method="POST">
                    @csrf

                    <!-- Parent Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="parent" class="form-label">Select Parent</label>
                            <select name="parent_id" id="parent" class="form-control">
                                <option value="" disabled selected>Select a Parent</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Children Selection -->
                        <div class="col-md-6">
                            <label for="child" class="form-label">Select Children</label>
                            <select name="child_ids[]" id="child" class="form-control" multiple>
                                <option value="" disabled>Select Children</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('child_ids')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-md-12 text-start">
                            <button type="submit" class="btn btn-primary mt-3">Assign Child</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
