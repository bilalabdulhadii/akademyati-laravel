
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a class="logo">
                <img src="{{ asset('dash/assets/img/logo_light.svg') }}"
                    alt="navbar brand" class="navbar-brand" height="20" />
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
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                {{-- <li class="nav-item topbar-icon">
                    <a class="nav-link" href="#">
                        <i class="fas fa-share"></i>
                    </a>
                </li>

                <li class="nav-item topbar-icon">
                    <a class="nav-link" href="#">
                        <i class="fas fa-heart"></i>
                    </a>
                </li>

                <li class="nav-item topbar-text">
                    <a class="nav-link" href="{{ route('learning') }}">
                        My learning
                    </a>
                </li> --}}
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>

