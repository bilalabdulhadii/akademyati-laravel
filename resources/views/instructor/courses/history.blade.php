@extends('layouts.educator')

@section('title', 'Versions History')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">{{ $course->title }}</h4>
                                    <h6 class="text-primary">Active Version: {{ $course->version_number }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="multi-filter-select" class="display table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Version</th>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th>Created At</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th style="padding: 0 5px !important;">Action</th>
                                                <th style="padding: 0 5px !important;">Version</th>
                                                <th style="padding: 0 5px !important;">Status</th>
                                                <th style="padding: 0 5px !important;">Title</th>
                                                <th style="padding: 0 5px !important;">Created At</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @if($versions->count() > 0)
                                                @foreach($versions as $version)
                                                    <tr>
                                                        <td style="padding: 7px !important;">
                                                            <a target="_blank" href="{{ route('courses.view.draft', ['id' =>  $version->id]) }}" type="button" data-bs-toggle="tooltip" title="Show" class="btn btn-link btn-primary" data-original-title="Show">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                        <td style="padding: 7px !important;">{{ $version->version_number }}</td>
                                                        @if($version->status === 'active')
                                                            <td style="padding: 7px !important;" class="text-success">{{ ucfirst($version->status) }}</td>
                                                        @else
                                                            <td style="padding: 7px !important;" class="">{{ ucfirst($version->status) }}</td>
                                                        @endif
                                                        <td style="padding: 7px !important;">{{ $version->title }}</td>
                                                        <td style="padding: 7px !important;">{{ $version->created_at->format('d M Y') }}</td>
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
