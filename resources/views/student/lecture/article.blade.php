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
                                                @if($lectureProgress[$lecture->id]['is_done']){{--$lecture->lectureProgress->is_done--}}
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
                                <div class="card-body p-5">
                                    <h3 class="text-center mb-5">{{ $data->title }}</h3>
                                    <div class="mb-2 fr-view">
                                        {!! $data->content !!}
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
                                @endif
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('course.lecture.done', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $data->lecture->id]) }}" method="post" id="doneForm"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <label class="done-checkbox me-2" >
                                            @if($lectureProgress[$data->lecture_id]['is_done']){{--$data->lecture->lectureProgress->is_done--}}
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
                                        <form action="{{ route('course.progress.next', ['slug' => Str::slug($progress->course->title), 'id' => $progress->course_id, 'lecture' => $data->lecture->id]) }}" method="post" id="doneForm"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ $progress->course_id }}" name="course_id">
                                            <input type="hidden" value="{{ $data->section_order }}" name="section_order">
                                            <input type="hidden" value="{{ $data->order }}" name="order">
                                            <button type="submit" class="btn btn-info">Next<i class="fa fa-arrow-right ms-2"></i></button>
                                        </form>
                                    @else
                                        <a type="button" href="{{ route('course.done', ['id' => $progress->course_id]) }}" class="btn btn-info"><i class="fa fa-graduation-cap me-2"></i>Get Certificate</a>
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

