
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo">
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
    <nav class="navbar navbar-header admin-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                        @if($contactNewMessages->count() > 0)
                            <span class="notification">{{ $contactNewMessages->count() }}</span>
                        @else
                            <span class=""></span>
                        @endif
                    </a>
                    <ul class="dropdown-menu messages-notif-box animated fadeIn"
                        aria-labelledby="messageDropdown">
                        <li>
                            <div class="dropdown-title d-flex justify-content-between align-items-center">
                                Messages
                                {{-- <a href="#" class="small">Mark all as read</a> --}}
                            </div>
                        </li>
                        <li>
                            <div class="message-notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    @if($contactNewMessages->count() > 0)
                                        @foreach($contactNewMessages as $contactNewMessage)
                                            <form action="{{ route('inbox.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="read_message">
                                                <input type="hidden" name="contact_id" value="{{ $contactNewMessage->id }}">
                                                <button type="submit" class="admin-header-message-btn">
                                                    <div class="">
                                                        <img class="avatar-sm rounded-circle" src="{{ asset('ins/assets/img/jm_denis.jpg') }}" alt="Img Profile"/>
                                                    </div>
                                                    <div class="header-message-details d-flex flex-column justify-content-between flex-grow-1">
                                                        <span class="text-start">{{ $contactNewMessage->contact->first_name }} {{ $contactNewMessage->contact->last_name }}</span>
                                                        <span class="text-start">{{ $contactNewMessage->formated_time }}</span>
                                                    </div>
                                                </button>
                                            </form>
                                        @endforeach
                                    @else
                                        <a>
                                            <div class="notif-content">
                                                <span class="block p-3"> No Messages </span>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" target="_blank" href="{{ route('inbox.index') }}">
                                See all messages<i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification">4</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                You have 4 new notification
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block"> New user registered </span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-icon notif-success">
                                            <i class="fa fa-comment"></i>
                                        </div>
                                        <div class="notif-content">
                              <span class="block">
                                Rahmad commented on Admin
                              </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img">
                                            <img
                                                src="{{ asset('ins/assets/img/profile2.jpg') }}"
                                                alt="Img Profile"
                                            />
                                        </div>
                                        <div class="notif-content">
                              <span class="block">
                                Reza send messages to you
                              </span>
                                            <span class="time">12 minutes ago</span>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-icon notif-danger">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block"> Farrah liked Admin </span>
                                            <span class="time">17 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);"
                            >See all notifications<i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a
                        class="nav-link"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false"
                    >
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Quick Actions</span>
                            <span class="subtitle op-7">Shortcuts</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-danger rounded-circle">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <span class="text">Calendar</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-warning rounded-circle"
                                            >
                                                <i class="fas fa-map"></i>
                                            </div>
                                            <span class="text">Maps</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-info rounded-circle">
                                                <i class="fas fa-file-excel"></i>
                                            </div>
                                            <span class="text">Reports</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-success rounded-circle"
                                            >
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span class="text">Emails</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-primary rounded-circle"
                                            >
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </div>
                                            <span class="text">Invoice</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div
                                                class="avatar-item bg-secondary rounded-circle"
                                            >
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <span class="text">Payments</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>  --}}

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            @if(Auth::user()->profile)
                                <img src="{{ Storage::url(Auth::user()->profile) }}" alt="profile image" class="avatar-img rounded-circle"/>
                            @else
                                <p class="profile-initial-dash avatar-img rounded-circle">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}</p>
                            @endif
                        </div>
                        <span class="profile-username">
                            <span class="fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        @if(Auth::user()->profile)
                                            <img src="{{ Storage::url(Auth::user()->profile) }}" alt="Profile image" class="avatar-img rounded"/>
                                        @else
                                            <h1 class="avatar-img rounded bg-dark text-white d-flex align-items-center justify-content-center">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}</h1>
                                        @endif
                                    </div>
                                    <div class="u-text">
                                        <h4>Emma Meruem</h4>
                                        <p class="text-muted">{{ Auth::user()->username }}</p>
                                        {{-- <a href="{{ route('ins.profile', ['username' => Auth::user()->username]) }}" class="btn btn-xs btn-secondary btn-sm">View Profile</a> --}}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('ins.profile', ['username' => Auth::user()->username]) }}">My Profile</a>
                                {{-- <a class="dropdown-item" href="#">My Balance</a> --}}
                                <a class="dropdown-item" target="_blank" href="{{ route('inbox.index') }}">Inbox</a>
                                {{-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Account Setting</a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item">
                                    <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="dropdown-item p-0">Logout</button>
                                    </form>
                                </a>

                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
