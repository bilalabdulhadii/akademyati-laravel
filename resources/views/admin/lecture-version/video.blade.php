@extends('layouts.admin-course')

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
                                        <li class="{{ ($lecture->order == $data->order && $section->order == $data->section_order) ? 'active' : '' }}">
                                            <a class="d-flex justify-content-between" href="{{ route('admin.courses.preview.version', ['id' => $course_id, 'lecture' => $lecture->id]) }}">
                                                <span class="sub-item">{{ $lecture->title }}</span>
                                                <i class="fa fa-square-o ms-2 me-3"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->


    <div class="main-panel">
        @include('admin.components.lecture-header')

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
                                            <li class="nav-item">
                                                <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill"
                                                   href="#line-announcements" role="tab" aria-controls="pills-profile"
                                                   aria-selected="false">Announcements</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                                   href="#line-reviews" role="tab" aria-controls="pills-contact"
                                                   aria-selected="false">Reviews</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill"
                                                   href="#line-community" role="tab" aria-controls="pills-contact"
                                                   aria-selected="false">Community</a>
                                            </li>
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
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                                    mollit anim id est laborum.</p>
                                            </div>
                                            <div class="tab-pane fade" id="line-community" role="tabpanel" aria-labelledby="line-contact-tab">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                                    mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-container">
                                @if($data->section_order == 1 && $data->order == 1)
                                    <div class="bg-transparent"></div>
                                @else
                                    <a type="button" href="{{ route('admin.courses.version.prev', ['id' => $course_id, 'lecture' => $data->lecture_id]) }}"
                                       class="btn btn-info"><i class="fa fa-arrow-left me-2"></i>Prev</a>
                                @endif
                                @if(!$last)
                                    <a type="button" href="{{ route('admin.courses.version.next', ['id' => $course_id, 'lecture' => $data->lecture_id]) }}"
                                       class="btn btn-info">Next<i class="fa fa-arrow-right ms-2"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.lecture-footer')
    </div>

@endsection

