@extends('layouts.master')

@section('main')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Principals without Schools -->
            <div class="card">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Principals</h5>
                    <div>
                        <a href="{{ route('admin.assignPrincipalForm') }}" class="btn btn-primary me-2">Assign Principal to School</a>
                        <a href="{{ route('principal.add') }}" class="btn btn-primary">Add Principal</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Principal Photo</th>
                                <th>Principal Name</th>
                                <th>Email</th>
                                <th>DOB</th>
                                <th>Principal Status</th>
                                <th>Actions</th> <!-- Added Actions column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($principalsWithoutSchools as $principal)
                                <tr>
                                    <td>
                                        @if($principal->profile_pic)
                                            <img src="{{ asset('uploads/profile_pics/' . $principal->profile_pic) }}" alt="Profile Picture" width="50" height="50">
                                        @else
                                            <img src="{{ asset('default-profile.png') }}" alt="Default Profile Picture" width="50" height="50">
                                        @endif
                                    </td>

                                    <td>{{ $principal->principal_name }}</td>
                                    <td>{{ $principal->email }}</td>
                                    <td>{{ $principal->date_of_birth }}</td>
                                    <td>
                                        <span class="badge
                                            @if ($principal->principal_status == 'active')
                                                bg-label-success
                                            @elseif($principal->principal_status == 'blocked')
                                                bg-label-danger
                                            @elseif($principal->principal_status == 'pending')
                                                bg-label-warning
                                            @else
                                                bg-primary
                                            @endif">
                                            {{ ucfirst($principal->principal_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('principal.edit', $principal->principal_id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('principal.delete', $principal->principal_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $principalsWithoutSchools->links() }} <!-- Pagination links -->
                </div>
            </div>

            <!-- Principals with Schools -->
            <div class="card mt-4">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Principals with Schools</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Principal Photo</th>
                                <th>Principal Name</th>
                                <th>Email</th>
                                <th>Principal Status</th>
                                <th>School Name</th>
                                <th>School Status</th>
                                <th>Actions</th> <!-- Added Actions column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($principalsWithSchools as $principal)
                                <tr>
                                    <td>
                                        @if($principal->profile_pic)
                                            <img src="{{ asset('uploads/profile_pics/' . $principal->profile_pic) }}" alt="Profile Picture" width="50" height="50">
                                        @else
                                            <img src="{{ asset('default-profile.png') }}" alt="Default Profile Picture" width="50" height="50">
                                        @endif
                                    </td>
                                    <td>{{ $principal->principal_name }}</td>
                                    <td>{{ $principal->email }}</td>
                                    <td>
                                        <span class="badge
                                            @if ($principal->principal_status == 'active')
                                                bg-label-success
                                            @elseif($principal->principal_status == 'blocked')
                                                bg-label-danger
                                            @elseif($principal->principal_status == 'pending')
                                                bg-label-warning
                                            @else
                                                bg-primary
                                            @endif">
                                            {{ ucfirst($principal->principal_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $principal->school_name }}</td>
                                    <td>
                                        <span class="badge
                                            @if ($principal->school_status == 'active')
                                                bg-label-success
                                            @elseif($principal->school_status == 'blocked')
                                                bg-label-danger
                                            @elseif($principal->school_status == 'pending')
                                                bg-label-warning
                                            @else
                                                bg-primary
                                            @endif">
                                            {{ ucfirst($principal->school_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                {{-- <a class="dropdown-item" href="{{ route('principal.edit', $principal->principal_id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a> --}}
                                                <form action="{{ route('principal.delete', $principal->principal_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $principalsWithSchools->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
@endsection
