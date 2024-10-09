@extends('layouts.master')

@section('main')

                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-xxl">
                            <div class="card mb-6">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Add School</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('school.create') }}" method="post">
                                        @csrf
                                        <div class="row mb-6">
                                            <!-- Name Field -->
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <label class="col-sm-2 col-form-label" for="name">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" />
                                                </div>
                                            </div>
                                            <!-- Address Field -->
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <label class="col-sm-2 col-form-label" for="address">Address</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="123 Main St" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-6">

                                            <!-- status Field -->
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="disable-selected">Select Status</option>
                                                        <option value="active">Active</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="blocked">Block</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row justify-content-end">
                                            <div class="col-sm-11">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

@endsection
