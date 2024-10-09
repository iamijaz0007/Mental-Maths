@extends('layouts.master')

@section('main')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Table for Parents -->
            <div class="card">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Parents</h5>
                    @include('layouts.message')
                    <div>
                        <a href="{{ route('admin.assignChildForm') }}" class="btn btn-primary me-2">Assign Child to Parent</a>
                        <a href="{{ route('parent.add') }}" class="btn btn-primary">Add Parent</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Pic</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Occupation</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($parents as $parent)
                            <tr>
                                <td>{{ $parent->id }}</td>
                                <td>
                                    @if($parent->profile_pic)
                                        <img src="{{ asset('uploads/profile_pics/' . $parent->profile_pic) }}" alt="Profile Picture" width="50" height="50">
                                    @else
                                        <img src="{{ asset('default-profile.png') }}" alt="Default Profile Picture" width="50" height="50">
                                    @endif
                                </td>

                                <td>{{ $parent->name }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>{{ $parent->date_of_birth }}</td>
                                <td>{{ $parent->occupation }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('parent.edit', $parent->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('parent.delete', $parent->id) }}" method="POST" class="d-inline">
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
                    {{ $parents->links() }} <!-- Pagination links -->
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->

            <!-- Table for Parents with Assigned Children -->
            <div class="card">
                <div class="card-header bg-label-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Parents with Assigned Children</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Pic</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Children</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($parentsWithChildren as $parent)
                            <tr>
                                <td>{{ $parent->id }}</td>
                                <td>
                                    @if($parent->profile_pic)
                                        <img src="{{ asset('uploads/profile_pics/' . $parent->profile_pic) }}" alt="Profile Picture" width="50" height="50">
                                    @else
                                        <img src="{{ asset('default-profile.png') }}" alt="Default Profile Picture" width="50" height="50">
                                    @endif
                                </td>
                                <td>{{ $parent->name }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>
                                        <span class="badge
                                            @if ($parent->status == 'active')
                                                bg-label-success
                                            @elseif($parent->status == 'blocked')
                                                bg-label-danger
                                            @elseif($parent->status == 'pending')
                                                bg-label-warning
                                            @else
                                                bg-primary
                                            @endif">
                                            {{ ucfirst($parent->status) }}
                                        </span>
                                </td>
                                <td>
                                    @if ($parent->children->isNotEmpty())
                                        @foreach ($parent->children as $child)
                                            {{ $child->name }}@if (!$loop->last), @endif
                                        @endforeach
                                    @else
                                        No children assigned
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
{{--                                            <a class="dropdown-item" href="{{ route('parent.edit', $parent->id) }}">--}}
{{--                                                <i class="bx bx-edit-alt me-1"></i> Edit--}}
{{--                                            </a>--}}
                                            <form action="{{ route('parent.delete', $parent->id) }}" method="POST" class="d-inline">
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
                    {{ $parentsWithChildren->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
@endsection
