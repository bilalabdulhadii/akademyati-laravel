
<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('dash/assets/img/logo_light.svg') }}"
                    alt="navbar brand" class="navbar-brand" height="20"/>
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
                <li class="nav-item {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">TOOLBOX</h4>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'inbox') ? 'active' : '' }}">
                    <a target="_blank" href="{{ route('inbox.index') }}">
                        <i class="fas fa-envelope"></i>
                        <p>Messages</p>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#users">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'show' : '' }}" id="users">
                        <ul class="nav nav-collapse">
                            <li class="{{ Route::currentRouteName() === 'admin.users' ? 'active' : '' }}">
                                <a href="{{ route('admin.users') }}">
                                    <span class="sub-item"> All Users </span>
                                </a>
                            </li>
                            <li class="{{ Route::currentRouteName() === 'admin.users.instructor' ? 'active' : '' }}">
                                <a href="{{ route('admin.users.instructor') }}">
                                    <span class="sub-item"> Instructors </span>
                                </a>
                            </li>
                            <li class="{{ Route::currentRouteName() === 'admin.users.student' ? 'active' : '' }}">
                                <a href="{{ route('admin.users.student') }}">
                                    <span class="sub-item"> Students </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'admin.courses') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#courses">
                        <i class="fas fa-desktop"></i>
                        <p>Courses</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Str::startsWith(Route::currentRouteName(), 'admin.courses') ? 'show' : '' }}" id="courses">
                        <ul class="nav nav-collapse">
                            <li class="{{ Route::currentRouteName() === 'admin.courses.pendings' ? 'active' : '' }}">
                                <a href="{{ route('admin.courses.pendings') }}">
                                    <span class="sub-item"> Pendings </span>
                                </a>
                            </li>
                            <li class="{{ Route::currentRouteName() === 'admin.courses.versions' ? 'active' : '' }}">
                                <a href="{{ route('admin.courses.versions') }}">
                                    <span class="sub-item"> Versions </span>
                                </a>
                            </li>
                            <li class="{{ Route::currentRouteName() === 'admin.courses' ? 'active' : '' }}">
                                <a href="{{ route('admin.courses') }}">
                                    <span class="sub-item"> Courses </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'admin.enrollments') ? 'active' : '' }}">
                    <a href="{{ route('admin.enrollments') }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Enrollments</p>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'admin.categories') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories') }}">
                        <i class="fas fa-th"></i>
                        <p>Categories</p>
                    </a>
                </li>
                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">More</h4>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li> --}}
                {{--<li class="nav-item">
                    <a data-bs-toggle="collapse" href="#courses">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Courses</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="courses">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('ins.courses') }}">
                                    <span class="sub-item"> Overview </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ins.courses') }}">
                                    <span class="sub-item"> Analysis </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>--}}

                {{--<li class="nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-th-list"></i>
                        <p>Sidebar Layouts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="sidebar-style-2.html">
                                    <span class="sub-item">Sidebar Style 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="icon-menu.html">
                                    <span class="sub-item">Icon Menu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms">
                        <i class="fas fa-pen-square"></i>
                        <p>Forms</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="forms/forms.html">
                                    <span class="sub-item">Basic Form</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Tables</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="tables/tables.html">
                                    <span class="sub-item">Basic Table</span>
                                </a>
                            </li>
                            <li>
                                <a href="tables/datatables.html">
                                    <span class="sub-item">Datatables</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#maps">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Maps</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="maps/googlemaps.html">
                                    <span class="sub-item">Google Maps</span>
                                </a>
                            </li>
                            <li>
                                <a href="maps/jsvectormap.html">
                                    <span class="sub-item">Jsvectormap</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#charts">
                        <i class="far fa-chart-bar"></i>
                        <p>Charts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="charts/charts.html">
                                    <span class="sub-item">Chart Js</span>
                                </a>
                            </li>
                            <li>
                                <a href="charts/sparkline.html">
                                    <span class="sub-item">Sparkline</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../documentation/index.html">
                        <i class="fas fa-file"></i>
                        <p>Documentation</p>
                        <span class="badge badge-secondary">1</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#submenu">
                        <i class="fas fa-bars"></i>
                        <p>Menu Levels</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Level 1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>--}}
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
