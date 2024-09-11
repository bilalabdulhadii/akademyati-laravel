
<style>
    .username-profile-menu {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }
    .username-profile-menu .dropdown-item {
        color: #333;
        border-radius: 5px;
    }

    .username-profile-menu .dropdown-item:hover {
        color: #000;
        background-color: #e9ecef;
    }

    .username-profile-menu .dropdown-item.active,
    .username-profile-menu .dropdown-item:focus {
        color: #696cff;
        background-color: #e2e6ea;
    }
</style>


<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="">
        <div class="row">
            <div class="col-12 p-0">
                <nav class="main-nav bg-light">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{route('home')}}" class="logo">
                        <img src="{{ asset('assets/home/images/akademyati.png') }}" alt="Akademyati"> {{--{{ Storage::url(Auth::user()->profile) }}--}}
                    </a>
                    <!-- ***** Logo End ***** -->

                    <!-- ***** Search End ***** -->
                    <div class="search-input">
                        <form id="search" action="#">
                            <input type="text" placeholder="Type Anything" id='searchText' name="searchKeyword" onkeypress="handle" />
                            <i class="fa fa-search"></i>
                        </form>
                    </div>
                    <!-- ***** Search End ***** -->

                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        {{-- <li>
                            <div class="search-input">
                                <form id="search" action="#">
                                    <input type="text" placeholder="Type Anything" id='searchText' name="searchKeyword" onkeypress="handle" />
                                    <i class="fa fa-search"></i>
                                </form>
                            </div>
                        </li> --}}
                        <li class="explore-mega-item">
                            <a href="{{ route('courses.index') }}" class="nav-bar-a {{ Route::currentRouteName() == 'courses.index' ? 'active' : '' }}">Explore</a>

                            <div class="tooltip explore-mega-dropdown">
                                <div class="explore-dropdown-content">
                                    <div class="row w-100">
                                        @foreach($categoriesList as $main => $category)
                                            @if($main < 6)
                                                <div class="col-lg-2 category-column">
                                                    <h4 class="category-title">{{ $category->title }}</h4>
                                                    <hr class="my-1">
                                                    @if($category->children->count() > 0)
                                                        <ul class="subcategory-list">
                                                            @foreach($category->children as $index => $subCategory)
                                                                @if($index < 6)
                                                                    <li><a href="{{ route('courses.index') }}?category={{ Str::slug($subCategory->title) }}">{{ $subCategory->title }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- <div class="col-lg-2 category-column">
                                            <h4 class="category-title">Category 2</h4>
                                            <ul class="subcategory-list">
                                                <li><a href="#">Subcategory 2.1</a></li>
                                                <li><a href="#">Subcategory 2.2</a></li>
                                                <li><a href="#">Subcategory 2.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-2 category-column">
                                            <h4 class="category-title">Category 3</h4>
                                            <ul class="subcategory-list">
                                                <li><a href="#">Subcategory 3.1</a></li>
                                                <li><a href="#">Subcategory 3.2</a></li>
                                                <li><a href="#">Subcategory 3.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-2 category-column">
                                            <h4 class="category-title">Category 4</h4>
                                            <ul class="subcategory-list">
                                                <li><a href="#">Subcategory 4.1</a></li>
                                                <li><a href="#">Subcategory 4.2</a></li>
                                                <li><a href="#">Subcategory 4.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-2 category-column">
                                            <h4 class="category-title">Category 4</h4>
                                            <ul class="subcategory-list">
                                                <li><a href="#">Subcategory 4.1</a></li>
                                                <li><a href="#">Subcategory 4.2</a></li>
                                                <li><a href="#">Subcategory 4.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-2 category-column">
                                            <h4 class="category-title">Category 4</h4>
                                            <ul class="subcategory-list">
                                                <li><a href="#">Subcategory 4.1</a></li>
                                                <li><a href="#">Subcategory 4.2</a></li>
                                                <li><a href="#">Subcategory 4.3</a></li>
                                            </ul>
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </li>
                        @if(Auth::user())
                        @if(Auth::user()->hasRole('student'))
                            <li><a href="{{ route('learning') }}" class="nav-bar-a {{ Route::currentRouteName() == 'learning' ? 'active' : '' }}">My Learning</a></li>
                        @elseif(Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor'))
                            <li><a href="{{ route('dashboard') }}" class="nav-bar-a">Dashboard</a></li>
                        @endif
                            {{-- <li>
                                <a href=""> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                     --}}{{--<img src="{{ asset('assets/home/images/profile-header.jpg') }}" alt="">--}}{{--
                                    <p class="profile-initial">{{ substr(Auth::user()->first_name, 0, 1) }}</p>
                                </a>
                            </li> --}}
                            <li class="username-profile-alt1">
                                <a class="username-profile" href="{{ route('std.profile', ['username' => Auth::user()->username]) }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                            </li>
                            <li class="dropdown username-profile-alt2">
                                <a href="#" id="profileDropdown" class="username-profile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    @if(Auth::user()->profile)
                                        <img class="profile-initial" src="{{ Storage::url(Auth::user()->profile) }}" alt="profile">
                                    @else
                                        <p class="profile-initial">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}</p>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn mt-2 username-profile-menu">
                                    <li class="w-100">
                                        @if(Auth::user()->hasRole('student'))
                                            <a class="dropdown-item" href="{{ route('std.profile', ['username' => Auth::user()->username]) }}">My Profile</a>
                                        @elseif(Auth::user()->hasRole('instructor'))
                                            <a class="dropdown-item" href="{{ route('ins.profile', ['username' => Auth::user()->username]) }}">My Profile</a>
                                        @elseif(Auth::user()->hasRole('admin'))
                                            <a class="dropdown-item" href="{{ route('admin.profile', ['username' => Auth::user()->username]) }}">My Profile</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('inbox.index') }}">Inbox</a>
                                        {{--@if(Auth::user()->hasRole('admin'))
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a>
                                        @endif--}}
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item">
                                            <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                                                @csrf
                                                <button type="submit" class="dropdown-item p-0">Logout</button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="ins-tool-item">
                                <a class="nav-bar-a" href="{{ route('instructors') }}">For Instructors</a>
                                <div class="tooltip ins-tooltip">
                                    <div class="tooltip-content">
                                        <p>Explore resources for instructors</p>
                                        <a href="{{ route('instructors') }}" class="btn btn-sm mt-3">About Instructors</a>
                                    </div>
                                </div>
                            </li>
                            <li class="username-profile-alt1">
                                <a class="username-login" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="username-profile-alt2 mt-1"><a class="username-login" href="{{ route('login') }}">Login</a></li>
                        @endif
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->
