@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class=" d-flex justify-content-between">
                    <h3 class="fw-bold"></h3>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePassModal">Update Password</a>
                    <!-- Update Password Modal Start -->
                    <div class="modal fade" id="updatePassModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatePassLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="d-flex justify-content-between p-3">
                                    <h1 class="modal-title fs-5" id="updatePassLabel">Update Password</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="px-4">
                                        <form action="{{ route('admin.users.update.password', ['id' => $user->id]) }}" method="POST" id="infoForm" enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password</label>
                                                <input type="text" class="form-control" name="password" id="password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary my-3">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Update Password Modal End -->
                </div>
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">{{ $user->first_name }} {{ $user->last_name}}</h4>
                                    <a class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-times me-2"></i>Delete Admin</a>
                                    <!-- Delete Modal Start -->
                                    <div class="modal fade" id="deleteModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="d-flex justify-content-between p-3">
                                                    <h1 class="modal-title fs-5" id="deleteLabel">Delete Admin ?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this admin ? <br> This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                                                    <a type="button" href="{{ route('admin.users.delete', ['id' => $user->id]) }}" class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Modal End -->
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.users.update.basic', ['id' => $user->id ]) }}" method="POST" id="infoForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary my-3">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
