@extends('layouts.educator')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    {{-- <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6> --}}
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
            </div>
            <div class="container">
                <div class="row row-card-no-pd mt-4">
                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="fas fa-desktop text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Courses</p>
                                            <h4 class="card-title">{{ $data['courses'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="far fa-user text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Enrollments</p>
                                            <h4 class="card-title">+{{ $data['enrollments'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="icon-wallet text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Revenue</p>
                                            <h4 class="card-title">$ {{ number_format($data['revenue'], 2) }}</h4>
                                        </div>
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
