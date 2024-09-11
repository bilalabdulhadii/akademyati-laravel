@extends('layouts.course')

@section('title', 'Get Certificate')

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
                <button class="topbar-toggler more p-3">
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
                        <li class="nav-item">
                            <a class="d-flex align-items-start collapse-main-ul" data-bs-toggle="collapse" href="#unit{{ $section->order }}">
                                {{--<i class="fas fa-layer-group"></i>--}}
                                <p>{{ $section->title }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="unit{{ $section->order }}">
                                <ul class="nav nav-collapse">
                                    @foreach($lectures->where('section_id', $section->id) as $lecture)
                                        <li class="">
                                            <a class="d-flex justify-content-between" href="{{ route('course.redirect.progress', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $lecture->id]) }}">
                                                <span class="sub-item">{{ $lecture->title }}</span>
                                                @if($lecture->lectureProgress->is_done)
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
                <a class="d-flex align-items-center justify-content-center mt-4" href="">
                    <i class="fas fa-graduation-cap"></i>
                    <p class="mt-3 ms-2">Get Certificate</p>
                </a>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->


    <div class="main-panel">
        @include('student.components.header')

        <div class="container">
            <div class="page-inner">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12 content-above-buttons" style="margin-bottom: 50px">
                            <div class="card card-round">
                                <div class="card-body p-5">
                                    @if($completed === true)
                                        <h3 class="text-center mb-5">Congratulations on Completing the Course! 🎉</h3>
                                        You've successfully finished the course and gained valuable knowledge.
                                        Keep up the great work and continue to build on your skills.
                                    @elseif($completed === false)
                                        <h3 class="text-center mb-5">Almost There!</h3>
                                        You’ve made great progress, but it looks like there are still some
                                        lectures left to complete. Keep up the hard work and finish those
                                        remaining lectures to achieve your course goals. Remember,
                                        every step you take gets you closer to mastering the material!
                                    @endif
                                </div>
                            </div>
                            <div class="button-container">
                                <a href="{{ route('course.redirect.progress', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $last]) }}" class="btn btn-info"><i class="fa fa-arrow-left me-2"></i> Prev</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('student.components.footer')
    </div>

@endsection

