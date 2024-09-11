@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class="row row-card-no-pd mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">{{ $user->first_name }} {{ $user->last_name}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.update') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" id="first_name" value="{{ $user->id }}">
                                    <div class="form-group mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="profile" class="form-label">Profile image</label>
                                        <input type="file" id="profile" name="profile" class="form-control">
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
@endsection
