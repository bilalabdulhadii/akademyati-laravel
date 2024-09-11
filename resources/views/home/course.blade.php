
@extends('layouts.app')

@section('title', 'Course Details')

@section('content')

    <div class="page-wrapper single-course-container">
        <div class="course-container-desktop-view">
            <div class="course-basic-details-1">
                <div class="container">
                    <!-- Main Info Section -->
                    <div class="p-4 mb-4">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8 pe-5">
                                <p class="category-title">
                                    {{ $course->category_id ? $course->category->title : '' }}
                                    @if($course->subcategory_id)
                                        > {{ $course->subcategory->title }}
                                    @endif
                                    @if($course->subsubcategory_id)
                                        > {{ $course->subsubcategory->title}}
                                    @endif
                                </p>
                                <p class="course-title">{{ $course->title }}</p>
                                <p class="course-subtitle">{{ $course->subtitle }}</p>
                                <p class="created-by"><em>Created By: </em> <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="instructor-name">Dr. {{ $course->instructor->first_name }} {{ $course->instructor->last_name }}, {{ $course->instructor->professional_title }}</a></p>
                                <a href="#" class="btn watch-intro" data-bs-toggle="modal" data-bs-target="#videoModal">
                                    <i class="fas fa-play-circle"></i> Watch Intro Video
                                </a>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4 mt-4 mt-lg-0">
                                <!-- Content will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="course-basic-details-2">
                <div class="container">
                    <!-- Main Info Section -->
                    <div class="p-4 mb-4">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <div class="course-outcomes">
                                    <p class="outcomes-header">Course outcomes after completing your course.</p>
                                    <ul class="list-unstyled">
                                        @php $counter = 1;@endphp
                                        @foreach($attributes as $attribute)
                                            @if($attribute['type'] === 'objective' && $attribute['order'] == $counter)
                                                <li><i class="fas fa-check me-3"></i> {{ $attribute->content }} </li>
                                                @php $counter++; @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                    <p class="outcomes-header mt-5">Included in This Course</p>
                                    <ul class="list-unstyled">
                                        <li><i class="far fa-file-video me-3"></i> 10 Course video lectures</li>
                                        <li><i class="fas fa-tasks me-3"></i> 10 Course article lectures</li>
                                        <li><i class="far fa-file-alt me-3"></i> 10 Course tasks</li>
                                        <li><i class="fas fa-download me-3"></i> 10 Course resources</li>
                                        <li><i class="fas fa-certificate me-3"></i> Certificate of completion</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Right Column -->
                            <div class="col-lg-4 p-0 mt-4">
                                <div class="main-info">
                                    @if($course->thumbnail)
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="Course Image" class="img-fluid">
                                    @else
                                        <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" class="img-fluid">
                                    @endif
                                    <ul class="list-unstyled test-ul">
                                        <li>Students <span>{{ $course->enrollments->count() > 0 ? $course->enrollments->count() : '' }}</span></li>
                                        <li>Rating
                                            <a href="{{ route('course.index.rating', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">
                                                <span class="rate">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($course->rating))
                                                            <i class="fas fa-star"></i>
                                                        @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ms-2">({{ number_format($course->rating, 1) }})</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>Level <span>{{ $course->level }}</span></li>
                                        <li>Language <span>{{ $course->language }}</span></li>
                                        @if($course->price > 0)
                                            <li>Price <span>${{ $course->price }}</span></li>
                                        @else
                                            <li>Price <span>Free</span></li>
                                        @endif
                                        <li>
                                            @if(Auth::check())
                                                @if(Auth::user()->hasRole('student'))
                                                    @if($enrollment)
                                                        @if($enrollment->status != 'suspended')
                                                            <a href="{{ route('learning') }}" class="btn course-enroll-btn w-100 mt-3">My Learning</a>
                                                        @elseif($enrollment->status === 'suspended')
                                                            <a class="btn course-enroll-btn w-100 mt-3">Your enrolment has been suspended</a>
                                                        @else
                                                            <form action="{{ route('course.enroll') }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                                                                <button type="submit" class="btn course-enroll-btn w-100 mt-3">Enroll Now</button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <form action="{{ route('course.enroll') }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                                                            <button type="submit" class="btn course-enroll-btn w-100 mt-3">Enroll Now</button>
                                                        </form>
                                                    @endif
                                                @else
                                                    {{-- <a href="#" class="btn course-enroll-btn w-100 mt-3">Give an advice</a> --}}
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn course-enroll-btn w-100 mt-3">Enroll Now</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-container-mobile-view">
            <div class="course-basic-details-mobile">
                <div class="container">
                    <div class="mt-4">
                        <div class="main-info">
                            <p class="category-title">
                                {{ $course->category_id ? $course->category->title : '' }}
                                @if($course->subcategory_id)
                                    > {{ $course->subcategory->title }}
                                @endif
                                @if($course->subsubcategory_id)
                                    > {{ $course->subsubcategory->title}}
                                @endif
                            </p>
                            <div class="mb-3 intro-container">
                                @if($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="Course Image" class="img-fluid">
                                @else
                                    <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Course Image" class="img-fluid">
                                @endif
                                <a class="btn play-intro text-decoration-none" data-bs-toggle="modal" data-bs-target="#videoModal"><i class="fas fa-play-circle"></i></a>
                            </div>
                            <p class="course-title">{{ $course->title }}</p>
                            <p class="course-subtitle"> {{ $course->subtitle }} </p>
                            <p class="created-by"><em>Created By: </em> <a href="{{ route('ins.profile', ['username' => $course->instructor->user->username]) }}" class="instructor-name">Dr. {{ $course->instructor->first_name }} {{ $course->instructor->last_name }} , {{ $course->instructor->professional_title }}</a></p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-user-group"></i>
                                    Students:
                                    <span>{{ $course->enrollments->count() > 0 ? $course->enrollments->count() : '' }}</span>
                                    <a class="text-decoration-none text-dark" href="{{ route('course.index.rating', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}">
                                        <span class="rate ms-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($course->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif ($i == ceil($course->rating) && ($course->rating - floor($course->rating)) > 0)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </span>{{ number_format($course->rating, 1) }}
                                    </a>
                                </li>
                                <li><i class="fas fa-graduation-cap"></i> Level: <span>{{ $course->level }}</span></li>
                                <li><i class="fas fa-globe"></i> Language: <span>{{ $course->language }}</span></li>
                                @if($course->price > 0)
                                    <li><i class="fas fa-circle-dollar-to-slot"></i> Price: <span>{{ $course->price }}</span></li>
                                @else
                                    <li><i class="fas fa-circle-dollar-to-slot"></i> Price: <span>Free</span></li>
                                @endif
                            </ul>
                            @if(Auth::check())
                                @if(Auth::user()->hasRole('student'))
                                    @if($enrollment)
                                        @if($enrollment->status != 'suspended')
                                            <a href="{{ route('learning') }}" class="btn course-enroll-btn w-100 mt-3">My Learning</a>
                                        @elseif($enrollment->status === 'suspended')
                                            <a class="btn course-enroll-btn w-100 mt-3">Your enrolment has been suspended</a>
                                        @else
                                            <form action="{{ route('course.enroll') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                                                <button type="submit" class="btn course-enroll-btn w-100 mt-3">Enroll Now</button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('course.enroll') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btn course-enroll-btn w-100 mt-3">Enroll Now</button>
                                        </form>
                                    @endif
                                @else
                                    {{-- <a href="#" class="btn course-enroll-btn w-100 mt-3">Give an advice</a> --}}
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn course-enroll-btn w-100 mt-3">Enroll Now</a>
                            @endif
                        </div>
                    </div>
                    <div class="course-outcomes my-5">
                        <p class="outcomes-header">Course outcomes after completing your course.</p>
                        <ul class="list-unstyled">
                            @php $counter = 1;@endphp
                            @foreach($attributes as $attribute)
                                @if($attribute['type'] === 'objective' && $attribute['order'] == $counter)
                                    <li><i class="fas fa-check me-3"></i> {{ $attribute->content }} </li>
                                    @php $counter++; @endphp
                                @endif
                            @endforeach
                        </ul>
                        <p class="outcomes-header mt-5">Included in This Course</p>
                        <ul class="list-unstyled">
                            <li><i class="far fa-file-video me-3"></i> 10 Course video lectures</li>
                            <li><i class="fas fa-tasks me-3"></i> 10 Course article lectures</li>
                            <li><i class="far fa-file-alt me-3"></i> 10 Course tasks</li>
                            <li><i class="fas fa-download me-3"></i> 10 Course resources</li>
                            <li><i class="fas fa-certificate me-3"></i> Certificate of completion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-desc-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <h3 class="description-header">Who this course is for:</h3>
                        <p>
                            @foreach($attributes as $attribute)
                                @if($attribute['type'] === 'benefit')
                                    {{ $attribute->content }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div class="col-lg-9 mt-5">
                        <h3 class="description-header">Course Description</h3>
                        <p>{{ $course->description }}</p>
                    </div>
                    @php $isExist = false;@endphp
                    @foreach($attributes as $attribute)
                        @if($attribute['type'] === 'prerequisite')
                            @if(!empty($attribute->content))
                                @php $isExist = true;@endphp
                                @break
                            @endif
                        @endif
                    @endforeach
                    @if($isExist)
                        <div class="col-lg-9 mt-5">
                            <h3 class="description-header">Requirements</h3>
                            <p>
                                @php $counter = 1;@endphp
                                @foreach($attributes as $attribute)
                                    @if($attribute['type'] === 'prerequisite' && $attribute['order'] == $counter)
                                        @if(!empty($attribute['content']))
                                            {{ $attribute->content }}
                                            @php $counter++; @endphp
                                        @endif
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="course-instructors-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h3 class="description-header">Instructors</h3>
                        <div class="container my-5">
                            <div class="instructor-section">
                                <div class="instructor-image">
                                    <img src="{{ asset('assets/home/images/course_1.png') }}" alt="Instructor Image">
                                </div>
                                <div class="instructor-content">
                                    <h4 class="instructor-name">Dr. {{ $course->getFullName() }}</h4>
                                    <p class="instructor-title">{{ $course->instructor->professional_title }}</p>
                                    <p class="instructor-description">
                                        Dr. Jane Doe is an expert in computer science with over 15 years of experience in the field. Her courses are well-regarded for their practical insights and engaging content.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container course-content-container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <h3 class="description-header mb-5 text-center">Course Content</h3>
                    <div class="accordion" id="courseAccordion">
                        @if(!empty($data['sections']))
                            @foreach($data['sections'] as $sectionNumber => $section)
                                @php
                                    $lecturesCount = $section['lectures_count'] ?? 0;
                                    $lectureCount = 1;
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $sectionNumber }}">
                                        <button class="accordion-button bg-light text-dark {{ $sectionNumber != 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $sectionNumber }}" aria-expanded="false" aria-controls="collapse{{ $sectionNumber }}">
                                            {{ $section['title'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $sectionNumber }}" class="accordion-collapse collapse {{ $sectionNumber == 1 ? 'show' : '' }}" aria-labelledby="heading{{ $sectionNumber }}" data-bs-parent="#courseAccordion">
                                        <div class="accordion-body">
                                            @php
                                                $combinedLectures = [];
                                                foreach (['articleLectures', 'videoLectures'] as $type) {
                                                    if (!empty($data[$type])) {
                                                        // Iterate over sections
                                                        foreach ($data[$type] as $section => $lectures) {
                                                            // Check if the current section number matches the target section number
                                                            if ($section == $sectionNumber) {
                                                                // Iterate over lectures in the section
                                                                foreach ($lectures as $order => $lecture) {
                                                                    // Ensure that the 'section_number' exists and matches the target section number
                                                                    if (isset($lecture['section_number']) && $lecture['section_number'] == $sectionNumber) {
                                                                        // Add lecture to combined lectures array
                                                                        $combinedLectures[] = [
                                                                            'section' => $section,
                                                                            'order' => $lecture['lecture_number'],
                                                                            'type' => $lecture['type'],
                                                                            'data' => $lecture,
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <ul>
                                                @while($lecturesCount >= $lectureCount)
                                                    @foreach($combinedLectures as $index => $lecture)
                                                        @if($lecture['order'] == $lectureCount)
                                                            <li>
                                                                <div class="lecture-header text-secondary d-flex justify-content-between">
                                                                    <a>
                                                                        @switch($lecture['type'])
                                                                            @case('article')
                                                                                <i class="far fa-file-alt"></i>
                                                                                @break
                                                                            @case('video')
                                                                                <i class="far fa-file-video"></i>
                                                                                @break
                                                                        @endswitch
                                                                        {{ $lecture['data']['title'] ?? '' }}
                                                                    </a>
                                                                    <span>{{ $lecture['data']['duration'] ?? '00:00'}}</span>
                                                                </div>
                                                            </li>
                                                            @php
                                                                $lectureCount++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endwhile
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Promo Video Modal Start -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel">Course Introduction Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            {{-- <iframe src="https://www.youtube.com/embed/iKWIBL4qD0c?mute=1&modestbranding=0&rel=0&controls=1&showinfo=0"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe> --}}
                            <video id="videoPlayer" controls muted playsinline class="w-100">
                                <source src="{{ Storage::url($course->promotional_video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Promo Video Modal End -->
    </div>

    {{-- <script>
        const allStar = document.querySelectorAll('.rating .star');
        const ratingValue = document.querySelector('.rating input');

        allStar.forEach((item, idx) => {
            item.addEventListener('click', function () {
                let click = 0;
                ratingValue.value = idx + 1;

                allStar.forEach(i => {
                    i.classList.replace('fas', 'far');
                    i.classList.remove('active');
                });
                for (let i = 0; i < allStar.length; i++) {
                    if (i <= idx) {
                        allStar[i].classList.replace('far', 'fas');
                        allStar[i].classList.add('active');
                    } else {
                        allStar[i].style.setProperty('--i', click);
                        click++;
                    }
                }
            });
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoPlayer = document.getElementById('videoPlayer');

            // Pause the video when the modal is hidden
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                videoPlayer.pause();
                videoPlayer.currentTime = 0; // Optionally reset the playback position
            });
        });
    </script>

@endsection
