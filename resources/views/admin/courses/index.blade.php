@extends('layouts.admin')

@section('title', 'Courses')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">All Courses</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table {{-- id="basic-datatables" --}} id="multi-filter-select" class="display table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th>Last Update</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th style="padding: 0 5px !important;">Action</th>
                                                <th style="padding: 0 5px !important;">ID</th>
                                                <th style="padding: 0 5px !important;">Status</th>
                                                <th style="padding: 0 5px !important;">Title</th>
                                                <th style="padding: 0 5px !important;">Last Update</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                @if($courses->count() > 0)
                                                    @foreach($courses as $course)
                                                        <tr>
                                                            <td style="padding: 7px !important;">
                                                                <a href="{{ route('admin.courses.show', ['id' => $course->id]) }}" type="button" data-bs-toggle="tooltip" title="Show" class="btn btn-link btn-primary" data-original-title="Show">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                            <td style="padding: 7px !important;">{{ $course->id }}</td>
                                                            @if($course->status === 'published')
                                                                <td style="padding: 7px !important;" class="text-primary">{{ ucfirst($course->status) }}</td>
                                                            @elseif($course->status === 'unpublished')
                                                                <td style="padding: 7px !important;" class="text-warning">{{ ucfirst($course->status) }}</td>
                                                            @endif
                                                            <td style="padding: 7px !important;">{{ $course->title }}</td>
                                                            <td style="padding: 7px !important;">{{ $course->updated_at }}</td>
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
