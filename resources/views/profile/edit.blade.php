@extends('layouts.master')

@section('main')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-6">
                        <div class="card-body">
                            <h4 class="mb-4">Edit Profile</h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @include('layouts.message')

                            <!-- Profile Picture -->
                            <div class="d-flex align-items-start gap-6 pb-4 border-bottom">
                                <img
                                    src="{{ $user->profile_pic ? asset('/uploads/profile_pics/' . $user->profile_pic) : asset('default-profile.png') }}"
                                    alt="Profile Picture"
                                    class="d-block w-px-100 h-px-100 rounded"
                                    id="uploadedAvatar" />

                                <div class="button-wrapper">
                                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input" name="profile_pic" hidden accept="image/png, image/jpeg" />
                                        </label>

                                        <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>

                            <!-- Profile Update Form -->
                            <div class="card-body pt-4">
                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="password">New Password (Optional)</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Enter new password">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary me-3">Save changes</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
