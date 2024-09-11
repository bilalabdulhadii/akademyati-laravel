
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
                <li class="nav-item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
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
                <li class="nav-item">
                    <a target="_blank" href="{{ route('inbox.index') }}">
                        <i class="fas fa-envelope"></i>
                        <p>Messages</p>
                    </a>
                </li>
                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'ins.courses') ? 'active' : '' }}">
                    <a href="{{ route('ins.courses') }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'ins.analysis' ? 'active' : '' }}">
                    <a href="{{ route('ins.analysis') }}">
                        <i class="far fa-chart-bar"></i>
                        <p>Analysis</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
