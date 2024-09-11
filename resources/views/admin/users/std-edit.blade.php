@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')
    <div class="container">
        <div class="page-inner" style="min-height: 90vh">
            <div class="container">
                <div class=" d-flex justify-content-between">
                    <h3 class="fw-bold">{{ $user->first_name }} {{ $user->last_name}}</h3>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">Basic info</h4>
                                <a class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-times me-2"></i>Delete Student</a>
                                <!-- Delete Modal Start -->
                                <div class="modal fade" id="deleteModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="d-flex justify-content-between p-3">
                                                <h1 class="modal-title fs-5" id="deleteLabel">Delete Student ?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this student ? <br> This action cannot be undone.</p>
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

                <div class="row row-card-no-pd mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Student info</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.users.update.std', ['id' => $user->id ]) }}" method="POST" id="infoForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" name="gender" class="form-select">
                                            <option {{ $student->gender === '' ? 'selected' : '' }} value="">Select Gender</option>
                                            <option {{ $student->gender === 'male' ? 'selected' : '' }} value="male">Male</option>
                                            <option {{ $student->gender === 'female' ? 'selected' : '' }} value="female">Female</option>
                                            <option {{ $student->gender === 'other' ? 'selected' : '' }} value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">Bio</label>
                                        <textarea id="bio" name="bio" class="form-control" rows="3">{{ $student->bio }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" id="phone" name="phone" value="{{ $student->phone }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" id="address" name="address" value="{{ $student->address }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="birth" class="form-label">Date of Birth</label>
                                        <input type="date" id="birth" name="birth" value="{{ $student->birth }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nationality" class="form-label">Nationality</label>
                                        <input type="text" id="nationality" name="nationality" value="{{ $student->nationality }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="education_level" class="form-label">Education Level</label>
                                        {{-- <input type="text" id="education_level" name="education_level" value="{{ $student->education_level }}" class="form-control"> --}}
                                        <select id="education_level" name="education_level" class="form-select form-control" required>
                                            <option {{ $student->education_level === '' ? 'selected' : '' }} value="">Select education level</option>
                                            <option {{ $student->education_level === 'High School Diploma' ? 'selected' : '' }} value="High School Diploma">High School Diploma</option>
                                            <option {{ $student->education_level === 'Associate Degree' ? 'selected' : '' }} value="Associate Degree">Associate Degree</option>
                                            <option {{ $student->education_level === 'Bachelors Degree' ? 'selected' : '' }} value="Bachelors Degree">Bachelor's Degree</option>
                                            <option {{ $student->education_level === 'Masters Degree' ? 'selected' : '' }} value="Masters Degree">Master's Degree</option>
                                            <option {{ $student->education_level === 'Doctoral Degree' ? 'selected' : '' }} value="Doctoral Degree">Doctoral Degree</option>
                                            <option {{ $student->education_level === 'Professional Degree' ? 'selected' : '' }} value="Professional Degree">Professional Degree</option>
                                            <option {{ $student->education_level === 'Postdoctoral Fellowship' ? 'selected' : '' }} value="Postdoctoral Fellowship">Postdoctoral Fellowship</option>
                                            <option {{ $student->education_level === 'Certificate or Diploma Program' ? 'selected' : '' }} value="Certificate or Diploma Program">Certificate or Diploma Program</option>
                                            <option {{ $student->education_level === 'Vocational or Technical Degree' ? 'selected' : '' }} value="Vocational or Technical Degree">Vocational or Technical Degree</option>
                                            <option {{ $student->education_level === 'other' ? 'selected' : '' }} value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="major" class="form-label">Major</label>
                                        <input type="text" id="major" name="major" value="{{ $student->major }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="interests" class="form-label">Interests</label>
                                        <textarea id="interests" name="interests" class="form-control" rows="3">{{ $student->interests }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="language" class="form-label">Language</label>
                                        <input type="text" id="language" name="language" value="{{ $student->language }}" class="form-control">
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
