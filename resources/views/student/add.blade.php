@extends('layouts.master')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@section('main')

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-6">
                @include('layouts.message')
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add Student</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-6">
                            <!-- Name Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="name">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"  />
                                </div>
                            </div>
                            <!-- Email Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="email">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="abc@example.com"  />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- Password Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="password">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="********"  />
                                </div>
                            </div>
                            <!-- Password Confirmation Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="password_confirmation">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********"  />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- Gender Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="gender">Gender</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="gender" name="gender" >
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Date of Birth Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="date_of_birth">DOB</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" id="date_of_birth" name="date_of_birth" placeholder="Select Date"  />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- Image Upload Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="profile_pic">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" />
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


@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for date of birth field
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d", // Adjust format if needed
    });
</script>

@endsection
