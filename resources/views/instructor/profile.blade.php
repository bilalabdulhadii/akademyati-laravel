@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', $user->username)

@section('head')
@endsection

@section('content')
    <div class="container" style="margin-top: 150px">
        @if(Auth::check() && Auth::id() == $user->id && $progress['value'] < 100)
            <div class="profile-data-progress">
                <h5>Complete your profile</h5>
                <p class="mb-2">Your profile is your professional face. Complete it to stand out and attract eager
                    learners!</p>
                <div class="profile-progress-bar">
                    @if($progress['value'] == 0)
                        <div class="w-100 d-flex justify-content-center align-items-center">
                            <span>{{ round($progress['value']) }}%</span>
                        </div>
                    @endif
                    <div class="profile-progress" style="width: {{ $progress['value'] }}%">
                        @if($progress['value'] > 0)
                            <span>{{ round($progress['value']) }}%</span>
                        @endif
                    </div>
                </div>
                <div class="profile-progress-item">
                    <i class="progress-check far {{ $progress['profile'] ? 'fa-check-circle' : 'fa-circle' }}"></i>
                    <span class="d-flex flex-grow-1 {{ $progress['profile'] ? 'completed' : '' }}">Profile Picture</span>
                    @if($progress['profile'])
                        <a class="progress-complete completed"><i class="fas fa-arrow-right"></i></a>
                    @else
                        <a class="progress-complete" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                class="fas fa-arrow-right"></i></a>
                    @endif
                </div>
                <div class="profile-progress-item">
                    <i class="progress-check far {{ $progress['additional'] ? 'fa-check-circle' : 'fa-circle' }}"></i>
                    <span class="d-flex flex-grow-1 {{ $progress['additional'] ? 'completed' : '' }}">Personal Details</span>
                    @if($progress['additional'])
                        <a class="progress-complete completed"><i class="fas fa-arrow-right"></i></a>
                    @else
                        <a class="progress-complete" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                class="fas fa-arrow-right"></i></a>
                    @endif
                </div>
            </div>
        @endif

        <div class="profile-container">
            <div class="row">
                <div class="col-lg-4 profile-first">
                    <div class="personal-details">
                        @if(Auth::check())
                            @if(Auth::id() == $user->id)
                                <a type="button" class="edit-user" data-bs-toggle="modal"
                                   data-bs-target="#staticBackdrop"><i class="fa fa-pen"></i></a>
                            @endif
                        @endif
                        <div class="profile-img">
                            <div class="profile-img">
                                @if($user->profile)
                                    <img src="{{ Storage::url($user->profile) }}" alt="profile image">
                                @else
                                    <p class="rounded-circle profile-none">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</p>
                                @endif
                            </div>
                        </div>
                        <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
                        <p><i class=""></i>Joined at {{ Carbon::parse($user->created_at)->format('F Y') }}</p>
                            <p><i class="far fa-envelope me-2"></i>{{ $user->email }}</p>
                        @if($user->instructor->professional_title)
                            <span class="pro-title-badge">{{ $user->instructor->professional_title }}</span>
                        @endif

                        <div class="mt-4 w-100 d-flex justify-content-evenly">
                            @php
                                $totalEnrollments = 0;
                                foreach ($user->instructor->courses as $course) {
                                    $totalEnrollments += $course->enrollments->count();
                                }
                            @endphp
                            <div class="d-flex flex-column justify-content-start align-items-center">
                                <h4 class="profile-data-counter"><b>{{ $totalEnrollments }}</b></h4>
                                <small>Students</small>
                            </div>
                            <div class="d-flex flex-column justify-content-start align-items-center">
                                <h4 class="profile-data-counter"><b>{{ $user->instructor->courses->count() ?? 0 }}</b></h4>
                                <small>Courses</small>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="w-100 d-flex">
                            @if(Auth::check() && Auth::id() != $user->id)
                                <a id="copyLink" class="btn share-user share-user-1">
                                    <p><i class="fa fa-share-nodes me-2"></i>Share Profile</p>
                                </a>
                                <form class="w-100" action="{{ route('inbox.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="check_contact">{{-- {{ $user->isContact() ? 'read_message' : 'new_contact' }} --}}
                                    <input type="hidden" name="contact_id" value="{{ $user->id }}">
                                    <button type="submit" class="share-user border-start border-0 share-user-2">
                                        <p><i class="fa fa-comments me-2"></i>Chat</p>
                                    </button>
                                </form>
                                {{-- <a href="#" class="share-user border-start share-user-2"><p><i
                                            class="fa fa-comments me-2"></i>Chat</p></a> --}}
                            @else
                                <a id="copyLink" class="btn share-user share-user-3">
                                    <p><i class="fa fa-share-nodes me-2"></i>Share Profile</p>
                                </a>
                            @endif
                        </div>
                        <p id="copyMessage" class="px-3 py-0 rounded-pill bg-dark text-white position-absolute">URL copied to clipboard!</p>
                    </div>
                    <div class="additional-links">

                    </div>
                </div>
                <div class="col-lg-8 profile-second">
                    <div class="achievements-courses">
                        <h5>Courses Taught</h5>
                        <div class="courses">
                            @if($courses->count() > 0)
                                @foreach($courses as $course)
                                    @if($course->status === 'published')
                                        <div class="course-card">
                                            <div class="course-img">
                                                @if($course->thumbnail)
                                                    <img src="{{ Storage::url($course->thumbnail) }}"
                                                         alt="Course Image">
                                                @else
                                                    <img src="{{ asset('assets/home/images/course_1.png') }}"
                                                         alt="Course Image">
                                                @endif
                                            </div>
                                            <div class="course-title">
                                                <a href="{{ route('course.index', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">{{ $course->title }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal Start -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content" style="max-height: 80%">
                    <div class="d-flex justify-content-between p-3">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="px-4">
                            <h5 class="mb-2">Personal Details</h5>
                            <p class="mb-4">Update your profile by entering your personal details below.</p>
                            <form action="{{ route('ins.profile.update', ['id' => $user->id]) }}" method="post"
                                  enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <h4 class="mb-2">Basic info</h4>
                                <div class="form-group mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                           value="{{ $user->first_name }}" placeholder="enter first name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                           value="{{ $user->last_name }}" placeholder="enter last name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                           value="{{ $user->username }}" placeholder="enter a username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ $user->email }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="profile" class="form-label">Profile image</label>
                                    <input type="file" id="profile" name="profile" class="form-control">
                                </div>

                                <h4 class="mt-5 mb-2">Additional info</h4>

                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option {{ $instructor->gender === '' ? 'selected' : '' }} value="">Select
                                            Gender
                                        </option>
                                        <option {{ $instructor->gender === 'male' ? 'selected' : '' }} value="male">
                                            Male
                                        </option>
                                        <option {{ $instructor->gender === 'female' ? 'selected' : '' }} value="female">
                                            Female
                                        </option>
                                        <option {{ $instructor->gender === 'other' ? 'selected' : '' }} value="other">
                                            Other
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea id="bio" name="bio" class="form-control" rows="3"
                                              required>{{ $instructor->bio }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ $instructor->phone }}"
                                           class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" id="address" name="address" value="{{ $instructor->address }}"
                                           class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="birth" class="form-label">Date of Birth</label>
                                    <input type="date" id="birth" name="birth" value="{{ $instructor->birth }}"
                                           class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" id="nationality" name="nationality"
                                           value="{{ $instructor->nationality }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="education_level" class="form-label">Education Level</label>
                                    {{-- <input type="text" id="education_level" name="education_level" value="{{ $instructor->education_level }}" class="form-control" required> --}}
                                    <select id="education_level" name="education_level" class="form-select form-control" required>
                                        <option {{ $instructor->education_level === '' ? 'selected' : '' }} value="">
                                            Select education level
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'High School Diploma' ? 'selected' : '' }} value="High School Diploma">
                                            High School Diploma
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Associate Degree' ? 'selected' : '' }} value="Associate Degree">
                                            Associate Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Bachelors Degree' ? 'selected' : '' }} value="Bachelors Degree">
                                            Bachelor's Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Masters Degree' ? 'selected' : '' }} value="Masters Degree">
                                            Master's Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Doctoral Degree' ? 'selected' : '' }} value="Doctoral Degree">
                                            Doctoral Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Professional Degree' ? 'selected' : '' }} value="Professional Degree">
                                            Professional Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Postdoctoral Fellowship' ? 'selected' : '' }} value="Postdoctoral Fellowship">
                                            Postdoctoral Fellowship
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Certificate or Diploma Program' ? 'selected' : '' }} value="Certificate or Diploma Program">
                                            Certificate or Diploma Program
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'Vocational or Technical Degree' ? 'selected' : '' }} value="Vocational or Technical Degree">
                                            Vocational or Technical Degree
                                        </option>
                                        <option
                                            {{ $instructor->education_level === 'other' ? 'selected' : '' }} value="other">
                                            Other
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="field_of_expertise" class="form-label">Field of Expertise</label>
                                    <input type="text" id="field_of_expertise" name="field_of_expertise"
                                           value="{{ $instructor->field_of_expertise }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="professional_title" class="form-label">Professional Title</label>
                                    <input type="text" id="professional_title" name="professional_title"
                                           value="{{ $instructor->professional_title }}" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="certifications" class="form-label">Certifications</label>
                                    <textarea id="certifications" name="certifications" class="form-control"
                                              rows="3">{{ $instructor->certifications }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="experience" class="form-label">Experience</label>
                                    <textarea id="experience" name="experience" class="form-control"
                                              rows="3">{{ $instructor->experience }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="language" class="form-label">Language</label>
                                    <input type="text" id="language" name="language" value="{{ $instructor->language }}"
                                           class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary mb-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal End -->
    </div>

    <script>
    document.getElementById('copyLink').addEventListener('click', function(event) {
        event.preventDefault();

        const pageUrl = window.location.href;
        navigator.clipboard.writeText(pageUrl).then(function() {
            // Show the message
            const messageElement = document.getElementById('copyMessage');
            messageElement.style.display = 'block';

            // Hide the message after 3 seconds
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 1500);
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    });
    </script>
@endsection
