@extends('layouts.admin')

@section('title', 'Instructors')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Instructors</h4>
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectUserModal"><i class="fa fa-user-plus me-2"></i>New Instructor</a>
                                    <!-- Add Modal Start -->
                                    <div class="modal fade" id="selectUserModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="selectUserLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="d-flex justify-content-between p-3">
                                                    <h1 class="modal-title fs-5" id="selectUserLabel">New Instructor</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="px-4">
                                                        <form action="{{ route('admin.users.create') }}" method="POST" id="infoForm" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="first_name" class="form-label">First Name</label>
                                                                <input type="text" class="form-control" name="first_name" id="first_name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="last_name" class="form-label">Last Name</label>
                                                                <input type="text" class="form-control" name="last_name" id="last_name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="username" id="username" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" name="email" id="email" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Password</label>
                                                                <input type="text" class="form-control" name="password" id="password" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="role" class="form-label">Role</label>
                                                                <select id="role" name="role" class="form-select" required>
                                                                    <option value="student">Student</option>
                                                                    <option value="instructor" selected>Instructor</option>
                                                                    <option value="admin">Admin</option>
                                                                </select>
                                                            </div>
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
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @if($users->count() > 0)
                                                    @foreach($users as $user)
                                                        <tr>
                                                            <td style="padding: 7px !important;">
                                                                <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" type="button" data-bs-toggle="tooltip" title="Edit"
                                                                   class="btn btn-link btn-primary" data-original-title="Edit">
                                                                    <i class="fa fa-user-edit"></i></a>
                                                            </td>
                                                            <td style="padding: 7px !important;">{{ $user->id }}</td>
                                                            <td style="padding: 7px !important;">{{ $user->first_name }} {{ $user->last_name }}</td>
                                                            <td style="padding: 7px !important;">{{ $user->username }}</td>
                                                            @if($user->instructor->status)
                                                                <td style="padding: 7px !important;">Active</td>
                                                            @else
                                                                <td style="padding: 7px !important;">Inactive</td>
                                                            @endif
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
