@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">{{ $category->title }}</h4>
                                @if($category->status === 'enabled')
                                    <form action="{{ route('admin.categories.disable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                                        <button class="btn btn-outline-danger"><i class="fas fa-ban me-2"></i>Disable</button>
                                    </form>
                                @elseif($category->status === 'disabled')
                                    <form action="{{ route('admin.categories.enable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                                        <button class="btn btn-outline-success"><i class="fas fa-check me-2"></i>Enable</button>
                                    </form>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="w-25">ID</th>
                                                <td>{{ $category->id }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>{{ ucfirst($category->status) }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Title</th>
                                                <td>{{ $category->title }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Description</th>
                                                <td>{{ $category->description }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Parent Category</th>
                                                @if($category->parent_id)
                                                    @if($category->level == 1)
                                                        <td>{{ $category->title }}</td>
                                                    @elseif($category->level == 2)
                                                        <td>{{ $category->title }} < {{ $category->parent->title }}</td>
                                                    @endif
                                                @else
                                                    <td>None</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-card-no-pd mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">{{ $category->title }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.categories.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" value="{{ $category->title }}" name="title" id="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" rows="4" class="form-control" id="description">{{ $category->description }}</textarea>
                                    </div>
                                    {{--@if($categories->count() > 0)
                                        <label for="parent_id" class="form-label">Parent Category</label>
                                        <select name="parent_id" id="parent_id" class="form-select form-control">
                                            <option value="" selected>None</option>
                                            @foreach($categories as $category1)
                                                @if($category1->level < 3 && $category1->id !== $category->id)
                                                    <option value="{{ $category1->id }}" {{ $category->parent_id == $category1->id ? 'selected' : '' }}>
                                                        @if($category1->level == 1)
                                                            {{ $category1->title }}
                                                        @elseif($category1->level == 2)
                                                            {{ $category1->title }} < {{ $category1->parent->title }}
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
                                    @endif--}}
                                    <button type="submit" class="btn btn-primary my-3">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
