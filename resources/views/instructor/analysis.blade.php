@extends('layouts.educator')

@section('title', 'Analysis')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container">
                {{-- <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Dashboard</h3>
                        <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6>
                    </div>
                    <div class="ms-md-auto py-2 py-md-0">
                        <a href="{{ route('ins.courses') }}" class="btn btn-label-info btn-round me-2">Manage</a>
                        <a type="submit" id="createButton" class="btn btn-primary btn-round">Create Your Course</a>
                        <form id="createCourseForm" class="d-none" action="{{ route('courses.create.basic') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="create" id="create">
                        </form>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-info bg-info-gradient">
                            <div class="card-body skew-shadow">
                                <h5 class="op-8">Total Enrollments</h5>
                                <div class="pull-right">
                                    <h3 class="fw-bold op-8">{{ $data['totalEnrollments'] ?? '' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-success bg-success-gradient">
                            <div class="card-body bubble-shadow">
                                <h5 class="op-8">Course Completion Rate</h5>
                                <div class="pull-right">
                                    <h3 class="fw-bold op-8">{{ number_format($data['completionRate'], 2) ?? ''}}%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-secondary bg-secondary-gradient">
                            <div class="card-body curves-shadow">
                                <h5 class="op-8">Lecture Completion Rates</h5>
                                <div class="pull-right">
                                    <h3 class="fw-bold op-8">{{  number_format($data['lectureCompletionRate'], 2) ?? '' }}%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createButton').addEventListener('click', function() {
                document.getElementById('createCourseForm').submit();
            });
        });
    </script>
@endsection
