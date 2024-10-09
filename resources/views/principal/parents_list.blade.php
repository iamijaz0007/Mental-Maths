@extends('layouts.master')

@section('main')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Parents of Students in Your School</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Parent Name</th>
                            <th>Email</th>
                            <th>Children (Students)</th>
{{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($parents as $parent)
                            <tr>
                                <td>{{ $parent->id }}</td>
                                <td>{{ $parent->name }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>
                                    @foreach ($parent->children as $child)
                                        <span>{{ $child->name }} ({{ $child->school->name }})</span><br>
                                    @endforeach
                                </td>
{{--                                <td>--}}
{{--                                    <!-- Button to send a report to the parent -->--}}
{{--                                    <a href="{{ route('parent.report', $parent->id) }}" class="btn btn-primary btn-sm">Send Report</a>--}}

{{--                                    <!-- Button to send a complaint to the parent -->--}}
{{--                                    <a href="{{ route('parent.complain', $parent->id) }}" class="btn btn-danger btn-sm">Send Complaint</a>--}}
{{--                                </td>--}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No parents found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $parents->links() }} <!-- Pagination Links -->
                </div>
            </div>
        </div>
    </div>
@endsection
