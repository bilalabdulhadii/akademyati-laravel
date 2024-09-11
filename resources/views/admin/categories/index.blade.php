@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <!-- Card With Icon States Color -->
                <div class="row row-card-no-pd mt-5">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                     {{-- <div class="col-3">
                                        <div class="icon-big">
                                            <i class="fas fa-grip-vertical text-success"></i>
                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">All</p>
                                            <h4 class="card-title">{{ $categories->count() ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Main</p>
                                            <h4 class="card-title">{{ $categoryCounts['main'] ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Sub</p>
                                            <h4 class="card-title">{{ $categoryCounts['sub'] ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">SubSub</p>
                                            <h4 class="card-title">{{ $categoryCounts['subSub'] ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card With Icon States Background -->
                <div class="row row-card-no-pd mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">All Categories</h4>
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa fa-user-plus me-2"></i>New Category</a>
                                <!-- Add Modal Start -->
                                <div class="modal fade" id="createModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="d-flex justify-content-between p-3">
                                                <h1 class="modal-title fs-5" id="createLabel">New User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="px-4">
                                                    <form action="{{ route('admin.categories.create') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" name="title" id="title" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea name="description" class="form-control" id="description"></textarea>
                                                        </div>
                                                        @if($categories->count() > 0)
                                                            <label for="parent_id" class="form-label">Parent Category</label>
                                                            <select name="parent_id" id="parent_id" class="form-select form-control">
                                                                <option value="" selected>None</option>
                                                                @foreach($categories as $category)
                                                                    @if($category->level < 3)
                                                                        <option value="{{ $category->id }}">
                                                                            @if($category->level == 1)
                                                                                {{ $category->title }}
                                                                            @elseif($category->level == 2)
                                                                                {{ $category->title }} < {{ $category->parent->title }}
                                                                            @endif
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <label for="parent_id" class="form-label">Parent Category</label>
                                                            <select name="parent_id" id="parent_id" class="form-select form-control" disabled>
                                                                <option value="" selected>None</option>
                                                            </select>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary my-3">Create</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add Modal End -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive versions-table">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Parent</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Parent</th>
                                            <th>Status</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @if($categories->count() > 0)
                                                @foreach($categories as $category)
                                                    <tr>
                                                        <td style="padding: 7px !important;">
                                                            <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}" type="button" data-bs-toggle="tooltip" title="Edit"
                                                               class="btn btn-link btn-primary" data-original-title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <td style="padding: 7px !important;">{{ $category->id }}</td>
                                                        <td style="padding: 7px !important;">{{ $category->title }}</td>
                                                        <td style="padding: 7px !important;">{{ $category->parent ? $category->parent->title : 'None' }}</td>
                                                        <td style="padding: 7px !important;">{{ ucfirst($category->status) }}</td>
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
@endsection
