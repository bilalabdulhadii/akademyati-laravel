<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="" class="logo">
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
                {{-- Lebal --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Course Materials</h4>
                </li>
                {{-- Units --}}
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#unit1">
                        <i class="fa fa-folder-o"></i>
                        <p>Unit 1</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="unit1">
                        <ul class="nav nav-collapse">
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 1</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 2</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#unit2">
                        <i class="fa fa-folder-o"></i>
                        <p>Unit 2</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="unit2">
                        <ul class="nav nav-collapse">
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 1</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 2</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#unit3">
                        <i class="fa fa-folder-o"></i>
                        <p>Unit 3</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="unit3">
                        <ul class="nav nav-collapse">
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 1</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 2</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#unit4">
                        <i class="fa fa-folder-o"></i>
                        <p>Unit 4</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="unit4">
                        <ul class="nav nav-collapse">
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 1</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 2</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#unit5">
                        <i class="fa fa-folder-o"></i>
                        <p>Unit 5</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="unit5">
                        <ul class="nav nav-collapse">
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 1</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex justify-content-between" href="">
                                    <span class="sub-item">Lecture 2</span>
                                    <i class="fa fa-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
