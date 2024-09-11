@extends('layouts.app')

@section('title', 'Dashboard')

@section('head')
@endsection

@section('content')
    <div class="container">
        <div class="learning-container">
            <div class="learning-tabs">
                <div class="col-12">
                    <div class="tab-vertical">
                        <ul class="nav nav-tabs" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-vertical-tab" data-toggle="tab" href="#home-vertical" role="tab" aria-controls="home" aria-selected="true">My Learning</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-vertical-tab" data-toggle="tab" href="#completed-vertical" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-vertical-tab" data-toggle="tab" href="#profile-vertical" role="tab" aria-controls="profile" aria-selected="false">Interest</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="contact-vertical-tab" data-toggle="tab" href="#contact-vertical" role="tab" aria-controls="contact" aria-selected="false">Archived</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="myTabContent3">
                            <div class="tab-pane fade show active" id="home-vertical" role="tabpanel" aria-labelledby="home-vertical-tab">
                                <div class="row">
                                    @if($enrollments->count() > 0)
                                        @foreach($enrollments->reverse() as $enrollment)
                                            @if($enrollment->course->status === 'published' && $enrollment->status === 'active')
                                                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
                                                    <div class="course-card">
                                                        <div class="course-image">
                                                            @if($enrollment->course->thumbnail)
                                                                <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="Course Image" width="100%">
                                                            @else
                                                                <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" width="100%">
                                                            @endif
                                                            <a href="{{ route('course.redirect.progress', ['slug' => Str::slug($enrollment->course->title), 'id' => $enrollment->course->id, 'lecture' => $enrollment->lecture_id]) }}"
                                                               class="continue-course"><i class="fas fa-play"></i></a>
                                                            <div class="progress-bar">
                                                                <div class="progress" style="width: {{ (int) $enrollment->progress_percentage }}%;"></div>
                                                            </div>
                                                            <div class="progress-value">{{ (int) $enrollment->progress_percentage }}%</div>
                                                        </div>
                                                        <div class="course-details">
                                                            <a href="{{ route('course.index', ['slug' => Str::slug($enrollment->course->title), 'id' => $enrollment->course->id]) }}"
                                                               class="course-title1">
                                                                {{ $enrollment->course->title }}
                                                            </a>
                                                             <div class="d-flex justify-content-between">
                                                                <p class="enroll-date">enrolled at: {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y - H:i') }}</p>
                                                                {{-- <div class="options-button d-flex align-self-end">
                                                                    <button type="button" class="btn btn-light btn-sm">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                                                                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                                                                        <li><a class="dropdown-item" href="#">Option 3</a></li>
                                                                    </ul>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{--@else
                                                <p class="text-center fs-5 mt-5"><a href="{{ route('courses.index') }}">Explore</a> new courses now.</p>--}}
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-center fs-5 mt-5"><a href="{{ route('courses.index') }}">Explore</a> new courses now.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="completed-vertical" role="tabpanel" aria-labelledby="completed-vertical-tab">
                                <div class="row">
                                    @if($enrollments->count() > 0)
                                        @foreach($enrollments as $enrollment)
                                            @if($enrollment->course->status === 'published' && $enrollment->status === 'completed')
                                                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
                                                    <div class="course-card">
                                                        <div class="course-image">
                                                            @if($enrollment->course->thumbnail)
                                                                <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="Course Image" width="100%">
                                                            @else
                                                                <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" width="100%">
                                                            @endif
                                                            <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" width="100%">
                                                            <a href="{{ route('course.redirect.progress', ['slug' => Str::slug($enrollment->course->title), 'id' => $enrollment->course->id, 'lecture' => $enrollment->lecture_id]) }}"
                                                               class="continue-course"><i class="fas fa-play"></i></a>
                                                            <div class="progress-bar">
                                                                <div class="progress" style="width: {{ (int) $enrollment->progress_percentage }}%;"></div>
                                                            </div>
                                                            <div class="progress-value">{{ (int) $enrollment->progress_percentage }}%</div>
                                                        </div>
                                                        <div class="course-details">
                                                            <a href="{{ route('course.index', ['slug' => Str::slug($enrollment->course->title), 'id' => $enrollment->course->id]) }}"
                                                               class="course-title1">
                                                                {{ $enrollment->course->title }}
                                                            </a>
                                                            <div class="d-flex justify-content-between">
                                                                <p class="enroll-date">enrolled at: {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y - H:i') }}</p>
                                                                {{-- <div class="options-button d-flex align-self-end">
                                                                    <button type="button" class="btn btn-light btn-sm">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                                                                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                                                                        <li><a class="dropdown-item" href="#">Option 3</a></li>
                                                                    </ul>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{--@else
                                                <p class="text-center fs-5 mt-5">No completed courses</p>
                                                @break--}}
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-center fs-5 mt-5">No completed courses</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-vertical" role="tabpanel" aria-labelledby="profile-vertical-tab">
                                <div class="row">
                                    @if($bookmarks->count() > 0)
                                        @foreach($bookmarks as $bookmark)
                                            @if($bookmark->course)
                                                @if($bookmark->course->status === 'published')
                                                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
                                                        <div class="course-card">
                                                            <div class="course-image">
                                                                @if($bookmark->course->thumbnail)
                                                                    <img src="{{ Storage::url($bookmark->course->thumbnail) }}" alt="Course Image" width="100%">
                                                                @else
                                                                    <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" width="100%">
                                                                @endif
                                                                <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" width="100%">
                                                                {{-- <a href="{{ route('course.redirect.progress', ['slug' => Str::slug($bookmark->course->title), 'id' => $bookmark->course->id, 'lecture' => $bookmark->lecture_id]) }}"
                                                                   class="continue-course"><i class="fas fa-play"></i></a> --}}
                                                                @if(Auth::check() && Auth::user()->hasRole('student'))
                                                                    <form action="{{ route('course.bookmark') }}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="course_id" value="{{ $bookmark->course->id }}">
                                                                        @if($bookmark->course->isBookmarked($bookmark->course->id))
                                                                            <div class="add-to-favorite-icon-filled">
                                                                                <button type="submit"><i class="fa fa-bookmark"></i></button>
                                                                            </div>
                                                                        @else
                                                                            <div class="add-to-favorite-icon-empty">
                                                                                <button type="submit"><i class="fa fa-bookmark-o"></i></button>
                                                                            </div>
                                                                        @endif
                                                                    </form>
                                                                @endif
                                                            </div>
                                                            <div class="course-details">
                                                                <a href="{{ route('course.index', ['slug' => Str::slug($enrollment->course->title), 'id' => $enrollment->course->id]) }}"
                                                                   class="course-title1">
                                                                    {{ $bookmark->course->title }}
                                                                </a>
                                                                {{-- <div class="d-flex justify-content-between">
                                                                    <p class="enroll-date">enrolled at: {{ \Carbon\Carbon::parse($bookmark->enrollment_date)->format('d.m.Y - H:i') }}</p>
                                                                    <div class="options-button d-flex align-self-end">
                                                                        <button type="button" class="btn btn-light btn-sm">
                                                                            <i class="fas fa-ellipsis-v"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a class="dropdown-item" href="#">Option 1</a></li>
                                                                            <li><a class="dropdown-item" href="#">Option 2</a></li>
                                                                            <li><a class="dropdown-item" href="#">Option 3</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{--@else
                                                    <p class="text-center fs-5 mt-5">No interest courses</p>
                                                    @break--}}
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-center fs-5 mt-5">No interest courses</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact-vertical" role="tabpanel" aria-labelledby="contact-vertical-tab">
                                <p class="text-center fs-5 mt-5">No archived courses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const optionButtons = document.querySelectorAll('.options-button .btn');

            optionButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevent the event from bubbling up to the document
                    const dropdown = this.nextElementSibling;

                    // Hide all dropdowns
                    document.querySelectorAll('.options-button .dropdown-menu').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.remove('show');
                        }
                    });

                    // Toggle the clicked dropdown
                    dropdown.classList.toggle('show');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.options-button')) {
                    document.querySelectorAll('.options-button .dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
@endsection


