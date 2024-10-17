@extends('layouts.master')

@section('main')

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-6">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Update Principal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('principal.update', $principal->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-6">
                            <!-- Name Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="name">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="{{ old('name', $principal->name) }}" />
                                </div>
                            </div>
                            <!-- Email Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="email">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="abc@example.com" value="{{ old('email', $principal->email) }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- Password Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="password">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if unchanged" />
                                </div>
                            </div>
                            <!-- Password Confirmation Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="password_confirmation">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave blank if unchanged" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- DOB -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="date_of_birth">DOB</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" id="date_of_birth" name="date_of_birth" placeholder="Select Date" value="{{ old('date_of_birth', $principal->date_of_birth) }}" />
                                </div>
                            </div>

                            <!-- Gender Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="gender">Gender</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="" disabled>Select Gender</option>
                                        <option value="male" {{ old('gender', $principal->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $principal->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="female" {{ old('gender', $principal->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <!-- Image Upload Field -->
                            <div class="col-sm-6 d-flex align-items-center">
                                <label class="col-sm-3 col-form-label" for="profile_pic">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" />
                                    @if ($principal->profile_pic)
                                        <small>Current Image: <a href="{{ asset('uploads/profile_pics/' . $principal->profile_pic) }}" target="_blank">View</a></small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-11">
                                <button type="submit" class="btn btn-primary">Update</button>
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

<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr for date of birth field
    flatpickr("#date_of_birth", {
        dateFormat: "Y-m-d", // Adjust format if needed
    });
</script>

@endsection
