@extends('layouts.admin')

@section('title', 'Enrollments')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">All Enrollments</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive versions-table">
                                        <table id="multi-filter-select" class="display table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Enrollment Date</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Enrollment Date</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                @if($enrollments->count() > 0)
                                                    @foreach($enrollments as $enrollment)
                                                        <tr>
                                                            <td style="padding: 7px !important;">
                                                                <a href="{{ route('admin.enrollments.show', ['id' => $enrollment->id]) }}" type="button" data-bs-toggle="tooltip" title="Show" class="btn btn-link btn-primary"
                                                                   data-original-title="Show">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                            <td style="padding: 7px !important;">{{ $enrollment->id }}</td>
                                                            <td style="padding: 7px !important;">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                                                            <td style="padding: 7px !important;">{{ $enrollment->course->title }}</td>
                                                            <td style="padding: 7px !important;">{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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
