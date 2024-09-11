@extends('layouts.admin')

@section('title', 'Pendings')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">All Course Reviews</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive versions-table">
                                        <table id="multi-filter-select" class="display table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Order</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th style="padding: 0 5px !important;">Action</th>
                                                <th style="padding: 0 5px !important;">ID</th>
                                                <th style="padding: 0 5px !important;">Title</th>
                                                <th style="padding: 0 5px !important;">Order</th>
                                                <th style="padding: 0 5px !important;">Status</th>
                                                <th style="padding: 0 5px !important;">Created At</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                @if($reviews->count() > 0)
                                                    @foreach($reviews as $review)
                                                        <tr>
                                                            <td style="padding: 7px !important;">
                                                                <a href="{{ route('admin.courses.show.version', ['id' => $review->course_id]) }}" type="button" data-bs-toggle="tooltip" title="Start Review" class="btn btn-link btn-primary" data-original-title="Start Review">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                            <td style="padding: 7px !important;">{{ $review->id }}</td>
                                                            <td style="padding: 7px !important;">{{ $review->courseVersion->title }}</td>
                                                            <td style="padding: 7px !important;">{{ $review->order }}</td>
                                                            @if($review->status === 'pending')
                                                                <td style="padding: 7px !important;" class="text-warning">{{ ucfirst($review->status) }}</td>
                                                            @elseif($review->status === 'started')
                                                                <td style="padding: 7px !important;" class="text-primary">{{ ucfirst($review->status) }}</td>
                                                            @elseif($review->status === 'rejected')
                                                                <td style="padding: 7px !important;" class="text-danger">{{ ucfirst($review->status) }}</td>
                                                            @elseif($review->status === 'accepted')
                                                                <td style="padding: 7px !important;" class="text-success">{{ ucfirst($review->status) }}</td>
                                                            @endif
                                                            <td style="padding: 7px !important;">{{ $review->created_at }}</td>
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
