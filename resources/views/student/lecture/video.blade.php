@extends('layouts.course')

@section('title', 'Lecture - Video')

@section('content')

    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a class="logo">
                    <img src="{{ asset('dash/assets/img/logo_light.svg') }}"
                         alt="navbar brand" class="navbar-brand"
                         height="20" style="padding-left: 20px"/>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    {{-- Label --}}
                    <li class="nav-section">
                        {{--<span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>--}}
                        <h4 class="text-section">Course Materials</h4>
                    </li>

                    @foreach($sections as $section)
                        <li class="nav-item {{ $section->order == $data->section_order ? 'active' : '' }}">
                            <a class="d-flex align-items-start collapse-main-ul" data-bs-toggle="collapse" href="#unit{{ $section->order }}">
                                {{--<i class="fas fa-layer-group"></i>--}}
                                <p>{{ $section->title }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ $section->order == $data->section_order ? 'show' : '' }}" id="unit{{ $section->order }}">
                                <ul class="nav nav-collapse">
                                    @foreach($lectures->where('section_id', $section->id) as $lecture)
                                        @php
                                            /*$isActiveLecture = $lecture->order == $data->order ? 'active' : '';*/
                                        @endphp
                                        <li class="{{ ($lecture->order == $data->order && $section->order == $data->section_order) ? 'active' : '' }}">
                                            <a class="d-flex justify-content-between" href="{{ route('course.redirect.progress', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $lecture->id]) }}">
                                                <span class="sub-item">{{ $lecture->title }}</span>
                                                @if($lectureProgress[$lecture->id]['is_done'])
                                                    <i class="fa fa-check-square ms-2 me-3"></i>
                                                @else
                                                    <i class="fa fa-square-o ms-2 me-3"></i>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a class="d-flex align-items-center justify-content-center mt-4" href="{{ route('course.done', ['id' => $progress->course_id]) }}">
                    <i class="fas fa-graduation-cap"></i>
                    <p class="mt-3 ms-2">Get Certificate</p>
                </a>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->


    <div class="main-panel">
        @include('student.components.header', ['progress' => $progress])

        <div class="container">
            <div class="page-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 content-above-buttons" style="margin-bottom: 50px">
                            <div class="card card-round">
                                <div class="card-body" style="padding: 0">
                                    <div class="video-container">
                                        <iframe width="100%" height="100%"
                                                src="https://www.youtube.com/embed/{{ $video_id }}?mute=0&modestbranding=0&rel=0&controls=1&showinfo=0"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="p-4">

                                        <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="line-home-tab" data-bs-toggle="pill"
                                                   href="#line-overviews" role="tab" aria-controls="pills-home"
                                                   aria-selected="true">Overviews</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill"
                                                   href="#line-announcements" role="tab" aria-controls="pills-profile"
                                                   aria-selected="false">Announcements</a>
                                            </li> --}}
                                            <li class="nav-item">
                                                <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                                   href="#line-reviews" role="tab" aria-controls="pills-contact"
                                                   aria-selected="false">Reviews</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                                   href="#line-community" role="tab" aria-controls="pills-contact"
                                                   aria-selected="false">Community</a>
                                            </li> --}}
                                        </ul>
                                        <div class="tab-content mt-3 mb-3" id="line-tabContent">
                                            <div class="tab-pane fade show active" id="line-overviews" role="tabpanel" aria-labelledby="line-home-tab">
                                                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                                                    <div>
                                                        <h3 class="fw-bold mb-5">{{ $data->title }}</h3>
                                                        {{--<h6 class="op-7 mb-4">{{ $progress->course->instructor->first_name }} {{ $progress->course->instructor->last_name }}</h6>--}}

                                                        <div class="mb-2 fr-view">
                                                            {!! $data->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="line-announcements" role="tabpanel" aria-labelledby="line-profile-tab">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                                    mollit anim id est laborum.</p>
                                            </div>
                                            <div class="tab-pane fade" id="line-reviews" role="tabpanel" aria-labelledby="line-contact-tab">
                                                <h4 class="mt-4 mb-5">Student feedbacks: </h4>
                                                <div class="d-flex justify-content-around p-3 border border-secondary rounded-2 mb-5">
                                                    <div>
                                                        <span style="color: #FFBD13">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($progress->course->rating))
                                                                    <i class="fas fa-star"></i>
                                                                @elseif ($i == ceil($progress->course->rating) && ($progress->course->rating - floor($progress->course->rating)) > 0)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </span>{{ $progress->course->rating }}
                                                    </div>
                                                    <span>{{ $progress->course->ratings->count() ?? 0 }} Ratings</span>
                                                    <span>{{ $progress->course->enrollments->count() > 0 ? $progress->course->enrollments->count().' Students Enroll' : 'No Enrolls' }}</span>
                                                </div>
                                                <div class="mx-4">
                                                    @if($progress->course->ratings->count() > 0)
                                                        @foreach($progress->course->ratings as $index => $rate)
                                                            <div class="">
                                                                <div>
                                                                    <span style="color: #FFBD13">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $rate->rating)
                                                                                <i class="fas fa-star"></i>
                                                                            @else
                                                                                <i class="far fa-star"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </span>{{ $rate->rating }}
                                                                </div>
                                                                <p>{{ substr($rate->student->first_name, 0, 1) }}**** {{ substr($rate->student->last_name, 0, 1) }}**** - {{ $rate->updated_at->format('d M Y') }}</p>
                                                                @if($rate->comment)
                                                                    <p>{{ $rate->comment }}</p>
                                                                @endif
                                                                @if($index != ($progress->course->ratings->count() - 1))
                                                                    <hr>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                            </div>
                                            {{-- <div class="tab-pane fade" id="line-community" role="tabpanel" aria-labelledby="line-contact-tab">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                                    mollit anim id est laborum.</p>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-container">
                                @if($data->section_order == 1 && $data->order == 1)
                                    <div class="bg-transparent"></div>
                                @else
                                    <form action="{{ route('course.progress.prev', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $data->lecture->id]) }}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $progress->course_id }}" name="course_id">
                                        <input type="hidden" value="{{ $data->section_order }}" name="section_order">
                                        <input type="hidden" value="{{ $data->order }}" name="order">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-arrow-left me-2"></i> Prev</button>
                                    </form>
                                    {{--<a class="btn btn-info"><i class="fa fa-arrow-left me-2"></i> Prev</a>--}}
                                @endif
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('course.lecture.done', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $data->lecture->id]) }}" method="post" id="doneForm"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <label class="done-checkbox me-2" >
                                            @if($lectureProgress[$data->lecture_id]['is_done'])
                                                <input type="checkbox" name="is_done" id="checkbox" checked disabled/>
                                            @else
                                                <input type="checkbox" name="is_done" id="checkbox" {{ $lectureProgress[$data->lecture_id]['is_done'] ? 'checked' : '' }}/>
                                            @endif
                                            <span class="checkbox-custom"></span>
                                            <span id="checkbox-label">Done</span>
                                        </label>
                                    </form>
                                    <script>
                                        document.getElementById('checkbox').addEventListener('change', function() {
                                            document.getElementById('doneForm').submit();
                                        });
                                    </script>
                                    @if(!$last)
                                        <form action="{{ route('course.progress.next', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $data->lecture->id]) }}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ $progress->course_id }}" name="course_id">
                                            <input type="hidden" value="{{ $data->section_order }}" name="section_order">
                                            <input type="hidden" value="{{ $data->order }}" name="order">
                                            <button type="submit" class="btn btn-info">Next<i class="fa fa-arrow-right ms-2"></i></button>
                                        </form>
                                    @else
                                        <a href="{{ route('course.done', ['id' => $progress->course_id]) }}" class="btn btn-success"><i class="fa fa-graduation-cap me-2"></i>Get Certificate</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('student.components.footer')
    </div>

@endsection

