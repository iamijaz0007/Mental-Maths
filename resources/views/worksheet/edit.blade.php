@extends('layouts.master')

@section('title', 'Edit Worksheet')

@section('main')
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-label-primary text-white">
                <h1 class="h4">Create a New Worksheet</h1>
            </div>
            <div class="card-body mt-2">
                <form action="{{ route('worksheet.update', $worksheet->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6 mb-3">
                        <label for="name">Worksheet Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $worksheet->name }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
