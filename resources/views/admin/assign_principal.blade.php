@extends('layouts.master')

@section('title', 'Assign Principal to School')

@section('main')

    <div class="container">
        <div class="card mt-5">
            <div class="card-header bg-label-primary text-center">
                <h3>Assign Principal to School</h3>
            </div>
            <div class="card-body mt-2">
                <!-- Display Success Message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.assignPrincipal') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <!-- Principal Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="principal" class="form-label">Select Principal</label>
                                <select name="principal_id" id="principal" class="form-control">
                                    <option value="" disabled selected>Select a principal</option>
                                    @foreach($principals as $principal)
                                        <option value="{{ $principal->id }}">{{ $principal->name }} - {{ $principal->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- School Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school" class="form-label">Select School</label>
                                <select name="school_id" id="school" class="form-control">
                                    <option value="" disabled selected>Select a school</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-md-12 text-start">
                            <button type="submit" class="btn btn-primary">Assign Principal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
