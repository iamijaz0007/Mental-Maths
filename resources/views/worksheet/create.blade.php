@extends('layouts.master')

@section('title', 'Worksheets')

@section('main')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-label-primary text-white">
                <h1 class="h4">Create a New Worksheet</h1>
            </div>
            <div class="card-body mt-3">
                @include('layouts.message')

                <form action="{{ route('worksheet.store') }}" method="POST">
                    @csrf

                    <div class="col-sm-6 d-flex align-items-center mb-3">
                        <label class="col-sm-3 col-form-label" for="name">Worksheet Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Worksheet Name"  />
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-11">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
