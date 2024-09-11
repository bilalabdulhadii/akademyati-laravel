@extends('layouts.course')

@section('title', 'No Sections')

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
                    <li class="nav-section">
                        <h4 class="text-section">Course Materials</h4>
                    </li>
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
                                    <h3 class="text-center">No sections have been created in this version yet.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.lecture-footer')
    </div>

@endsection

