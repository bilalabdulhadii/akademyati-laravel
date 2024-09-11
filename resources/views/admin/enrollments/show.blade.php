@extends('layouts.admin')

@section('title', 'Enrollment Details')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Enrollment Details</h4>
                                    @if($enrollment->status === 'active')
                                        <form action="{{ route('admin.enrollments.suspend') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">
                                            <button class="btn btn-outline-danger"><i class="fas fa-ban me-2"></i>Suspend</button>
                                        </form>
                                    @elseif($enrollment->status === 'suspended')
                                        <form action="{{ route('admin.enrollments.reactivate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">
                                            <button class="btn btn-outline-success"><i class="fas fa-check me-2"></i>Reactivate</button>
                                        </form>
                                    @endif

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="w-25">ID</th>
                                                    <td>{{ $enrollment->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Status</th>
                                                    <td>{{ ucfirst($enrollment->status) }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Student</th>
                                                    <td>{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Course</th>
                                                    <td>{{ $enrollment->course->title }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Enrollment Date</th>
                                                    <td>{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Completion Date</th>
                                                    <td>{{ \Carbon\Carbon::parse($enrollment->completion_date)->format('d.m.Y') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
