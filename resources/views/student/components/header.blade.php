

<style>
    /* Progress bar container */
    .progress-container {
        width: 100%;
        background-color: #f3f3f3;
        height: 5px;
        position: absolute; /* Position it absolutely within the navbar */
        bottom: 0; /* Stick it to the bottom of the navbar */
        z-index: 1500;
    }

    /* Progress bar */
    .progress-bar {
        height: 5px;
        background-color: #4caf50;
        width: 0;
    }
</style>

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
                 {{-- <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Search ..." class="form-control" />
                </div> --}}
                <h5>{{ $progress->lectures_count }} / {{ $progress->completed_lectures }} Lectures - <b class="text-primary">({{ (int) $progress->progress_percentage }}%)</b></h5>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-icon">
                    <a class="nav-link" href="#">
                        <i class="fas fa-share"></i>
                    </a>
                </li>

                {{-- <li class="nav-item topbar-icon">
                    <a class="nav-link" href="#">
                        <i class="fas fa-heart"></i>
                    </a>
                </li> --}}

                <li class="nav-item topbar-text">
                    <a class="nav-link" href="{{ route('learning') }}">
                        My learning
                    </a>
                </li>

                {{--<li class="nav-item topbar-user">
                    <a class="nav-link profile-pic" href="">
                        <span class="profile-username">
                            <span class="fw-bold">My learning</span>
                        </span>
                    </a>
                </li>--}}
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="progress-container">
        <div class="progress-bar" style="width: {{ $progress->progress_percentage }}%;"></div> <!-- Set the progress bar width here -->
    </div>
</div>

