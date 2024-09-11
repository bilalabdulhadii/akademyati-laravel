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
                                            <a class="d-flex justify-content-between" href="{{ route('admin.courses.preview', ['id' => $course_id, 'lecture' => $lecture->id]) }}">
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
                                    <a type="button" href="{{ route('admin.courses.preview.prev', ['id' => $course_id, 'lecture' => $data->lecture->id]) }}"
                                       class="btn btn-info"><i class="fa fa-arrow-left me-2"></i>Prev</a>
                                @endif
                                @if(!$last)
                                    <a type="button" href="{{ route('admin.courses.preview.next', ['id' => $course_id, 'lecture' => $data->lecture->id]) }}"
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

